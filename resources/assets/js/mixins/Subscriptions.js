import swal from 'sweetalert2';

export class Pet {
   constructor(petData = null) {
       if (petData) {
           this.id = petData['id'];
           this.weight = petData['weight'];
           this.name = petData['name'];
           this.breed = petData['breed'];
           this.species = petData['species'];
       } else {
           this.weight = 0;
       }
   }

   roundedWeight() {
       if (! this.weight) {
           return 0;
       }
       return Math.round(this.weight / 5) * 5;
   }
}

export class Cart {
    constructor(cartData = null) {
        if (cartData) {
            this.id = cartData['id'];
            this.hash = cartData['hash'];
            this.sub_weight = cartData['sub_weight'];
            this.sub_package_id = cartData['sub_package_id'];
            this.sub_shipping_modifier = cartData['sub_shipping_modifier'];
        } else {
            this.sub_shipping_modifier = 0;
            this.sub_package_id = 0;
        }
    }
    shippingCost() {
        return this.sub_shipping_modifier * 5;
    }
    shippingCostLabel() {
        if (this.sub_shipping_modifier === 0)
            return "FREE";

        return "+ $" + this.shippingCost() + " / week";
    }
}

export class Package {
    constructor(data) {
        this.id = data['id'];
        this.code = data['code'];
        this.label = data['label'];
        this.active = data['active'];
        this.isPublic = data['public'];
        this.customization = data['customization'];
        this.level = data['level'];
    }
}

export class Price {
    constructor(data) {
        this.id = data['id'];
        this.size = data['size'];
        this.max_weight = data['max_weight'];
        this.min_weight = data['min_weight'];
        this.base_cost = data['base_cost'];
        this.incremental_cost = data['incremental_cost'];
        this.upgrade_cost = data['upgrade_cost'];
        this.customization_cost = data['customization_cost'];
    }

    getIncrementalCostByWeight(weight) {
        return (weight - this.min_weight) / 5 * this.incremental_cost;
    }
}

export class Address {
    constructor(addressData = null) {
        if (addressData) {
            this.id = addressData['id'];
            this.street_1 = addressData['street_1'];
            this.street_2 = addressData['street_2'];
            this.city = addressData['city'];
            this.province = addressData['province'];
            this.country = addressData['country'];
            this.postal = addressData['postal'];
        } else {
            this.province = 'ON';
            this.country = 'Canada';
        }
    }
}

export default {
    data() {
        return {
            sub_prices: [],
            sub_packages: [],
            form: {
                cart: new Cart(),
                pet_id: null,
                address_id: null,
                pet: new Pet(),
                address: new Address(),
            },
            user: {
                pets: [],
                addresses: [],
            },
            selectedClass: 'btn-primary',
            defaultClass: 'btn-default',
        }
    },
    mounted() {},
    methods: {
        getAddresses() {
            let vm = this;
            axios.get('/api/user/addresses')
                .then(response => {
                    vm.user.addresses = response.data.map(addressData => new Address(addressData));
                })
                .catch(error => {
                    swal({
                        title: 'Error',
                        text: 'Unable to fetch addresses..',
                        type: 'error',
                    });
                })
        },
        getPets() {
            let vm = this;
            axios.get('/api/user/pets')
                .then(response => {
                    vm.pets = response.data.map(petData => new Pet(petData));
                })
                .catch(error => {
                    swal({
                        title: 'Error',
                        text: 'Unable to fetch pets..',
                        type: 'error',
                    });
                })
        },
        getSubscriptionPrices() {
            let vm = this;
            axios.get('/api/pricing')
                .then(function(response) {
                    vm.sub_prices = response.data.map((priceData) => {
                        return new Price(priceData);
                    });
                })
                .catch(function(error) {
                    console.log(error);
                    swal('There was an unknown error.')
                })
        },
        getSubscriptionPrice(weight) {
            let vm = this;
            let pricing = this.sub_prices.filter(function(price) {
                return weight >= price.min_weight
                    && weight <= price.max_weight;
            });
            if (! pricing.length) {
                return null;
            }
            return pricing[0];
        },
        getSubscriptionPackages() {
            let vm = this;
            axios.get('/api/packages')
                .then(function(response) {
                    vm.sub_packages = response.data
                        .map(pkgData => new Package(pkgData))
                        .filter(pkg => pkg.customization === 0)

                    console.log(vm.sub_packages);
                    vm.form.cart.sub_package_id = vm.sub_packages[0].id;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getCart() {
            console.log('loading cart...');
            if (! this.cart_hash) {
                return ;
            }

            let vm = this;
            axios.get('/api/cart/' + vm.cart_hash)
                .then(function(response) {
                    vm.form.cart = new Cart(response.data);
                    vm.form.pet.weight = vm.form.cart.sub_weight;
                })
                .catch(function(error) {
                    swal({
                        title: 'Error',
                        text: 'Unable to retrieve your cart..',
                        type: 'error',
                    });
                });
        },
        getSubscriptionPackage(id = null) {
            id = id ? id : this.form.cart.sub_package_id;
            return this.sub_packages.filter(pkg => pkg.id === id)[0];
        },
        isSelected(pkg) {
            return this.form.cart.sub_package_id && this.form.cart.sub_package_id === pkg.id;
        },
        shippingFrequency(shipping_modifier) {
            shipping_modifier = Number.parseInt(shipping_modifier);

            if (! shipping_modifier || shipping_modifier === 2)
                return 'Weekly';

            if (shipping_modifier === 0)
                return 'Monthly';

            if (shipping_modifier === 1)
                return 'Bi-Weekly';
        },

    },
    mounted() {
        console.log('Subscription mixin mounted');
        this.getSubscriptionPrices();
        this.getSubscriptionPackages();
    },
    computed: {
        cost() {
            if (Number.parseInt(this.form.pet.weight) < 5)
                return 0;

            console.log('weight OK');

            if ( ! this.form.cart.sub_package_id || ! this.sub_packages.length)
                return 0;

            console.log('Package ID OK');

            let price = this.getSubscriptionPrice(this.form.pet.weight);
            if (! price)
                return 0;

            console.log('Price OK');

            let pkg = this.getSubscriptionPackage(this.form.cart.sub_package_id);

            console.log(pkg);
            return price.base_cost
                + price.getIncrementalCostByWeight(this.form.pet.roundedWeight())
                + pkg.level * price.upgrade_cost
                + pkg.customization * price.customization_cost;
        },
        servingCost() {
            return this.cost / 14;
        }
    }
}