<template>
    <div>
        <table class="table table-striped table-bordered">
            <tbody>
            <tr v-for="(plan, index) in plansToOrder">
                <td>{{ plan.pet.name }} - on {{ plan.package.label }} bento ...</td>
                <td>{{ plan.weeks_of_food_per_shipment }} weeks at a time</td>
                <td>
                    weeks to order:
                    <input type="text" v-model="plansToOrder[index].weeksToOrder">
                </td>

            </tr>
            </tbody>
        </table>
        <button class="btn btn-primary"
                @click="calculate()"
        >Calculate</button>

        <table class="table table-bordered table-striped">
            <tbody>
            <tr v-for="meat in meatsToBeOrdered">
                <td>{{ meat.type }} ({{ meat.variety }})</td>
                <td>{{ meat.weightToOrder.toFixed(2) }} g</td>
                <td>{{ (meat.weightToOrder / 454).toFixed(2) }} lb</td>
            </tr>
            <tr>
                <td>Total:</td>
                <td>{{ totalMeatOrder.toFixed(2) }}</td>
                <td>{{ (totalMeatOrder / 454).toFixed(2) }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import { mapGetters, mapState, mapActions } from 'vuex';
    import isSortable from '../../../mixins/isSortable';
    export default {
        mixins: [
            isSortable
        ],
        data() {
            let columns = [
                'id',
                'customer_name',
                'pet_name',
                'package_label',
                'weeks_of_food',
                'weeks_per_shipment',
                'cost',
            ];
            let numColumns = columns.length;
            let sortOrders = {};
            columns.forEach(function(key) {
                sortOrders[key] = 1;
            });

            return {
                columns: columns,
                numColumns: numColumns,
                sortOrders: sortOrders,
                plansToOrder: [],
                meatsToOrder: [],
                mealsToOrder: [],
                packagesToOrder: [],
            }
        },
        mounted() {
            let vm = this;
            this.loadPlans().then(resposne => {
                vm.populatePlansToOrder();
            });
            this.loadPackages().then(response => {
                vm.populatePackagesToOrder();
            });
            this.loadMeats().then(response => {
                vm.populateMeatsToOrder();
            });
            this.loadMeals().then(response => {
                vm.populateMealsToOrder();
            });
        },
        methods: {
            ...mapActions('plans', [
                'openPlanCreatorModal',
                'closePlanCreatorModal',
                'loadPlans',
                'editPlan',
            ]),
            ...mapActions('packages', [
                'loadPackages',
            ]),
            ...mapActions('meats', [
                'loadMeats',
            ]),
            ...mapActions('meals', [
                'loadMeals',
            ]),
            getMealSize(weight, activity_level) {
                return weight * activity_level / 100 / 2 * 454;
            },
            clearPackagesToOrder() {
                this.packagesToOrder.map(pkg => {
                    delete pkg.mealSizeToOrder;
                    return pkg;
                });
            },
            clearMealsToOrder() {
                this.mealsToOrder.map(meal => {
                    delete meal.weightToOrder;
                    return meal;
                });
            },
            clearMeatsToOrder() {
                this.meatsToOrder.map(meat => {
                    delete meat.weightToOrder;
                    return meat;
                });
            },
            populateMeatsToOrder() {
                this.meatsToOrder = [ ...this.meats ];
            },
            populatePlansToOrder() {
                this.plansToOrder = [ ...this.collection.map(plan => {
                    plan.weeksToOrder = plan.weeks_of_food_per_shipment;
                    return plan;
                }) ];
            },
            populatePackagesToOrder() {
                this.packagesToOrder = [ ...this.packages ];
            },
            populateMealsToOrder() {
                this.mealsToOrder = [ ...this.meals ];
            },
            addPackageToOrder(package_id, weeks, weight, activity) {
                let meal_weight = this.getMealSize(weight, activity);
                this.packagesToOrder = this.packagesToOrder.map(pkg => {
                    if (pkg.id === package_id) {
                        pkg.mealSizeToOrder = (pkg.mealSizeToOrder ? pkg.mealSizeToOrder : 0)
                            + meal_weight * weeks;
                    }
                    return pkg;
                });
            },
            addMealToOrder(meal_id, meal_weight_g) {
                this.mealsToOrder = this.mealsToOrder.map(meal => {
                    if (meal.id === meal_id) {
                        meal.weightToOrder = (meal.weightToOrder ? meal.weightToOrder : 0)
                            + meal_weight_g;
                    }
                    return meal;
                });
            },
            addMeatToOrder(meat_id, meat_weight_g) {
                this.meatsToOrder = this.meatsToOrder.map(meat => {
                    if (meat.id === meat_id) {
                        meat.weightToOrder = (meat.weightToOrder ? meat.weightToOrder : 0)
                            + meat_weight_g;
                    }
                    return meat;
                });
            },

            calculate() {
                let vm = this;

                // clear out old calculations...
                this.clearPackagesToOrder();
                this.clearMealsToOrder();
                this.clearMeatsToOrder();

                let orderingPlans = this.plansToOrder.filter(plan => plan.weeksToOrder);
                orderingPlans.forEach(plan => {
                    vm.addPackageToOrder(plan.package.id, plan.weeksToOrder, plan.pet_weight, plan.pet_activity_level);
                });

                let orderingPackages = this.packagesToOrder.filter(pkg => pkg.mealSizeToOrder);
                orderingPackages.forEach(pkg => {
                    pkg.meals.forEach(meal => {
                        vm.addMealToOrder(meal.id, pkg.mealSizeToOrder);
                    });
                });

                let orderingMeals = this.mealsToOrder.filter(meal => meal.weightToOrder);
                orderingMeals.forEach(meal => {
                    meal.meats.forEach(meat => {
                        vm.addMeatToOrder(meat.id, meal.weightToOrder / meal.meats.length);
                    });
                });
            }
        },
        computed: {
            ...mapState('plans', [
                'collection',
                'show',
                'selected',
                'mode',
            ]),
            ...mapState('meats', {
                'meats': 'collection',
            }),
            ...mapState('meals', {
                'meals': 'collection',
            }),
            ...mapState('packages', {
                'packages': 'collection',
            }),
            totalMeatOrder() {
                return this.meatsToOrder.reduce((sum, meat) => {
                    return sum + (meat.weightToOrder ? parseInt(meat.weightToOrder) : 0 );
                }, 0);
            },
            meatsToBeOrdered() {
                return this.meatsToOrder.filter(meat => meat.weightToOrder);
            }
        },
    }
</script>

<style>

</style>