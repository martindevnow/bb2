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
            <option selected value="1">Monthly</option>
            <option value="2">Bi-Weekly</option>
        </select><br />
        Cost: {{ cost }} <br />
        <button type="submit" class="btn btn-xl btn-primary">Subscribe</button>
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
            shipping_modifier: 1,
            name: '',
        };
    },
    methods: {
        getPackages() {
            let vm = this;
            axios.get('/api/packages')
                .then(function(response) {
                    vm.packages = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        packagingCost() {
            if (this.weight > 50) {
                return 5;
            }
            return 3;
        },
        packingCost() {
            return 10;
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
        }

    },
    mounted() {
        this.getPackages();
    },
    computed: {
        cost() {
            return this.weight * .022 * 7 * this.pkg.costPerLb
                    + this.packingCost()
                    + this.packagingCost()
                    + this.shippingCost();
        }
    },

}
</script>

<style>

</style>