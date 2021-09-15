<?php

namespace App\Jobs;

use App\Google\Services\Analytics\DfaReader;
use App\Models\User;
use App\Notifications\NPIActivityExportReadyNotification;
use App\Traits\CheckCampaignManagerLimits;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\FloodLightActivity;


class ProcessDFAFloodLightReportWhenReady implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CheckCampaignManagerLimits;

    public $team;
    public $userId;
    public $reportId;
    public $fileId;
    public $start_date;
    public $end_date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($team, $userId, $reportId, $fileId, $start_date, $end_date)
    {
        $this->team = $team;
        $this->userId = $userId;
        $this->reportId = $reportId;
        $this->fileId = $fileId;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DfaReader $reader)
    {

        $created_at = $updated_at = date('Y-m-d H:i:s');

        if(!$this->checkIfLimited()) {
            try {

                $status = $reader->getFileStatus($this->reportId, $this->fileId);


                if ($status === 'REPORT_AVAILABLE') {

                    $data = $reader->directDownloadFileReturnedAsCollection($this->reportId, $this->fileId);

                    foreach ($data as $d) {

                        //echo "<pre>"; print_r($d); exit();

                        $npi = '';
                        $date = '';
                        if(preg_match('/AV Generated Placement - Npi - (.+)$/',$d['Placement'],$matches)){
                            if(isset($matches[1]))
                                $npi = $matches[1];
                        }

                        if (!empty($d['Date'])) {
                            $date = date('Y-m-d h:i:s', strtotime($d['Date']));
                        }
                        FloodLightActivity::create([
                            'team_id' => $this->team->id,
                            'npi' => $npi,
                            'site' => $d['Site (CM360)'],
                            'placement' => $d['Placement'],
                            'activity' => $d['Activity'],
                            'view_through_conversions' => $d['View-through Conversions'],
                            'click_through_conversions' => $d['Click-through Conversions'],
                            'date' => $date,
                            'created_at' => $created_at,
                            'updated_at' => $updated_at
                        ]);
                    }

                } elseif ($status !== 'PROCESSING') {

                    Log::debug('File status is no longer processing but failed:' . $status);

                    $this->fail(new \Exception("DFAFloodLightReport File Status reported from google as '$status'.
                            Expected processing or report_available. FileId: ". $this->fileId ." ReportId:".$this->fileId));

                } else{

                    if($this->attempts() < $this->tries) {

                        Log::debug('ProcessDFAFloodLightReportWhenReady Job is going to sleep for: '.$this->backoff()[$this->attempts()]);
                        $this->release($this->backoff()[$this->attempts()]);

                    }else{

                        $this->fail(new \Exception("DFAFloodLightReport File Status was not marked as available within the number of tries allowed.
                            FileId: ". $this->fileId ." ReportId:".$this->fileId));

                    }
                }
            } catch (\Google\Exception $e) {

                $this->handleGoogleException($e);

            }
        }
    }

    public function backoff ()
    {
        // for testing
        //return [1,2,3,4,5,6,7];

        return [1, 600, 3000, 6000, 12000, 24000, 48000];
    }

    public function retryUntil()
    {
        return now()->addDay();
    }
}
