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

        $trans = \Martin\Core\FaqCategory::create([
            'code'  => 'transitioning',
            'label' => 'Transitioning',
        ]);

        $shipping = \Martin\Core\FaqCategory::create([
            'code'  => 'shipping',
            'label' => 'Shipping'
        ]);

//        $payments = \Martin\Core\FaqCategory::create([
//            'code'  => 'payments',
//            'label' => 'Payments'
//        ]);
//        $pet = \Martin\Core\FaqCategory::create([
//            'code'  => 'my-pet',
//            'label' => 'My Pet'
//        ]);


        /**
         * FAQs
         */

        /*
         * BARF
         */
        $barf->faqs()->create([
            'code'  => 'barf-what-is-it',
            'question'  => 'What is B.A.R.F.?',
            'answer'    => 'BARF stands for Biologically Approved Raw Food.<br>',
        ]);
        $barf->faqs()->create([
            'code'  => 'barf-is-it-you',
            'question'  => 'Did you come up with B.A.R.F.?',
            'answer'    => 'No. BARF is not unique to BARFBento. However, we have been the first to bring the knowledge of this nutritional diet for dogs to consumers in the GTA.<br>',
        ]);


        /*
         * Meat
         */
        $meat->faqs()->create([
            'code'  => 'meat-where-sourced',
            'question'  => 'Where is your meat sourced from?',
            'answer'    => 'Our meat is sourced from happy places with great animals that live free and eat only the good stuff!'
        ]);
        $meat->faqs()->create([
            'code'  => 'meat-raising',
            'question'  => 'Where is your meat sourced from?',
            'answer'    => 'All of the livestock used for B.A.R.F.Bento meals are raised without the use of anti-biotics or hormones to ensure our pets are only eating what nature intended.'
        ]);


        /*
         * Transitioning
         */
        $trans->faqs()->create([
            'code'  => 'trans-age',
            'question'  => 'At what age should I transition my pet?',
            'answer'    => 'Now<br>But seriously, similar to quitting smoking, there\'s no better time than the present. Nature and biology are truly astounding in their ability to regenerate and
switching from kibbles to B.A.R.F. sooner allows your pet to have more time to regenerate from the effects caused by kibbles and help restore their natural balance.'
        ]);
        $trans->faqs()->create([
            'code'  => 'trans-how',
            'question'  => 'How do we transition from kibbles to raw?',
            'answer'    => '<b>Myth:</b> It\'s a common mis-conception that transitioning should be slow and mix between kibbles and raw.<br><br><b>Truth:</b> Cold turkey is the best way to go.<br>
The pH balance of your pet\'s stomach has had the pH balance raised considerably from a kibbles diet causing their gastric juices to be rather neutral pH6-7. 
However, a raw fed dog\'s stomach is extremely acidic as it is designed to be in order to consume raw meat and bones.
Mixing these two very different food sources is a recipe for an upset stomach and irregular bowel movements.<br>
Going cold turkey, and starting on pure raw allows the pet\'s digestive system to reboot and balance itself. With pets who are new to raw, we typically recommend starting with the Basic bento as it
contains only chicken and turkey and is easier on your pet\'s stomach.'
        ]);


        /*
         * Shipping
         */
        $shipping->faqs()->create([
            'code'  => 'where-ship-to',
            'question'  => 'Where do you ship to?',
            'answer'    => 'Currently, shipping is available to areas located within Toronto. For more information, please visit our /shipping page.'
        ]);
        $shipping->faqs()->create([
            'code'  => 'where-o',
            'question'  => 'This is another question',
            'answer'    => 'Currently, shipping is available to areas located within Toronto. For more information, please visit our /shipping page.'
        ]);


        /*
         * Payments
         */
//        $payments->faqs()->create([]);






    }
}
