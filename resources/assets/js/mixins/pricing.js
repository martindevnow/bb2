import swal from 'sweetalert2';

export default {
    data() {
        return {
            prices: [],
            pkgs: [],
            pkg: {},
            weight: null,
            shipping_modifier: 0,
            selectedClass: 'btn-primary',
            defaultClass: 'btn-default',
        }
    },
    methods: {
        getPricingModels() {
            let vm = this;
            axios.get('/api/pricing')
                .then(function(response) {
                    vm.prices = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                    swal('There was an unknown error.')
                })
        },
        getPricingModel(weight) {
            let vm = this;
            let pricing = this.prices.filter(function(pricingModel) {
                return weight >= pricingModel.min_weight
                    && weight <= pricingModel.max_weight;
            });
            if (! pricing.length) {
                return null;
            }
            return pricing[0];
        },
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
        isSelected(pkg2) {
            return this.pkg && this.pkg.id === pkg2.id;
        },
        roundedWeight() {
            if (! this.weight) {
                return 0;
            }
            return Math.round(this.weight / 5) * 5;
        },
        shippingFrequency(shipping_modifier) {
            if (! shipping_modifier || shipping_modifier == 2)
                return 'Weekly';

            if (shipping_modifier == 0)
                return 'Monthly'

            if (shipping_modifier == 1)
                return 'Bi-Weekly'
        },
    },
    mounted() {
        console.log('pricing mixin mounted');
        this.getPricingModels();
        this.getPackages();
    },
    computed: {
        cost() {
            if (this.weight < 5)
                return 0;

            if (!this.pkg)
                return 0;

            let price = this.getPricingModel(this.weight);
            if (! price)
                return 0;

            return price.base_cost
                + (this.roundedWeight() - price.min_weight) / 5 * price.incremental_cost
                + this.pkg.level * price.upgrade_cost
                + this.pkg.customization * price.customization_cost;
        },
        servingCost() {
            return this.cost / 14;
        },
        shippingCost() {
            return this.shipping_modifier * 5;
        },
        shippingCostLabel() {
            if (this.shipping_modifier == 0)
                return "FREE";

            return "+ $" + this.shippingCost + " / week";
        },

    }
}