<?php

use Illuminate\Database\Seeder;
use Martin\Subscriptions\ActivityLevel;
use Martin\Subscriptions\Frequency;
use Martin\Subscriptions\Package;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * FAQ Categories
         */

        $barf = \Martin\Core\FaqCategory::create([
            'code'  => 'barf',
            'label' => 'B.A.R.F.',
        ]);
        $meat = \Martin\Core\FaqCategory::create([
            'code'  => 'meat',
            'label' => 'Meat',
        ]);

        $shipping = \Martin\Core\FaqCategory::create([
            'code'  => 'shipping',
            'label' => 'Shipping'
        ]);

        $payments = \Martin\Core\FaqCategory::create([
            'code'  => 'payments',
            'label' => 'Payments'
        ]);
        $pet = \Martin\Core\FaqCategory::create([
            'code'  => 'my-pet',
            'label' => 'My Pet'
        ]);


        /**
         * FAQs
         */

        $faq = \Martin\Core\Faq::create([
            'code'  => 'where-source-meat',
            'question'  => 'Where is your meat sourced from?',
            'answer'    => 'Our meat is sourced from happy places with great animals that live free and eat only the good stuff!'
        ]);
        $meat->faqs()->save($faq);


        $faq = \Martin\Core\Faq::create([
            'code'  => 'where-ship-to',
            'question'  => 'Where do you ship to?',
            'answer'    => 'Currently, shipping is available to areas located within Toronto. For more information, please visit our /shipping page.'
        ]);
        $shipping->faqs()->save($faq);


        $faq = \Martin\Core\Faq::create([
            'code'  => 'where-o',
            'question'  => 'This is another question',
            'answer'    => 'Currently, shipping is available to areas located within Toronto. For more information, please visit our /shipping page.'
        ]);
        $shipping->faqs()->save($faq);

    }
}
