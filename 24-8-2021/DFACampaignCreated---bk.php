<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Team;

class DFACampaignCreated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dfa:campaigns-created-flag
                            {team : The ID of the team}
                            {flag : true or false}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will be use to check a created campaign against a team';

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
        $campaigns_created = 0;
        if ($this->argument('flag') == 'true') {
            $campaigns_created = 1;
        }

       // $team = Team::where(['id'=> $this->argument('team'), 'dfa_campaigns_created' => $campaigns_created])->first();
        $team = Team::find($this->argument('team'));
        if ($team) {

            $team->dfa_campaigns_created = $campaigns_created;
            $team->updated_at   = date('Y-m-d h:i:s');

            if ($team->save()) {
                $this->info("Team '$team->name' has been updated successfully!" );
            } else {
                $this->error("The team is not updated" );
            }

        } else {
            $this->error("The team you are looking for does not exists." );
        }

        //dd($team);
    }
}
