<?php

namespace App\Jobs;

use App\Google\Services\Analytics\DfaReader;
use App\Models\Npis;
use App\Models\Team;
use App\Models\VirtualDFAAd;
use App\Models\VirtualDFACampaign;
use App\Models\VirtualDFACreative;
use App\Models\VirtualDFAPlacement;
use App\Traits\CheckCampaignManagerLimits;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ProcessDFACampaignCollection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CheckCampaignManagerLimits;

    private $team;

    private $creatives;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Team $team, array $creatives)
    {
        $this->team = $team;
        $this->creatives = $creatives;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DFAReader $reader)
    {
        if (!$this->checkIfLimited()) {
            try {
                $team = $this->team;
                $partners = $team->MediaPartners()->get();
                $npis = Npis::where('team_id', $team->id)->get();

                $campaign_counter = 1;
                $placement_count = 0;
                $count = 0;

                $break = false;
                $campaign_collection = [];
                $current_campaign = new VirtualDFACampaign();
                $d = date("m.d.Y");
                $current_campaign->name = "AV Generated Campaign $d Team (" . $team->id . "_". env('APP_PREFIX') .") - " . $campaign_counter;

                foreach ($npis as $npi) {

                    foreach ($partners as $partner) {

                        if ($placement_count % 1000 == 0 && $placement_count != 0) {
                            $campaign_counter++;
                            $campaign_collection[] = $current_campaign;
                            $current_campaign = new VirtualDFACampaign();
                            $current_campaign->name = "AV Generated Campaign $d Team (" . $team->id . "_". env('APP_PREFIX') .") - " . $campaign_counter;
                            //These two breaks are used for debugging.
                            //$break = true;
                            //break;
                        }

                        $siteid = $reader->getSiteIdFromName($partner->dfa_site);


                        if ($siteid) {
                            $vp = new VirtualDFAPlacement();
                            $vp->name = "AV Generated Placement - Npi - " . $npi->npi;
                            $placement_count++;
                            $va = new VirtualDFAAd();
                            $va->name = "AV Generated Ad - $npi->npi";
                            foreach ($this->creatives as $creativeid) {
                                $creative = $reader->getCreative($creativeid);
                                $count++;

                                $vc = new VirtualDFACreative();
                                $vc->id = $creative->id;
                                $vc->name = $creative->name;
                                $vc->url = $team->website .
                                    "?utm_source=" . $partner->dfa_site
                                    . "&utm_medium=banner"
                                    . "&utm_campaign=" . $npi->npi
                                    . "&utm_term=AV"
                                    . "&utm_content=" . $creative->name;

                                $va->addCreative($vc);

                                $vp->site_id = $siteid;
                                $vp->addSizeId($creative->size->id);

                            }
                            $vp->addAd($va);
                            $current_campaign->addPlacement($vp);
                        }

                    }
                    if ($break) {
                        break;
                    }
                }
                //add the last campaign to the collection
                if ($current_campaign->getPlacementCount() > 0)
                    $campaign_collection[] = $current_campaign;

                foreach ($campaign_collection as $c) {
                    // dispatch the setup job for every campaign created.
                    ProcessDFACampaignSetup::dispatch($team, $c);
                }
            } catch (\Google\Exception $e) {

                $this->handleGoogleException($e);

            }
        }
    }
}
