<?php

namespace App\Jobs;

use App\Google\Services\Analytics\DfaReader;
use App\Models\Team;
use App\Models\VirtualDFAPlacement;
use App\Traits\CheckCampaignManagerLimits;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ProcessDFAPlacement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CheckCampaignManagerLimits;

    public $team;

    public $placement;

    public $campaign_id;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Team $team, VirtualDFAPlacement $placement, int $campaign_id)
    {
        $this->team = $team;
        $this->placement = $placement;
        $this->campaign_id = $campaign_id;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DFAReader $reader)
    {

        //Before an api call we should probably check the cache for a too many request hit.
        if(!$this->checkIfLimited()) {
            try {

                $this->placement->save($reader, $this->team, $this->campaign_id);

            } catch (\Google\Exception $e) {

                $this->handleGoogleException($e);

            }
        }
    }

}
