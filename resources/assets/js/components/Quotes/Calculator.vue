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

        <div class="row" v-if="discount">
            <div class="form-group" style="margin-top: 0px;">
                <label class="col-md-2 control-label">Promotion ({{ discount_rate * 100 }}% off for4 weeks)</label>
                <div class="col-md-10">
                    <div class="col-sm-3">
                        <button class="btn btn-block btn-danger btn-cost">${{ (discount).toFixed(2) }} / week</button>
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
                        <button class="btn btn-block btn-success btn-raised btn-total btn-label">${{ (cost + shippingCost - discount).toFixed(2) }}* / week</button>
                    </div>
                    <div class="col-sm-3">
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if="discount">
            <div class="form-group" style="margin-top: 0px;">
                <label class="col-md-12 control-label">*Promotional offer valid for new customers only. Promotional rate applies for the first 4 weeks of shipments only. After 4 weeks, plan pricing reverts to original pricing.</label>
                <div class="col-md-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <button class="btn btn-block btn-info btn-cost" btn-sm>${{ (cost + shippingCost).toFixed(2) }} / week afterwards</button>
                    </div>
                    <div class="col-sm-3"></div>
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
import swal from 'sweetalert2'
export default {
    props: [],
    data() {
        return {
            selectedClass: 'btn-primary',
            defaultClass: 'btn-default',
            pkgs: [],
            pkg: {},
            weight: null,
            shipping_modifier: 0,
            discount_rate: 0.10,
        };
    },
    mounted() {
        this.getPackages();
        this.getSizes();
    },
    methods: {
        getPackages() {
            let vm = this;
            axios.get('/api/packages')
                .then(function(response) {
                    vm.pkgs = response.data.filter(function(pkg) {
                        return pkg.customization == 0;
                    });
                    vm.pkg = vm.pkgs[0];
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getSizes() {
            let vm = this;
            axios.get('/api/sizes')
                .then(function(response) {
                    vm.sizes = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                    alert('There was an unknown error.')
                })
        },
        isSelected(pkg2) {
            return this.pkg && this.pkg.id === pkg2.id;
        },
        getSize() {
            let vm = this;
            let size = this.sizes.filter(function(size) {
                return vm.weight >= size.min && vm.weight <= size.max;
            });
            if (! size.length) {
                return null;
            }
            return size[0];
        },
        roundedWeight() {
            if (! this.weight) {
                return 0;
            }
            return Math.round(this.weight / 5) * 5;
        },
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
        cost() {
            if (this.weight < 5)
                return 0;

            if (!this.pkg)
                return 0;

            let size = this.getSize();
            if (! size)
                return 0;

            return size.base
            + (this.roundedWeight() - size.min) / 5 * size.inc
            + this.pkg.level * 5
            + this.pkg.customization * 3;
        },
        shippingCost() {
            return this.shipping_modifier * 5;
        },
        shippingCostLabel() {
            if (this.shipping_modifier == 0)
                return "FREE";

            return "+ $" + this.shippingCost + " / week";
        },
        discount() {
            if (this.cost) {
                return this.cost * this.discount_rate;
            }
            return 0;
        }
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