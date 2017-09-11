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
                               v-model="weight"
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
                    <div class="col-sm-3" v-for="pkg_i in pkgs">
                        <button class="btn btn-raised btn-block btn-label"
                                :class="[isSelected(pkg_i) ? selectedClass : defaultClass]"
                                @click.prevent="pkg = pkg_i">
                            {{ pkg_i.label }}
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
                            {{ shippingCostLabel }}
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-raised btn-block btn-label"
                                :class="[shipping_modifier === 0 ? selectedClass : defaultClass]"
                                @click.prevent="shipping_modifier = 0">
                            Monthly
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-raised btn-block btn-label"
                                :class="[shipping_modifier === 1 ? selectedClass : defaultClass]"
                                @click.prevent="shipping_modifier = 1">
                            Bi-Weekly
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-raised btn-block btn-label"
                                :class="[shipping_modifier === 2 ? selectedClass : defaultClass]"
                                @click.prevent="shipping_modifier = 2">
                            Weekly
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="form-group" style="margin-top: 0px;">
                <label class="col-md-2 control-label">Total</label>
                <div class="col-md-10">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-block btn-success btn-raised btn-total btn-label">${{ (servingCost + shippingCost / 14).toFixed(2) }}* / serving</button>
                    </div>
                    <div class="col-sm-3">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
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
import Pricing from '../../mixins/pricing';
export default {
    mixins: [
        Pricing,
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
            if (this.weight <=4 ) {
                swal('Please enter your pet\'s weight.');
                return;
            }
            axios.post('/api/subscribe', {
                weight: this.weight,
                package_id: this.pkg.id,
                shipping_modifier: this.shipping_modifier,
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