<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Martin\Core\FaqCategory;

class WebhooksController extends Controller
{
    public function __construct() {}

    /**
     * Handle the WebHook from Stripe
     */
    public function handle() {
        $payload = request()->all();

        if (method_exists($this, $method = $this->eventToMethod($payload['type']))) {
            $this->$method($payload);
        }
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
}
