<?php

namespace Tests\Feature\Web;

use App\Mail\ContactReceived;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function a_guest_can_see_contact() {
        $this->get('/contact')
            ->assertStatus(200);
    }

    /** @test */
    public function a_guest_can_fill_in_the_form_to_email_staff() {
        Mail::fake();

        $request = [
            'name'  => 'Ben',
            'email' => 'benm@barfbento.com',
            'subject'   => 'hello',
            'body'  => 'This is the body of the message.'
        ];

        $this->post('/contact/send', $request)
            ->assertStatus(302);


        Mail::assertSent(ContactReceived::class, function ($mail) use ($request) {
            return $mail->contactFormFields['name'] == $request['name'];
        });


        // Assert a message was sent to the given users...
        Mail::assertSent(ContactReceived::class, function ($mail) {
            return $mail->hasTo('info@barfbento.com') &&
                $mail->hasCc('benm@barfbento.com');
        });
    }
}
