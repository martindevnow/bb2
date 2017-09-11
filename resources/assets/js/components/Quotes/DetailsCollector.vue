<template>
    <div>
        <div class="row">
            <div class="col-sm-12" v-if="cart">
                <h2>In Your Cart</h2>
                <span v-if="cart.sub_package_id">Plan: {{ cart.sub_package.label }} Bento for a {{ cart.sub_weight }} lb dog</span><br />
                <span>Shipping: {{ shippingFrequency(cart.sub_shipping_modifier) }}</span><br />
                <span>Serving Cost: ${{ servingCost.toFixed(2) }}</span>
            </div>
            <div class="col-sm-6">
                <h2>Your Dog</h2>
                <select v-if="pets.length">
                    <option v-for="pet in pets">{{ pet.name }}</option>
                </select>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="pet_name">Name:</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="pet_name"
                                   v-model="myPet.name"
                                   class="form-control"
                                   id="pet_name"
                                   placeholder=""
                                   autocomplete="off"
                                   style="text-align: center;"
                                   autofocus
                                   required
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="pet_breed">Breed:</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="pet_breed"
                                   v-model="myPet.breed"
                                   class="form-control"
                                   id="pet_breed"
                                   placeholder=""
                                   autocomplete="off"
                                   style="text-align: center;"
                                   autofocus
                                   required
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="pet_weight">Weight:</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="pet_weight"
                                   v-model="weight"
                                   class="form-control"
                                   id="pet_weight"
                                   placeholder=""
                                   autocomplete="off"
                                   style="text-align: center;"
                                   autofocus
                                   required
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <h2>Your Address</h2>
                <select v-if="addresses.length">
                    <option v-for="address in addresses">{{ address.street_1 }}</option>
                </select>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="address_street_1">Street:</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="address_street_1"
                                   v-model="myAddress.street_1"
                                   class="form-control"
                                   id="address_street_1"
                                   placeholder=""
                                   autocomplete="off"
                                   style="text-align: center;"
                                   autofocus
                                   required
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="address_street_2">Street (Line 2):</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="address_street_2"
                                   v-model="myAddress.street_2"
                                   class="form-control"
                                   id="address_street_2"
                                   placeholder=""
                                   autocomplete="off"
                                   style="text-align: center;"
                                   autofocus
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="address_city">City:</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="address_city"
                                   v-model="myAddress.city"
                                   class="form-control"
                                   id="address_city"
                                   placeholder=""
                                   autocomplete="off"
                                   style="text-align: center;"
                                   autofocus
                                   required
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="address_province">Province:</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="address_province"
                                   v-model="myAddress.province"
                                   class="form-control"
                                   id="address_province"
                                   placeholder=""
                                   autocomplete="off"
                                   style="text-align: center;"
                                   disabled
                                   required
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="address_country">Country:</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="address_country"
                                   v-model="myAddress.country"
                                   class="form-control"
                                   id="address_country"
                                   placeholder=""
                                   autocomplete="off"
                                   style="text-align: center;"
                                   disabled
                                   required
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="address_postal">Postal Code:</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="address_postal"
                                   v-model="myAddress.postal"
                                   class="form-control"
                                   id="address_postal"
                                   placeholder=""
                                   autocomplete="off"
                                   style="text-align: center;"
                                   autofocus
                                   required
                            >
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <button class="btn btn-block btn-lg btn-raised"
                        @click.prevent="nextStep"
                >Continue</button>
            </div>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert2';
    import Pricing from '../../mixins/pricing';

    export default {
        mixins: [Pricing],
        props: ['hash'],
        data() {
            return {
                addresses: [],
                pets: [],
                cart: {},
                myPet: {},
                myAddress: {
                    province: 'ON',
                    country: 'Canada',
                },

            };
        },
        methods: {
            getAddresses() {
                let vm = this;
                axios.get('/api/user/addresses')
                    .then(response => {
                        vm.addresses = response.data;
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
                        vm.pets = response.data;
                    })
                    .catch(error => {
                        swal({
                            title: 'Error',
                            text: 'Unable to fetch pets..',
                            type: 'error',
                        });
                    })
            },
            getCart() {
                let vm = this;
                axios.get('/api/cart/'+ vm.hash)
                    .then(response => {
                        vm.cart = response.data;
                        vm.myPet.weight = vm.cart.sub_weight;
                        vm.loadCartDetails();
                    })
                    .catch(response => {
                        swal({
                            title: 'Error',
                            text: 'Unable to retrieve your cart..',
                            type: 'error',
                        });
                    })
            },
            nextStep() {
                if ( ! this.myPet.weight || ! this.myPet.name || ! this.myPet.breed) {
                    return swal({
                        type: 'error',
                        text: 'Please fill in all of your dog\'s details',
                        title: 'Missing Information',
                    });
                }

                if ( ! this.myAddress.street_1 || ! this.myAddress.city || ! this.myAddress.postal) {
                    return swal({
                        type: 'error',
                        text: 'Please fill in all of your address details',
                        title: 'Missing Information',
                    });
                }
                let vm = this;
                axios.post('/api/subscribe/details', {
                    pet: vm.myPet,
                    address: vm.myAddress,
                    hash: vm.hash,
                }).then(function(response) {
                    console.log(response.data);
                    window.location = ('/quote/confirm/' + vm.hash);
                }).catch(function(error) {
                    swal({
                        title: 'Error',
                        text: 'Could not save your details.. ' + error,
                        type: 'error',
                    });
                })
            },
            loadCartDetails() {
                this.weight = this.cart.sub_weight;
                this.shipping_modifier = this.cart.sub_shipping_modifier;
                this.pkg = this.cart.sub_package;
            }
        },
        computed: {},
        mounted() {
            this.getCart();
            this.getPets();
            this.getAddresses();
        },
        watch: {
            myPet(pet, oldPet) {
                this.weight = pet.sub_weight;
            }
        }

}
</script>

<style>
    
</style>