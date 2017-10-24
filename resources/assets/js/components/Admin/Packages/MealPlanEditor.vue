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
                    <admin-meal-selector @select="onSelect($event, bfast)"
                                         :autonomous="0"
                                         :selected-meal-id="mealByCalendarCode(bfast).value"
                                         :hasError="errors.has('meal_id_' + bfast)"
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
                    <admin-meal-selector @select="onSelect($event, dinner)"
                                         :autonomous="0"
                                         :selected-meal-id="mealByCalendarCode(dinner).value"
                                         :hasError="errors.has('meal_id_' + dinner)"
                    >
                    </admin-meal-selector>
                    <span class="help-block">{{ errors.get('meal_id_' + dinner) }}</span>
                </div>


            </div>
        </div>



        <div class="row">
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-primary btn-block"
                        :disabled="errors.any()"
                        @click="save()"
                >
                    Save
                </button>
            </div>
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-default btn-block"
                        @click="closeMealPlanEditorModal()"
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
    import { BasicSelect } from 'vue-search-select'
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';

    export default {
        mixins: [
            hasErrors
        ],
        components: {
            BasicSelect,
        },
        data() {
            return {
                form: {
                    package_id: null,
                    meals: [],
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
            onSelect(meal, calendar_code) {
                this.errors.clear('meal_id_' + calendar_code);
                this.form.meals[calendar_code] = {...meal,  calendar_code };
            },
            populateFormFromPackage(pkg) {
                this.form.package_id = pkg.id;
                console.log('pkg.meals');
                console.log(pkg.meals);
                this.form.meals =
                    this.toMealPlanObject(pkg.meals.map(meal => {
                         return {
                            text: meal.label + ' (' + meal.id + ')',
                            value: meal.id,
                            calendar_code: meal.calendar_code,
                        };
                    })
                );
            },
            save() {
                let vm = this;
                axios.patch('/admin/api/packages/' + vm.form.package_id + '/mealPlan', this.form)
                    .then(response => {
                        console.log(response.data);
                        vm.updatePackage(response.data);
                        vm.closeMealPlanEditorModal();
                        swal('Done', 'Thank you', 'success');
                    })
                    .catch(error => {
                        console.log(error);
                        swal('Error', 'Something went wrong...', 'error');
                    });
            },
            toMealPlanObject(mealsArray) {
                let rv = {};
                for (let i = 0; i < mealsArray.length; ++i)
                    rv[(mealsArray[i].calendar_code)] = mealsArray[i];
                console.log('rv -- 1');
                console.log(rv);

                for (let bfast of this.breakfasts) {
                    if (! rv.hasOwnProperty(bfast)) {
                        rv[bfast] = {text: 'None', value: 0, calendar_code: bfast}
                    }
                }
                console.log('rv -- 2');
                console.log(rv);
                for (let dinner of this.dinners) {
                    if (! rv.hasOwnProperty(dinner)) {
                        rv[dinner] = {text: 'None', value: 0, calendar_code: dinner}
                    }
                }
                console.log('rv -- 3');
                console.log(rv);
                return rv;
            },
            mealByCalendarCode(calCode) {
                if (! this.form.meals.hasOwnProperty(calCode) )
                    return {text: 'None', value: 0, calendar_code: calCode};

                return this.form.meals[calCode];
            }
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