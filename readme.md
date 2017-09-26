# B.A.R.F. Bento

B.A.R.F. Bento stands for Biologically Appropriate Raw Food. \
This is the standard for the ideal diet for dogs and cats as well as other household pets. 

Too often, pet owners are misinformed by mass media and so, without knowing better, they feed their pets a 
diet consisting primarily of grains and other carbohydrates which their stomachs are not equipped to 
digest properly. This can lead to significant complications later in life for your pets. 

As such, it is strongly recommended that pets be fed a B.A.R.F. diet. 

## Versions

Current: 1.0.0 (Release: August 20 2017)

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
* rebuild the 
