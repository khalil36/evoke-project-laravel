<?php

namespace App\Jobs;

use App\Google\Services\Analytics\DfaReader;
use App\Models\Team;
use App\Models\User;
use App\Notifications\NPIActivityExportReadyNotification;
use App\Traits\CheckCampaignManagerLimits;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class processDFAFloodLightReporting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CheckCampaignManagerLimits;

    public $team;
    public $start_date;
    public $end_date;
    public $user_id;
    public $flood_light_activity_ids = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Team $team, $user_id, $flood_light_activity_ids, $start_date, $end_date)
    {
        $this->team = $team;
        $this->user_id = $user_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->flood_light_activity_ids = $flood_light_activity_ids;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DfaReader $reader)
    {
        if(!$this->checkIfLimited()) {
            try {

                $configIds = $reader->convertActivityIDstoConfigurationIDs($this->team, $this->flood_light_activity_ids);

                foreach ($configIds as $configId) {

                    $reader->getFloodLightReportUsingJobs($this->team, $this->user_id, $this->start_date, $this->end_date, $configId);

                }

            } catch (\Google\Exception $e) {

                $this->handleGoogleException($e);

            }
        }

    }
}
