<template>
    <div>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Pet / Plan</th>
                <th>Wks/Shipment</th>
                <th>
                    Wks to Order
                    <button class="btn btn-xs btn-primary" @click="defaultPlansToOrder()">Default</button>
                    <button class="btn btn-xs btn-warning" @click="clearPlansToOrder()">Clear</button>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(plan, index) in plansToOrder">
                <td>{{ plan.pet.name }} - on {{ plan.package.label }} bento ...</td>
                <td>{{ plan.weeks_of_food_per_shipment }}</td>
                <td>
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
    import * as planActions from "../../../vuex/modules/plans/actionTypes";
    import * as packageActions from "../../../vuex/modules/packages/actionTypes";
    import * as meatActions from "../../../vuex/modules/meats/actionTypes";
    import * as mealActions from "../../../vuex/modules/meals/actionTypes";
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

            this.$store.dispatch('plans/' + planActions.FETCH_ALL)
                .then(resposne => {
                    vm.populatePlansToOrder();
            });
            this.$store.dispatch('packages/' + packageActions.FETCH_ALL)
                .then(response => {
                    vm.populatePackagesToOrder();
            });
            this.$store.dispatch('meats/' + meatActions.FETCH_ALL)
                .then(response => {
                    vm.populateMeatsToOrder();
            });
            this.$store.dispatch('meals/' + mealActions.FETCH_ALL)
                .then(response => {
                    vm.populateMealsToOrder();
            });
        },
        methods: {
            getMealSize(weight, activity_level) {
                return weight * activity_level / 100 / 2 * 454;
            },
            isBreakfast(meal) {
                return (
                       meal.pivot.calendar_code == 'B1'
                    || meal.pivot.calendar_code == 'B2'
                    || meal.pivot.calendar_code == 'B3'
                    || meal.pivot.calendar_code == 'B4'
                    || meal.pivot.calendar_code == 'B5'
                    || meal.pivot.calendar_code == 'B6'
                    || meal.pivot.calendar_code == 'B7'
                );
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
            clearPlansToOrder() {
                this.plansToOrder = this.plansToOrder.map(plan => {
                    plan.weeksToOrder = 0;
                    return plan;
                });
            },
            defaultPlansToOrder() {
                this.plansToOrder = [];
                this.populatePlansToOrder();
            },
            calculate() {
                let vm = this;
                let orderingPlans = this.plansToOrder.filter(plan => plan.weeksToOrder);
                orderingPlans.forEach(plan => {
                    plan.meals.forEach(meal => {
                        meal.meats.forEach(meat => {
                            let meat_weight = vm.getMealSize(plan.pet_weight, plan.pet_activity_level);
                            if (plan.pet.daily_meals == 3) {
                                if (vm.isBreakfast(meal)) {
                                    meat_weight = meat_weight * 2 / 3 * 2; //
                                } else {
                                    meat_weight = meat_weight * 2 / 3; //   1/2 ->  2/2 -> 2/6 -> 1/3
                                }
                            }
                            vm.addMeatToOrder(meat.id, meat_weight);
                        });
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