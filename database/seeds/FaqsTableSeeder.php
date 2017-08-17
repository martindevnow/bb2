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
        $meat = \Martin\Core\FaqCategory::create([
            'code'  => 'meat',
            'label' => 'Meat',
        ]);

        $barf = \Martin\Core\FaqCategory::create([
            'code'  => 'barf',
            'label' => 'B.A.R.F.',
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
            'answer'    => 'B.A.R.F. stands for <b>B</b>iologically <b>A</b>pproved <b>R</b>aw <b>F</b>ood.<br>
It is a diet that mimics the diet of wild canine. Dogs are not meant to eat corn, wheat or soy. And the meat "by-products" that are often found in 
\'off-the-shelf\' pet food brands just don\'t provide the nutrients that dogs need. And what\'s worse is these addatives and synthetic preservatives are
often the source of many of our furry friends\' allergies.
',
        ]);
        $barf->faqs()->create([
            'code'  => 'barf-is-it-you',
            'question'  => 'Did you come up with B.A.R.F.?',
            'answer'    => 'No. B.A.R.F. is bigger than we are. It\'s what we\'ve modeled ourselves after. However, we have been the first to bring the knowledge of this nutritional diet for dogs to consumers in the GTA.
What we wanted to do was provide access to a nutritional and convenient meal plan for our friends and family to give them more time to spend with their dogs. This means less time worrying about
what to feed them, less time portioning out their meat, less time at the vet, and more years on your dog\'s life.
<br>',
        ]);
        $barf->faqs()->create([
            'code'  => 'barf-what-superfood',
            'question'  => 'What superfoods and suppliments do you add?',
            'answer'    => '...',
        ]);


        /*
         * Meat
         */
        $meat->faqs()->create([
            'code'  => 'meat-raising',
            'question'  => 'Where is your meat sourced from?',
            'answer'    => 'All of the livestock used for B.A.R.F.Bento meals are raised without the use of anti-biotics or 
            hormones to ensure our pets are only eating what nature intended. As such, our meals are packed with frozen meat to order to offer meat that is free of preservatives.'
        ]);
        $meat->faqs()->create([
            'code'  => 'meat-enough-food',
            'question'  => 'How do I know my dog is getting enough food?',
            'answer'    => 'It is very important for you to let us know your dog\'s current weight as it changes. 
            We advise you to monitor your dogs weight and update us as to any changes on a monthly basis so that we can properly portion and cater to your dog\'s needs. 
            The amount of food a dog needs to consume is largely based on their weight. However, their activity level plays a role as well. 
            For example, when a dog doesn\'t get enough exercise, it is important to adjust their portions accordingly to avoid overfeeding.'
        ]);
        $meat->faqs()->create([
            'code'  => 'meat-not-eating-dinner',
            'question'  => 'Help! My dog didn\'t eat his dinner! What do I do??',
            'answer'    => 'First, relax. There are many reasons why a dog might not eat their meal. 
            In fact, as a part of the B.A.R.F. diet, it is not uncommon to fast your dog from time to time. It could simply be that the dog is not hungy at that point in time. We advise our customers to 
            give the dog time to eat and when they no longer seem interested in the meal, take it away and refigerate it. At the time for the next meal, bring it back out and offer it to your dog again.
            With a hopefully renewed appetite your dog will be more likely to finish their meal. 
            
            Another possible cause is over-feeding with treats. Watch how much or how often you give your pet treats as this may be the cluprit.
            
            If your dog still refuses to eat a particular meal, take note of what was in the meal based on the stickers on the packaging. 
            If the same meal is a repeat offender (meaning your dog repeatedly refuses this meal) then let us know about it! 
            After consulting with us, we can make adjustments to the meal plan for your pet to better cater to their likes and dislikes for a minimal surcharge.
            '
        ]);
        $meat->faqs()->create([
            'code'  => 'meat-eating-bones',
            'question'  => 'Are bones safe to eat?',
            'answer'    => 'Simply put: <br>"<b>Raw:</b> Fine. Just be careful with small bones like those found in pork chops from the supermarket. 
Raw chicken bones are perfectly fine as well.
<br><b>Cooked:</b> Not safe! Cooked bones will <em>splinter</em>, not <em>break</em> like raw bones do. When a cooked bone splinters, 
it can easily scratch your dog\'s throat or lead to choking.
<br>
It\'s is always best to supervise dogs when he\'s eating bones.
            '
        ]);


        /*
         * Transitioning
         */
        $trans->faqs()->create([
            'code'  => 'trans-what-to-expect',
            'question'  => 'What can I expect during transitioning?',
            'answer'    => 'In the first couple of days, you may see no poop simply because your dog is absorbing all of the nutrients that are found in our high quality raw dog food.
            After 3 days, the bowel movements should be back to normal. However, raw-fed dogs generally do not poop as much or as frequently. Sometimes you will also notice
            that your dog will drink less water. That is because raw dog food has a much higher moisture content compared to kibbles. Generally, there is a rule of thumb. 
            If something doesn\'t last more than 3 days, there is no need to be concerned.
            You can always reach out to us and our knowledgeable pet nutritionists will be able to assist you with any questions you may have.'
        ]);

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
            'code'  => 'ship-where-to',
            'question'  => 'Where do you ship to?',
            'answer'    => 'Currently, shipping is available to areas located within Toronto and across the GTA.
            This includes Mississauga, Toronto, Markham, Scarborough, Etobicoke...
            For more information, please visit our <a href="/shipping">shipping page</a>.'
        ]);

        $shipping->faqs()->create([
            'code'  => 'ship-how-much',
            'question'  => 'How much is shipping?',
            'answer'    => 'All of the prices listed include monthly shipping. 
            If you do not have enough space to store 1 months of food, 
            then the weekly price is slightly adjusted to include bi-weekly shipping.'
        ]);

        $shipping->faqs()->create([
            'code'  => 'ship-how-are_they_shipped',
            'question'  => 'How are the products shipped?',
            'answer'    => 'All shipments are sent via same-day courier to ensure your package arrives frozen or semi-frozen.
            Do not be concerned if there is condensation on the outside of the meal packages. This is normal. 
            The meals are packaged to prevent leaks..'
        ]);


        /*
         * Payments
         */
//        $payments->faqs()->create([]);






    }
}
