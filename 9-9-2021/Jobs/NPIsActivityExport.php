<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\NPIActivityExportReadyNotification;
use App\Models\FloodLightActivity;
use App\Google\Services\Analytics\DfaReader;
use Illuminate\Support\Facades\App;
use App\Models\Team;
use App\Models\User;


class NPIsActivityExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $team_id;
    public $start_date;
    public $end_date;
    public $user_id;
    public $flood_light_activity_ids = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $team_id, $user_id, $flood_light_activity_ids, $start_date, $end_date)
    {
        $this->team_id = $team_id;
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
    public function handle()
    {

        $reader = App::make(DfaReader::class);
        $team = Team::find($this->team_id);

        $activity_names = [];
        $activities = $reader->listFloodLightActivities($team);

        if ($activities ) {
            foreach ($activities as $activity) {

                if (in_array($activity->id, $this->flood_light_activity_ids)) {
                    $activity_names[] = $activity->name;
                }

            }
        }

        $rows = FloodLightActivity::where('team_id', $this->team_id)->whereBetween('date', [$this->start_date, $this->end_date])->whereIn('activity', $activity_names)->get();

        $filename = 'NPIs_Activity_Export_from_'. $this->start_date . '_to_'.$this->end_date;
        $File = fopen(storage_path("reports/".$filename), 'w');

        //state headers / column names for the csv
        $headers = array('Site','Placement','NPI','Date','Activity','View-through Conversions','Click-through Conversions');

        //write the headers to the opened file
        fputcsv($File, $headers);

        //parse rows to get rows
        foreach ($rows as $row) {
            $npi = '';
            if(preg_match('/AV Generated Placement - Npi - (.+)$/', $row->Placement, $matches)){
                if(isset($matches[1]))
                    $npi = $matches[1];
            }

            $row_data = array(
                    $row->site,
                    $row->placement,
                    $npi,
                    $row->date,
                    $row->activity,
                    $row->view_through_conversions,
                    $row->click_through_conversions,
                );

            //write the rows to the opened file;
            fputcsv($File, $row_data);
        }
        fclose($File);

        $user = User::find($this->user_id);

        $user->notify(new NPIActivityExportReadyNotification($team, $this->start_date, $this->end_date, storage_path("reports/".$filename)));
    }
}
