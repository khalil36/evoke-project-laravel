<?php

namespace App\Jobs;

use App\Google\Services\Analytics\DfaReader;
use App\Models\Team;
use App\Models\VirtualDFAAd;
use App\Models\VirtualDFAPlacement;
use App\Traits\CheckCampaignManagerLimits;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDFAAd implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CheckCampaignManagerLimits;

    public $ad;

    public $team;

    public $placement_id;

    public $campaign_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Team $team, VirtualDFAAd $ad, int $campaign_id, int $placement_id)
    {
        $this->team = $team;
        $this->ad = $ad;
        $this->placement_id = $placement_id;
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

                $this->ad->save($reader, $this->team, $this->campaign_id, $this->placement_id);

            } catch (\Google\Exception $e) {

                $this->handleGoogleException($e);

            }
        }

    }
}
