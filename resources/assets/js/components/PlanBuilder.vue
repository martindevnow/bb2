<template>
    <div>
        <h1>Plan Builder</h1>

        <div class="form-group">
            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text"
                       v-model="name"
                       name="name"
                       class="form-control"
                       id="name"
                       aria-describedby="nameHelp"
                       placeholder="name"
                       autocomplete="off">

                    <span class="help-block" v-if="hasError('name')">
                        <strong>{{ getError('name') }}</strong>
                    </span>
            </div>
            <small id="nameHelp" class="form-text text-muted">What is your pet's name?</small>
        </div>

        <div class="form-group">
            <div class="input-group">
                <label for="weight">Weight:</label>
                <input type="text"
                       v-model="weight"
                       name="weight"
                       class="form-control"
                       id="weight"
                       aria-describedby="weightHelp"
                       placeholder=""
                       autocomplete="off">
                    <span class="help-block" v-if="hasError('weight')">
                        <strong>{{ getError('weight') }}</strong>
                    </span>
            </div>
            <small id="weightHelp" class="form-text text-muted">Your pet's weight in pounds</small>
        </div>

        <div class="form-group">
            <div class="input-group">
                <label for="package">Package:</label>
                <select v-model="pkg"
                       name="package"
                       class="form-control"
                       id="package"
                       aria-describedby="packageHelp"
                       autocomplete="off">
                    <option v-for="pkg in packages"
                            :value="pkg"
                    >
                        {{ pkg.label }}
                    </option>
                </select>
            </div>
            <small id="packageHelp" class="form-text text-muted">Your pet's package in pounds</small>
        </div>

        Shipping
        <select v-model="shipping_modifier">
            <option selected value="0">Monthly</option>
            <option value="1">Bi-Weekly</option>
        </select><br />
        Cost: {{ cost }} <br />
        <button type="submit" class="btn btn-xl btn-primary">Subscribe</button>

        {{ getSize() ? getSize().base : 'No size...' }}
    </div>
</template>

<script>
export default {
    props: [],
    data() {
        return {
            packages: [],
            pkg: {},
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
                + (this.weight - size.min) * size.inc
                + this.pkg.level * 5
                + this.pkg.customization * 3
                + this.shippingCost();
        }
    },

}
</script>

<style>

</style>