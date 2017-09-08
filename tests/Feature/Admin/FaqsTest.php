<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\Core\Faq;
use Tests\TestCase;

class FaqsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_is_redirected_from_admin_faqs_page() {
        $faq = factory(Faq::class)->create();

        $this->get('/admin/faqs')                  // index
            ->assertStatus(302);

        $this->get('/admin/faqs/create')           // create
            ->assertStatus(302);

        $this->get('/admin/faqs/' . $faq->id)     // show
            ->assertStatus(302);

        $this->get('/admin/faqs/' . $faq->id . '/edit')     // edit
            ->assertStatus(302);

        $this->post('/admin/faqs')                 // store
            ->assertStatus(302);

        $this->patch('/admin/faqs/' . $faq->id)   // update
            ->assertStatus(302);

        $this->delete('/admin/faqs/' . $faq->id)  // delete
            ->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_visit_the_admin_faqs_page() {
        $this->loginAsAdmin();
        $this->assertTrue($this->user->isAdmin());

        $this->get('/admin/faqs')   // INDEX method
            ->assertStatus(200);
    }

    /** @test */
    public function an_admin_can_see_existing_faqs_on_the_index() {
        $faq = factory(Faq::class)->create();
        $this->loginAsAdmin();

        $this->get('/admin/faqs')   // INDEX method
            ->assertSee($faq->code);
    }

    /** @test */
    public function an_admin_can_view_a_single_faq() {
        $this->loginAsAdmin();

        $faq = factory(Faq::class)->create();

        $this->get('/admin/faqs/' . $faq->id)     // SHOW method
            ->assertSee($faq->code)
            ->assertSee($faq->question)
            ->assertSee($faq->answer);
    }

    /** @test */
    public function an_admin_can_see_the_form_to_add_a_faq() {
        $this->loginAsAdmin();

        $this->get('/admin/faqs/create')    // CREATE method
            ->assertStatus(200)
            ->assertSee('<form');
    }

    /** @test */
    public function an_admin_can_submit_a_form_to_add_a_faq() {
        $this->loginAsAdmin();

        $faq = factory(Faq::class)->make();

        $request = $faq->toArray();
        $request['_token'] = csrf_token();
        $this->post('/admin/faqs', $request) // STORE method
        ->assertStatus(302);

        $this->assertDatabaseHas('faqs', $faq->toArray());
    }

    /** @test */
    public function an_admin_can_edit_a_faq() {
        $this->loginAsAdmin();

        $faq = factory(Faq::class)->create();

        $this->get('/admin/faqs/' . $faq->id . '/edit')   // EDIT method
            ->assertStatus(200)
            ->assertSee('<form')
            ->assertSee($faq->code);
    }

    /** @test */
    public function an_admin_can_save_changes_to_a_faq() {
        $this->loginAsAdmin();

        $faq = factory(Faq::class)->create();
        $id = $faq->id;

        $post_data = $faq->toArray();
        unset($post_data['id']);

        $post_data['code'] = 'NEW_CODE';
        $post_data['_method'] = 'PATCH';

        $this->post('/admin/faqs/'. $id, $post_data)   // UPDATE method
        ->assertStatus(302);
        $this->assertDatabaseHas('faqs', [
            'code' => $post_data['code'],
            'question' => $post_data['question'],
            'id' => $id
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_faq_from_the_db() {
        $this->loginAsAdmin();

        $faq = factory(Faq::class)->create();
        $id = $faq->id;

        $post_data = [
            '_method' => 'DELETE',
        ];

        $this->post('/admin/faqs/'. $id, $post_data)   // UPDATE method
        ->assertStatus(302);
        $this->seeIsSoftDeletedInDatabase('faqs', [
            'id' => $id
        ]);
    }
}
