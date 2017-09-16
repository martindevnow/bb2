<template>
    <div>
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="form-group" style="margin-top: 0px;">
                    <label class="col-md-2 control-label"
                           for="weight">Weight:</label>
                    <div class="col-md-10">

                        <input type="text"
                               name="weight"
                               v-model="form.pet.weight"
                               class="form-control"
                               id="weight"
                               aria-describedby="weightHelp"
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
            <div class="form-group" style="margin-top: 0px;">
                <label class="col-md-2 control-label">Package</label>
                <div class="col-md-10">
                    <div class="col-sm-3">
                        <button class="btn btn-block btn-success btn-cost">
                            ${{ cost.toFixed(2) }} / week
                        </button>
                    </div>
                    <div class="col-sm-3" v-for="sub_package in sub_packages">
                        <button class="btn btn-raised btn-block btn-label"
                                :class="[isSelected(sub_package) ? selectedClass : defaultClass]"
                                @click.prevent="form.cart.sub_package_id = sub_package.id">
                            {{ sub_package.label }}
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group" style="margin-top: 0px;">
                <label class="col-md-2 control-label">Shipping</label>
                <div class="col-md-10">
                    <div class="col-sm-3">
                        <button class="btn btn-block btn-success btn-cost">
                            {{ form.cart.shippingCostLabel() }}
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-raised btn-block btn-label"
                                :class="[form.cart.sub_shipping_modifier === 0 ? selectedClass : defaultClass]"
                                @click.prevent="form.cart.sub_shipping_modifier = 0">
                            Monthly
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-raised btn-block btn-label"
                                :class="[form.cart.sub_shipping_modifier === 1 ? selectedClass : defaultClass]"
                                @click.prevent="form.cart.sub_shipping_modifier = 1">
                            Bi-Weekly
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-raised btn-block btn-label"
                                :class="[form.cart.sub_shipping_modifier === 2 ? selectedClass : defaultClass]"
                                @click.prevent="form.cart.sub_shipping_modifier = 2">
                            Weekly
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row" v-if="cost">
            <div class="form-group" style="margin-top: 0px;">
                <label class="col-md-2 control-label">Total</label>
                <div class="col-md-10">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-block btn-success btn-raised btn-total btn-label">${{ (servingCost + form.cart.shippingCost() / 14).toFixed(2) }}* / serving</button>
                    </div>
                    <div class="col-sm-3">
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if="cost">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <button class="btn btn-block btn-lg btn-raised"
                        @click.prevent="subscribe"
                >Signup</button>
            </div>
        </div>
    </div>
</template>

<script>
import eventBus from '../../events/eventBus';
import swal from 'sweetalert2';
import Subscriptions from '../../mixins/Subscriptions';
export default {
    mixins: [
        Subscriptions,
    ],
    props: [],
    data() {
        return {};
    },
    mounted() {
        console.log('calculator component mounted()');
    },
    methods: {
        subscribe() {
            let vm = this;
            if (this.form.pet.weight <=4 ) {
                swal('Please enter your pet\'s weight.');
                return;
            }
            axios.post('/api/subscribe', {
                weight: this.form.pet.weight,
                package_id: this.form.cart.sub_package_id,
                shipping_modifier: this.form.sub_shipping_modifier,
            }).then(response => {
                console.log(response);
                let hash = response.data;
                window.location = ('/quote/subscribe/' + hash);
            })
        }
    },
    computed: {
    }
}
</script>

<style>
    .btn-total {
        font-size: 2rem;
    }
    .btn-cost:hover {
        cursor: auto;
    }
    .btn-label {
        border-radius: 0;
        box-shadow: none;
    }

</style>