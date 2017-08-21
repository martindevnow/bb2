<template>
    <div>
        <h1>Plan Builder</h1>

        <div class="form-group">
            <label for="name"
                   class="col-md-2 control-label">Name</label>
            <div class="col-md-10">
                <input type="text"
                       v-model="name"
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
            <label for="weight"
                   class="col-md-2 control-label">Weight</label>
            <div class="col-md-10">
                <input type="text"
                       v-model="weight"
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

        <div class="form-group">
            <label class="col-md-2 control-label">Package</label>
            <div class="col-md-10">
                <div class="col-sm-4" v-for="pkg_i in packages">
                    <button class="btn btn-raised btn-block"
                            :class="[isSelected(pkg_i) ? selectedClass : defaultClass]"
                            @click="pkg = pkg_i">
                        {{ pkg_i.label }}
                    </button>

                </div>
                <span class="help-block" v-if="hasError('weight')">
                    <strong>{{ getError('weight') }}</strong>
                </span>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-2 control-label">Shipping</label>
            <div class="col-md-10">
                <div class="col-sm-3">
                    <button class="btn btn-raised btn-block"
                            :class="[shipping_modifier === 0 ? selectedClass : defaultClass]"
                            @click="shipping_modifier = 0">
                        Monthly
                    </button>
                </div>
                <div class="col-sm-3">
                <button class="btn btn-raised btn-block"
                            :class="[shipping_modifier === 1 ? selectedClass : defaultClass]"
                            @click="shipping_modifier = 1">
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
                    <button class="btn btn-raised btn-success">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
        {{ roundedWeight() }}
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
            weight: null,
            shipping_modifier: 0,
            name: '',
            sizes: [
                {label: 'S', min: 5, max: 14, base: 39, inc: 1.95},
                {label: 'M', min: 15, max: 49, base: 44.85, inc: 1.625},
                {label: 'L', min: 50, max: 94, base: 65, inc: 1.755},
                {label: 'XL', min: 95, max: 139, base: 87.1, inc: 1.95},
                {label: 'XXL', min: 140, max: 220, base: 104, inc: 2.145},
            ]
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
            if (field === 'name') {
                return this.validateName();
            }
            if (field === 'weight') {
                return this.validateWeight();
            }
        },
        validateWeight() {
            if (this.weight < 0) {
                return 'The weight must be positive.';
            }
            return null;
        },
        validateName() {
            if (this.name.length > 20) {
                return 'Max length is 20 characters.';
            }
            return null;
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
        isSelected(pkg) {
            return this.pkg && this.pkg.id === pkg.id;
        },
        roundedWeight() {
            if (! this.weight) {
                return 0;
            }
            return Math.round(this.weight / 5) * 5;
        }
    },
    mounted() {
        this.getPackages();
    },
    computed: {
        cost() {
            if (! this.weight || ! this.pkg) {
                return 0;
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