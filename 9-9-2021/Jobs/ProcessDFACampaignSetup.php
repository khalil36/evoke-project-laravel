<?php

namespace App\Jobs;

use App\Google\Services\Analytics\DfaReader;
use App\Models\Npis;
use App\Models\Team;
use App\Models\VirtualDFACampaign;
use App\Traits\CheckCampaignManagerLimits;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessDFACampaignSetup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CheckCampaignManagerLimits;

    private $team;

    private $virtual_campaign;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Team $team, VirtualDFACampaign $virtual_campaign)
    {
        $this->team = $team;
        $this->virtual_campaign = $virtual_campaign;
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

                $this->virtual_campaign->save($reader, $this->team);

                //Log::debug("DFACampaignSetup Called");

            } catch (\Google\Exception $e) {

                $this->handleGoogleException($e);

            }
        }

    }
}
