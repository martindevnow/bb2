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

    // EXAMPLE: Testing Mailables, Testing Mail
    /** @test */
    public function a_guest_can_fill_in_the_form_to_email_staff() {
        Mail::fake();

        $request = [
            'name'  => 'Ben',
            'email' => 'benm@barfbento.com',
            'subject'   => 'hello',
            'body'  => 'This is the body of the message.'
        ];

        // EXAMPLE: This is how we can test redirects will work as expected
        $response = $this->post('/contact/send', $request)
            ->assertStatus(302)             // PASSES
            ->assertRedirect('/contact/success');

        $this->followRedirects($response)
            ->assertSee('Thank you.');


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
