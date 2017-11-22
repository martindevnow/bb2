<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >

        <div class="row">
            <div class="col-sm-6">
                <h2>Breakfasts</h2>

                <div class="form-group"
                     v-for="(bfast, index) in breakfasts"
                     :class="{ 'has-error': errors.has('meal_id_' + bfast) }"
                >
                    <label>Day {{ index + 1 }}</label>
                    <admin-meal-selector :key="bfast"
                                         v-model="form.meals[bfast]"
                                         @input="errors.clear('meal_id_' + bfast)"
                                         :deletable="true"
                                         @delete="removeMeal(bfast)"
                    >
                    </admin-meal-selector>

                    <span class="help-block">{{ errors.get('meal_id_' + bfast) }}</span>
                </div>

            </div>
            <div class="col-sm-6">

                <h2>Dinners</h2>

                <div class="form-group"
                     v-for="(dinner, index) in dinners"
                     :class="{ 'has-error': errors.has('meal_id_' + dinner) }"
                >
                    <label>Day {{ index + 1 }}</label>
                    <admin-meal-selector :key="dinner"
                                         v-model="form.meals[dinner]"
                                         @input="errors.clear('meal_id_' + dinner)"
                                         :deletable="true"
                                         @delete="removeMeal(dinner)"
                    >
                    </admin-meal-selector>
                    <span class="help-block">{{ errors.get('meal_id_' + dinner) }}</span>
                </div>


            </div>
        </div>



        <div class="row">
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-success btn-block"
                        :disabled="errors.any()"
                        @click="save()"
                >
                    Save
                </button>
            </div>
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-default btn-block"
                        @click="$emit('cancelled')"
                >
                    Cancel
                </button>
            </div>
        </div>


    </form>
</template>

<script>
    import swal from 'sweetalert2';
    import hasErrors from '../../../mixins/hasErrors';
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';

    export default {
        mixins: [
            hasErrors
        ],
        data() {
            return {
                form: {
                    package_id: null,
                    meals: {
                        B1: {},
                        B2: {},
                        B3: {},
                        B4: {},
                        B5: {},
                        B6: {},
                        B7: {},
                        D1: {},
                        D2: {},
                        D3: {},
                        D4: {},
                        D5: {},
                        D6: {},
                        D7: {},
                     },
                },
                breakfasts: [
                    'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7',
                ],
                dinners: [
                    'D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7',
                ]
            };
        },
        methods: {
            ...mapActions('meals', [
                'loadMeals',
            ]),
            ...mapActions('packages', [
                'closeMealPlanEditorModal'
            ]),
            ...mapMutations('packages', [
                'updatePackage'
            ]),
            removeMeal(key) {
                this.form.meals[key] = {};
            },
            populateFormFromPackage(pkg) {
                let vm = this;

                this.form.package_id = pkg.id;
                pkg.meals.forEach(meal => {
                    vm.form.meals[meal.calendar_code] = meal;
                });
            },
            buildMealPlan() {
                let meals = [];
                for (let cal_code in this.form.meals) {
                    if (this.form.meals[cal_code].id) {
                        meals.push({
                            ...this.form.meals[cal_code],
                            calendar_code: cal_code,
                        });
                    }
                }
                return meals;
            },
            save() {
                let vm = this;
                let meals = this.buildMealPlan();
                axios.patch('/admin/api/packages/' + vm.form.package_id + '/mealPlan', {
                    ...this.form, meals
                }).then(response => {
                    vm.updatePackage(response.data);
                    vm.closeMealPlanEditorModal();
                    swal('Done', 'Thank you', 'success');
                })
                .catch(error => {
                    console.log(error);
                    swal('Error', 'Something went wrong...', 'error');
                });
            },
        },
        computed: {
            ...mapState('packages', [
                'show',
                'selected'
            ]),
            ...mapState('meals', {
                'meals': 'collection',
            }),
            mealsSelect() {
                return this.meals.map(model => {
                    return { value: model.id, text: model.label + ' (' + model.id + ')' };
                });
            },
        },
        mounted() {
            this.loadMeals();
            this.populateFormFromPackage(this.selected);
        },
        watch: {
            selected(newSelected) {
                this.populateFormFromPackage(newSelected);
            }
        }
    }
</script>

<style>

</style>