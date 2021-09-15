<?php

namespace App\Jobs;

use App\Google\Services\Analytics\DfaReader;
use App\Traits\CheckCampaignManagerLimits;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDFACreativeAssociation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CheckCampaignManagerLimits;

    public $creative_id;

    public $campaign_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($creative_id, $campaign_id)
    {
        $this->creative_id = $creative_id;
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

                $reader->insertCreativeAssociation($this->creative_id, $this->campaign_id);

            } catch (\Google\Exception $e) {

                $this->handleGoogleException($e);

            }
        }

    }
}
