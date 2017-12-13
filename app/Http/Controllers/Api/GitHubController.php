<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GitHubController extends Controller
{
    public function __construct() {}

    /**
     * Handle the WebHook from Stripe
     */
    public function handle(Request $request) {
        Log::info($request->all());

        $requestData = $request->all();
        if ($requestData['ref'] === env('GITHUB_REF')
            && $requestData['repository']['full_name'] === env('GITHUB_FULL_NAME', 'martindevnow/bb2')
        ) {
            echo (`bash ../Martin/update.sh`);
            echo (`echo "v1.0.1" >> version.html`);
            return 'gotcha';
        }

        return "This branch for this Repo is not being deployed.";
    }

    /**
     * Cancel a subscription in the system
     *
     * @param $stripeEvent
     * @return string
     */
    public function eventToMethod($stripeEvent) {
        return 'when' . studly_case(str_replace('.', '_', $stripeEvent));
    }

    /**
     * @param $payload
     */
    public function whenCustomerSubscriptionDeleted($payload) {
        dd ($payload);
    }
}
