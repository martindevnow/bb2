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
         * FAQs
         */
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
//        \Martin\Core\FaqCategory::create([
//            'code'  => '',
//            'label' => ''
//        ]);
//        \Martin\Core\FaqCategory::create([
//            'code'  => '',
//            'label' => ''
//        ]);


        $faq = \Martin\Core\Faq::create([
            'code'  => 'where-source-meat',
            'label' => 'Sourcing Meat',
            'question'  => 'Where is your meat sourced from?',
            'answer'    => 'Our meat is sourced from happy places with great animals that live free and eat only the good stuff!'
        ]);
        $meat->faqs()->save($faq);



        $faq = \Martin\Core\Faq::create([
            'code'  => 'where-ship-to',
            'label' => 'Where Do You Ship To',
            'question'  => 'Where do you ship to?',
            'answer'    => 'Currently, shipping is available to areas located within Toronto. For more information, please visit our /shipping page.'
        ]);
        $shipping->faqs()->save($faq);



        $faq = \Martin\Core\Faq::create([
            'code'  => 'where-o',
            'label' => 'Whedw To',
            'question'  => 'This is another question',
            'answer'    => 'Currently, shipping is available to areas located within Toronto. For more information, please visit our /shipping page.'
        ]);
        $shipping->faqs()->save($faq);



    }
}
