<?php

namespace Tests\Unit\Core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\Core\Faq;
use Martin\Core\FaqCategory;
use Tests\TestCase;

class FaqCategoriesUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function faq_categories_have_a_model_factory() {
        $faq = factory(FaqCategory::class)->create();
        $this->assertTrue($faq instanceof FaqCategory);
    }

    /** @test */
    public function faq_categories_have_the_following_fields_mass_assignable() {
        $faq = factory(FaqCategory::class)->create([
            'code'  => 'CODE',
            'label' => 'LABEL',
        ]);

        $this->assertEquals('CODE', $faq->code);
        $this->assertEquals('LABEL', $faq->label);
    }

    /**
     * FAQs
     */

    /** @test */
    public function a_faq_cateogry_can_have_many_faqs() {
        $faq = factory(Faq::class, 5)->create();
        $faq_category = factory(FaqCategory::class)->create();

        $faq_category->faqs()->save($faq[0]);
        $faq_category->faqs()->save($faq[1]);

        $faq_category = $faq_category->fresh(['faqs']);

        $this->assertCount(2, $faq_category->faqs);
    }

    /** @test */
    public function a_faq_cateogry_can_associate_faqs_to_itself() {
        $faq = factory(Faq::class, 5)->create();
        $faq_category = factory(FaqCategory::class)->create();

        $faq_category->addFaq($faq[0]);
        $faq_category->addFaq($faq[1]->id);
        $faq_category->addFaq($faq[2]->code);

        $this->assertFalse($faq_category->addFaq(true));

        $faq_category = $faq_category->fresh(['faqs']);

        $this->assertCount(3, $faq_category->faqs);
    }
}
