<?php

namespace Tests\Unit\Core;

use Martin\Core\Faq;
use Martin\Core\FaqCategory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FaqsUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function faqs_have_a_model_factory() {
        $faq = factory(Faq::class)->create();
        $this->assertTrue($faq instanceof Faq);
    }

    /** @test */
    public function faqs_have_the_following_fields_mass_assignable() {
        $faq = factory(Faq::class)->create([
            'code'  => 'CODE',
            'question'  => 'QUESTION',
            'answer'    => 'ANSWER',
        ]);

        $this->assertEquals('CODE', $faq->code);
        $this->assertEquals('QUESTION', $faq->question);
        $this->assertEquals('ANSWER', $faq->answer);
    }

    /**
     * Categories
     */

    /** @test */
    public function faqs_belong_to_a_faq_category_entity() {
        $faq = factory(Faq::class)->create();
        $faq_category = factory(FaqCategory::class)->create();

        $faq_category->faqs()->save($faq);

        $faq = $faq->fresh(['category']);
        $this->assertEquals($faq_category->id, $faq->category->id);
    }

    /** @test */
    public function faqs_can_change_their_category_by_model() {
        $faq = factory(Faq::class)->create();
        $faq_category = factory(FaqCategory::class, 2)->create();

        $faq->assignCategory($faq_category[0]);
        $faq = $faq->fresh(['category']);

        $faq->assignCategory($faq_category[1]);
        $faq = $faq->fresh(['category']);

        $this->assertEquals($faq_category[1]->id, $faq->category->id);
    }

    /** @test */
    public function faqs_can_change_their_category_by_code() {
        /** @var Faq $faq */
        $faq = factory(Faq::class)->create();
        $faq_category = factory(FaqCategory::class, 2)->create();

        $faq->assignCategory($faq_category[0]->code);
        $faq = $faq->fresh(['category']);

        $faq->assignCategory($faq_category[1]->code);
        $this->assertFalse($faq->assignCategory(true));
        $faq = $faq->fresh(['category']);

        $this->assertEquals($faq_category[1]->id, $faq->category->id);
    }

    /** @test */
    public function faqs_can_change_their_category_by_id() {
        $faq = factory(Faq::class)->create();
        $faq_category = factory(FaqCategory::class, 2)->create();

        $faq->assignCategory($faq_category[0]->id);
        $faq = $faq->fresh(['category']);

        $faq->assignCategory($faq_category[1]->id);
        $faq = $faq->fresh(['category']);

        $this->assertEquals($faq_category[1]->id, $faq->category->id);

        $faq_category[0] = $faq_category[0]->fresh(['faqs']);
        $this->assertCount(0, $faq_category[0]->faqs);
        $this->assertCount(1, $faq_category[1]->faqs);
    }

}
