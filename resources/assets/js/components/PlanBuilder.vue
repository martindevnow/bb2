<template>
    <div class="row">
        <form action="/purchases" method="POST">

            <h1>Plan Builder</h1>

            <div class="row">
                <div class="col-sm-6">
                    <h2>You</h2>
                    <div class="form-group">
                        <label for="username"
                               class="col-md-2 control-label">Username</label>
                        <div class="col-md-10">
                            <input type="text"
                                   v-model="formData.username"
                                   class="form-control"
                                   id="username"
                                   name="Username"
                                   placeholder="username"
                                   autocomplete="off"
                                   aria-describedby="usernameHelp"
                                   style="cursor: auto;"
                            >
                            <span class="help-block" v-if="hasError('username')">
                                <strong>{{ getError('username') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email"
                               class="col-md-2 control-label">Email</label>
                        <div class="col-md-10">
                            <input type="email"
                                   v-model="formData.email"
                                   class="form-control"
                                   id="email"
                                   name="email"
                                   placeholder="e-mail"
                                   autocomplete="off"
                                   aria-describedby="emailHelp"
                                   style="cursor: auto;"
                            >
                            <span class="help-block" v-if="hasError('email')">
                                <strong>{{ getError('email') }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password"
                               class="col-md-2 control-label">password</label>
                        <div class="col-md-10">
                            <input type="password"
                                   v-model="formData.password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   autocomplete="off"
                                   aria-describedby="passwordHelp"
                                   style="cursor: auto;"
                            >
                            <span class="help-block" v-if="hasError('password')">
                                <strong>{{ getError('password') }}</strong>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <h2>Your Dog</h2>
                    <div class="form-group">
                        <label for="name"
                               class="col-md-2 control-label">Name</label>
                        <div class="col-md-10">
                            <input type="text"
                                   v-model="formData.pet_name"
                                   class="form-control"
                                   id="name"
                                   name="name"
                                   placeholder="Name"
                                   autocomplete="off"
                                   aria-describedby="nameHelp"
                                   style="cursor: auto;"
                            >
                            <span class="help-block" v-if="hasError('name')">
                        <strong>{{ getError('name') }}</strong>
                    </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="breed"
                               class="col-md-2 control-label">Breed</label>
                        <div class="col-md-10">
                            <input type="text"
                                   v-model="formData.pet_breed"
                                   class="form-control"
                                   id="breed"
                                   name="breed"
                                   placeholder="Breed"
                                   autocomplete="off"
                                   aria-describedby="breedHelp"
                                   style="cursor: auto;"
                            >
                            <span class="help-block" v-if="hasError('breed')">
                        <strong>{{ getError('breed') }}</strong>
                    </span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="weight"
                               class="col-md-2 control-label">Weight</label>
                        <div class="col-md-10">
                            <input type="text"
                                   v-model="formData.pet_weight"
                                   class="form-control"
                                   id="weight"
                                   name="weight"
                                   placeholder="Weight"
                                   autocomplete="off"
                                   aria-describedby="weightHelp"
                                   style="cursor: auto;"
                            >
                            <span class="help-block" v-if="hasError('weight')">
                        <strong>{{ getError('weight') }}</strong>
                    </span>
                        </div>
                    </div>
                </div>
            </div>




            <div class="form-group">
                <label class="col-md-2 control-label">Package</label>
                <div class="col-md-10">
                    <div class="col-sm-4" v-for="pkg_i in packages">
                        <button class="btn btn-raised btn-block"
                                :class="[isSelected(pkg_i) ? selectedClass : defaultClass]"
                                @click.prevent="pkg = pkg_i">
                            {{ pkg_i.label }}
                        </button>

                    </div>
                    <span class="help-block" v-if="hasError('package_id')">
                        <strong>{{ getError('package_id') }}</strong>
                    </span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-2 control-label">Shipping</label>
                <div class="col-md-10">
                    <div class="col-sm-3">
                        <button class="btn btn-raised btn-block"
                                :class="[shipping_modifier === 0 ? selectedClass : defaultClass]"
                                @click.prevent="shipping_modifier = 0">
                            Monthly
                        </button>
                    </div>
                    <div class="col-sm-3">
                    <button class="btn btn-raised btn-block"
                                :class="[shipping_modifier === 1 ? selectedClass : defaultClass]"
                                @click.prevent="shipping_modifier = 1">
                            Bi-Weekly
                        </button>

                    </div>
                    <span class="help-block" v-if="hasError('shipping_modifier')">
                        <strong>{{ getError('shipping_modifier') }}</strong>
                    </span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-2 control-label"></label>
                <div class="col-md-10">
                    <div class="col-md-6">
                        <button class="btn btn-block btn-success">
                            $ {{ cost.toFixed(2)}}
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-raised btn-success"
                                type="submit"
                                @click.prevent="subscribe"
                        >
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>

            <p class="help is-danger" v-show="status" v-text="status"></p>

            <input type="hidden" name="stripeToken" v-model="formData.stripeToken">
            <input type="hidden" name="stripeEmail" v-model="formData.stripeEmail">

        </form>
    </div>
</template>

<script>
export default {
    props: [],
    data() {
        return {
            selectedClass: 'btn-primary',
            defaultClass: 'btn-default',
            packages: [],
            pkg: {id: 1},
            shipping_modifier: 0,
            sizes: [
                {label: 'S', min: 5, max: 14, base: 39, inc: 1.95},
                {label: 'M', min: 15, max: 49, base: 44.85, inc: 1.625},
                {label: 'L', min: 50, max: 94, base: 65, inc: 1.755},
                {label: 'XL', min: 95, max: 139, base: 87.1, inc: 1.95},
                {label: 'XXL', min: 140, max: 220, base: 104, inc: 2.145},
            ],
            formData: {
                stripeEmail: '',
                stripeToken: '',
                package_id: 0,
                pet_name: '',
                pet_breed: '',
                pet_weight: 0,
            },
            status: ''
        };
    },
    methods: {
        getPackages() {
            let vm = this;
            axios.get('/api/packages')
                .then(function(response) {
                    vm.packages = response.data.filter(function(pkg) {
                        return pkg.customization == 0;
                    });
                    vm.pkg = vm.packages[0];
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        shippingCost() {
            return 5 * this.shipping_modifier;
        },
        hasError(field) {
            return this.getError(field) === null;
        },
        getError(field) {
            if (field === 'weight') {
                return this.validateWeight();
            }
        },
        validateWeight() {
            if (this.formData.pet_weight < 0) {
                return 'The weight must be positive.';
            }
            return null;
        },
        getSize() {
            let vm = this;
            let size = this.sizes.filter(function(size) {
                return vm.formData.pet_weight >= size.min && vm.formData.pet_weight <= size.max;
            });
            if (! size.length) {
                return null;
            }
            return size[0];
        },
        isSelected(pkg) {
            return this.pkg && this.pkg.id === pkg.id;
        },
        roundedWeight() {
            if (! this.formData.pet_weight) {
                return 0;
            }
            return Math.round(this.formData.pet_weight / 5) * 5;
        },
        subscribe() {
            this.stripe.open({
                name: this.pkg.label,
                description: this.pkg.label + ' Bento for '
                    + this.formData.pet_name
                    + ' (' + this.formData.pet_weight + ' lbs)',
                zipCode: true,
                amount: this.cost * 100
            });
        }
    },
    mounted() {
        this.getPackages();

        let vm = this;
        this.stripe = StripeCheckout.configure({
            key: BarfBento.stripeKey,
            image: "https://stripe.com/img/documentation/checkout/marketplace.png",
            locale: "auto",
            panelLabel: "Subscribe For",
            token: (token) => {
                this.formData.stripeToken = token.id;
                this.formData.stripeEmail = token.email;
                this.formData.package_id = this.pkg.id;
                this.formData.weeks_at_a_time = this.shipping_modifier === 0 ? 4 : 2;
                axios.post('/plans/subscribe', this.formData)
                    .then(
                        response => alert('Complete! Thanks for your payment!'),
                    )
                    .catch(
                        response => {
                            console.log({'response': response});
                        }
                    )
            }
        });
    },
    computed: {
        cost() {
            if (! this.formData.pet_weight || ! this.pkg) {
                return 1;
            }
            let size = this.getSize();

            return size.base
                + (this.roundedWeight() - size.min) * size.inc
                + this.pkg.level * 5
                + this.pkg.customization * 3
                + this.shippingCost();
        }
    },

}
</script>

<style>

</style>