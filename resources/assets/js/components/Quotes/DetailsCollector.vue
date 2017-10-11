<template>
    <div>
        <div class="row">
            <div class="col-sm-12" v-if="form.cart">

                <cart-summary :cart="form.cart"></cart-summary>

                <h2>In Your Cart</h2>
                <span v-if="form.cart.sub_package_id && sub_packages.length">
                    Plan: {{ getSubscriptionPackage(form.cart.sub_package_id).label }} Bento for a {{ form.cart.sub_weight }} lb dog
                </span><br />
                <span>Shipping: {{ shippingFrequency(form.cart.sub_shipping_modifier) }}</span><br />
                <span>Serving Cost: ${{ servingCost.toFixed(2) }}</span>
            </div>
            <div class="col-sm-6">
                <h2>Your Dog</h2>
                <select v-if="user.pets.length">
                    <option v-for="pet in user.pets">{{ pet.name }}</option>
                </select>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="pet_name">Name:</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="pet_name"
                                   v-model="form.pet.name"
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
                                   v-model="form.pet.breed"
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
                                   v-model="form.pet.weight"
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
                <select v-if="user.addresses.length">
                    <option v-for="address in user.addresses">{{ address.street_1 }}</option>
                </select>

                <div class="row">
                    <div class="form-group" style="margin-top: 0px;">
                        <label class="col-md-2 control-label"
                               for="address_street_1">Street:</label>
                        <div class="col-md-10">

                            <input type="text"
                                   name="address_street_1"
                                   v-model="form.address.street_1"
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
                                   v-model="form.address.street_2"
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
                                   v-model="form.address.city"
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
                                   v-model="form.address.province"
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
                                   v-model="form.address.country"
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
                                   v-model="form.address.postal"
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
    import Subscriptions from '../../mixins/Subscriptions';

    export default {
        mixins: [Subscriptions],
        props: ['cart_hash'],
        data() {
            return {};
        },
        methods: {
            nextStep() {
                if ( ! this.form.pet.weight || ! this.form.pet.name || ! this.form.pet.breed) {
                    return swal({
                        type: 'error',
                        text: 'Please fill in all of your dog\'s details',
                        title: 'Missing Information',
                    });
                }

                if ( ! this.form.address.street_1 || ! this.form.address.city || ! this.form.address.postal) {
                    return swal({
                        type: 'error',
                        text: 'Please fill in all of your address details',
                        title: 'Missing Information',
                    });
                }
                let vm = this;
                axios.post('/api/subscribe/details', {
                    pet: vm.form.pet,
                    address: vm.form.address,
                    hash: vm.cart_hash,
                }).then(function(response) {
                    console.log(response.data);
                    window.location = ('/quote/confirm/' + vm.cart_hash);
                }).catch(function(error) {
                    swal({
                        title: 'Error',
                        text: 'Could not save your details.. ' + error,
                        type: 'error',
                    });
                })
            },
        },
        computed: {},
        mounted() {
            this.getCart();
            this.getPets();
            this.getAddresses();
        },
}
</script>

<style>
    
</style>