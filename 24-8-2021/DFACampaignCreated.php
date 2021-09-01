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
        
        $boolean = $this->argument('flag');
        //$this->info("Second parameter $boolean." );
       // if (is_bool($boolean)) {
            
            $team = Team::find($this->argument('team'));

            if ($team) {
                $this->info("The boolean for team '$team->name' has been set to $boolean." );
            } else {
                $this->error("The team you are looking for does not exist." );
            }

        // } else {
        //     $this->error("Please provide a boolean in second parameter." );
        // }

    }
}
