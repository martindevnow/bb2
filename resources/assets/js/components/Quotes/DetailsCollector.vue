<template>
    <div>
        <div class="row">
            <div class="col-sm-12" v-if="cart">
                <h2>In Your Cart</h2>
                <span>Plan: {{ cart.package.label }} Bento for a {{ cart.sub_weight }} lb dog</span><br />
                <span>Shipping: {{ shippingFrequency }}</span><br />
                <span>Promo Rate: TBD</span>
            </div>
            <div class="col-sm-6">
                <h2>Your Dog</h2>
                <select v-if="pets.length">
                    <option v-for="pet in pets">{{ pet.name }}</option>
                </select>

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
                        >
                    </div>
                </div>
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
                        >
                    </div>
                </div>
                <div class="form-group" style="margin-top: 0px;">
                    <label class="col-md-2 control-label"
                           for="pet_weight">Weight:</label>
                    <div class="col-md-10">

                        <input type="text"
                               name="pet_weight"
                               v-model="myPet.weight"
                               class="form-control"
                               id="pet_weight"
                               placeholder=""
                               autocomplete="off"
                               style="text-align: center;"
                               autofocus
                        >
                    </div>
                </div>
            </div><div class="col-sm-6">
                <h2>Your Address</h2>
                <select v-if="addresses.length">
                    <option v-for="address in addresses">{{ address.street_1 }}</option>
                </select>

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
                        >
                    </div>
                </div>

                <div class="form-group" style="margin-top: 0px;">
                    <label class="col-md-2 control-label"
                           for="address_street_1">Street (Line 2):</label>
                    <div class="col-md-10">

                        <input type="text"
                               name="address_street_1"
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
                        >
                    </div>
                </div>
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
                        >
                    </div>
                </div>
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
                        >
                    </div>
                </div>

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
                        >
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
    import swal from 'sweetalert2'

    export default {
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
                let vm = this;
                axios.post('/api/subscribe/details', {
                    pet: vm.myPet,
                    address: vm.myAddress,
                    hash: vm.hash,
                }).then(response => {

                }).catch(error => {
                    swal({
                        title: 'Error',
                        text: 'Could not save your details.. ' + error,
                        type: 'error',
                    });
                })
            }
        },
        computed: {
            shippingFrequency() {
                if (! this.cart || this.cart.shipping_modifier == 2)
                    return 'Weekly';

                if (this.cart.shipping_modifier == 0)
                    return 'Monthly'

                if (this.cart.shipping_modifier == 1)
                    return 'Bi-Weekly'
            }
        },
        mounted() {
            this.getCart();
            this.getPets();
            this.getAddresses();
        }

}
</script>

<style>
    
</style>