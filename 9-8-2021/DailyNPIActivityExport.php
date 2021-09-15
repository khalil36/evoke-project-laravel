<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\processDFAFloodLightReporting;
use App\Notifications\testEmail;
use App\Models\Team;
use App\Models\User;

class DailyNPIActivityExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NPIActivityExport:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the NPI Activity Export for each active team daily.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find(1);

        //$activities = array(11610200, 11611055, 11611058, 11634940, 11651391);

        $teams = Team::where('is_active', 1)->get();

        foreach ($teams as $team) {
     
             if (!empty($team->flight_start_date)) {
         
                $start_date = date('Y-m-d', strtotime('-1 days'));
                $end_date = date('Y-m-d', strtotime('-1 days'));
                //$user->notify(new testEmail($start_date, $end_date));

                // Job call.
                //ProcessDFAFloodLightReporting::dispatch($team, Auth::user()->id, $activities, $start_date, $end_date);
            }
        }

        $this->info('Successfully sent email.');
        
    }
}


