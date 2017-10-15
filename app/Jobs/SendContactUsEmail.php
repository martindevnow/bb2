<?php

namespace App\Jobs;

use App\Mail\ContactReceived;
use App\Mail\ContactReceivedConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendContactUsEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var
     */
    private $contactUsData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contactUsData)
    {
        $this->contactUsData = $contactUsData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('info@barfbento.com')
            ->cc('benm@barfbento.com')
            ->send(new ContactReceived($this->contactUsData));

        if ($this->contactUsData['email']) {
            Mail::to($this->contactUsData['email'])
                ->send(new ContactReceivedConfirmation($this->contactUsData));
        }
    }
}
