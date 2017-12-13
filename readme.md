# B.A.R.F. Bento

B.A.R.F. Bento stands for Biologically Appropriate Raw Food. \
This is the standard for the ideal diet for dogs and cats as well as other household pets. 

Too often, pet owners are misinformed by mass media and so, without knowing better, they feed their pets a 
diet consisting primarily of grains and other carbohydrates which their stomachs are not equipped to 
digest properly. This can lead to significant complications later in life for your pets. 

As such, it is strongly recommended that pets be fed a B.A.R.F. diet. 

## Versions

Current: 1.0.1 (Release: December 13 2017)

## Security Vulnerabilities

If you discover a security vulnerability within B.A.R.F. Bento, please send an e-mail to Benjamin Martin at 
benm@barfbento.com. All security vulnerabilities will be promptly addressed.

## License

B.A.R.F. Bento is software licensed under a [Proprietary license](https://en.wikipedia.org/wiki/Proprietary_software).

## Development

Files Outside Version Control

`/pdfs
/seeds/fromGoogle`

Node

`npm run watch` for development with VueJS

## Future Features

(Example: Today is Sunday, 1st of Month)
* Nightly order generation based on orders to be delivered by the following **friday** (13th)
  * This **wednesday** (4th), we need to know how much meat we will need to order to pickup this weekend (6th-8th)
  * Said *meat* will then be packed into *meals* on the weekend or week of (6th-8th)
  * Those *meals* will then be delivered by the friday (13th), and we repeat this process **wednesday** (11th) for the **friday** (20th)
* Checkout Flow
  * User visits /quote
  * -- fills in all details
  * -- clicks submit
  * If unauthorized, take them to the login/register screen
  * -- User then registers
  * They are logged in right away
  * Present user with address form, etc
  * User then fills in their address and other details
  * -- clicks submit
  * Stripe checkout process
  * -- 
  
## Next things to work on

* Checkout process
  * If logged in, skip the Login page of the checkout...
  * Allow users to select an existing pet/address instead of a new one...
  * Add discount codes for the checkout process.. pre-populate it with the "NEW..." code
  * Clean up the cart page and final details page
  * Let the user confirm (and update/change any specific details.)
  * Initiate the stripe call
  * Received payment
  * activate the plan in our DB
  * Send a notification to Viv to track the new orders
  * allow the user to schedule their shipments.. 
    * Let them choose day of the week.. ?
    * Show what day will be their first shipment. Today +4, then the next day of the week that matches their requested day of the week
* Manage the user's existing plans (make changes)
* Allow existing users to add treats to their next shipment (must be placed at least a few days before the expected shipment)
* Allow users to cancel their plans (and hook into the stripe webhook to allow them to cancel it from their end)
  * keep in mind that plans are NOT prorated.
    * cancel date should be end of the term (based on Stripe)
    * check the DB to see if they have any invoice items other than the one for their bentos 
* Create a task to remove old carts from the DB after 24 hours or something
* Redirect the user if the cart does not exist (when they are on a page requiring the cart to exist)

NRFs
* extract some of the Vue methods to a mixin (sizes, packages, api calls, etc)
* Review the API middleware in the kernel to ensure running properly.
* build out tests for all the new API endpoints
* make sure orders:generate is scheduled (and check when...)
* Make sure when a plan is cancelled, that the orders in the system that were already generated are deleted.
* Send a notification when a plan is cancelled so viv and "undo" their packing.. etc...


## VueJS / Checkout Workflow

**Page 1:** (Quote/Calculator)

* a guest visits the quotes page
  * APIs:
    * packages, costModels, discountCodes
* guest likes what they see
* guest clicks continue/signup
  * BACKend:
    * validate
    * create a shopping cart
    * assign this cart to this session
    * provide cart key to frontend
  * OR
    * provide the cart ID to the blade template to render the component....
      * this should reduce the # of API requests from the Vue component
* redirect to login page (if quest) otherwise, Page 2.

**Page 2:** (Details, Pet and Address)

* the new member is asked to fill in the rest of their pet's details
  * APIs:
    * packages, costModels, cart, discountCodes, pets, addresses
* the guest adds their pet and address
* the guest clicks continue
  * BACKend:
    * validate
    * add relational models to the DB
    * update the cart accordingly
    * redirect to page 3

**Page 3:** (Confirmation & Impulse Buys)

* the member is presented with the final cart summary.
  * APIS: 
    * cart, packages, pet, address, discountCodes
* if we wanted, we could offer the opportunity to add treats at this point (before the charge is fully made)
* the member is happy with their cart selection (but could make changes if they wanted to)
* the member clicks on "subscribe"
* the member fills in their CC details and clicks Signup
  * BACKend:
    * validate
    * create customer, subscription, assign any invoice items, save the plan to the customer
    * save all the Stripe specific info
    * create a PLAN in the DB
    * set the first delivery date
    
    
**Questons** (Need to gather requirements)

* do they need to select their first delivery date?
* how soon after placing their order should the lead time be?
* how can we validate shipping location? 
  * what do we do if someone from ottawa or nippising sign up?
  * can we add in some validation for acceptable Cities?
  * do we say only in GTA right now?
  * do we know what the incremental shipping cost would be?
  



## Test Coverage

**2017-08-16**

| Area | Lines | Fnct | Classes |
| ---- | ----- | ---- | ------- |
| Overall | 80.80% | 81.57% | 49.23% |
| Martin | 92.49% | 87.58% | 46.43% |
| app | 71.78% | 75.00% | 51.35% |


## Books to Investigate

The Joy of UX
The UX Career Handbook
UX Style Frameworks
The Design Studio Method
IT Project Management


## Main TODOs

* use Vuex for state-management
* rebuild the client-facing app...
  * Rebuild the checkout process for customers and consider the communication between componenets/state/DB/server/etc...
* rebuild the order tracking part of the app FROM SCRATCH for ORDERS
* Build the APIs required for this and include testing
* find a way to modularize the store
* build this out initially for the order-dashboard using state (and the ability to change details of the orders. with dropdowns and buttons)
  * then, add in the first payment logger...
  * then, add in each additional logger
    * search for patterns, extract to mixin or helper classes (or even models where appropriate)...
    
**Orders, When to Generate and How to Manage Forecasting Meat to Order and What to Pack**
* a user signs up for the website..
  * the fastest turnaround EVER would be 24h... this is un reliable..
  * realistically, we would say earliest would be order_date + 3 days.. (3 business days..)
    * orders placed on monday would be **shipped** by monday... this is an important distinction
    * we may be using mostly same day couriers for most of the shipping now, but in the future, we might not be able to do so. 
      * the cost of shipping and lead times, etc needs to be resolved elsewhere too......
      * for lead times, we need to have some estimate.. keep in mind this is just for the first shipment.... 
      * after the first one, it will be more regular., so there is no "delay" in the shipment.
      * there is still lead time in terms of when we start preparing the order vs when we ship it out.. we need to account for that
      * however, the lead time of the first shipment is an *additional** 2-3 days.. 
      * this gives us the time to receive the order into our system and pack and prepare the order.
  * for people in the GTA, lead time should be 3 days (then same day shipment)
  * southern ontario should be 4 days (3 + 1 for overnight shipping)
  * for outside southern ontario, we need to do some proper analysis to understand when the first shipment would be
  * but we still need to give the customer an estimate of when the shipment should arrive
  * this might need to be done on a case by case basis.... so, order generation will be hard. 
    * (or rather knowing when the next order needs to be delivered by...)

So....

* if we track when an plan is created... the FIRST order might be manual... to say we input the delivery by date..
* the user creates the plan, within 24h, we arrange with the customer when the first delivery should be...
* then, we will know what the shipping method will be... self-delivered, same-day courier, or national courier...
* then we can schedule the first shipment on the first order... 
* when an order is packed, we confirm shipment size
* when it is shipped, it is again confirmed...


One thing to realize, is if we order meat based on the next 2 weeks of orders.. we cannot mark these orders as having had meat ordered for them
* because if we get new customers, we will consume meat not ordered FOR them... this meat was ordered for existing customers
* we cannot track how much meat we have on hand according to the way tht vivian is using the meat.
 




Orders should not be generated if there is an open order that is no packed yet.
* if the most recent order has already been packed, then we can generate the next order.. that will allow us to see how far in advance we are..

this will solve the problem of knowing what to pack and when...

ordering meat...
* that will require having the "packed" orders up to date...
* then we can pull all the orders that need to be packed and use those..
* we can also allow the person placing the meat order to select a date they would like to NEXT order meat.
* then we would look at the plans we have, and any that will ship an order prior to that date will need to be included in this estimate

**note** that i said SHIP an order... 
* we need to be careful of this because we will need to be aware of lead times when it comes to shipments 
* otherwise, if an order is to be delivered the day AFTER the date the person placing the order chooses, then that order won't be considered
* this is dangerous if that order was supposed to ship within the timeframe selected (due to lead times)
  