<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >

        <div class="row">
            <div class="col-sm-6">
                <h2>Breakfasts</h2>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_1B') }"
                >
                    <label>Day1</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.B1"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '1B')"
                                  :class="{ 'has-error': errors.has('meal_id_1B') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_1B') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_2B') }"
                >
                    <label>Day 2</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.B2"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '2B')"
                                  :class="{ 'has-error': errors.has('meal_id_2B') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_2B') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_3B') }"
                >
                    <label>Day 3</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.B3"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '3B')"
                                  :class="{ 'has-error': errors.has('meal_id_3B') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_3B') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_4B') }"
                >
                    <label>Day 4</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.B4"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '4B')"
                                  :class="{ 'has-error': errors.has('meal_id_4B') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_4B') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_5B') }"
                >
                    <label>Day 5</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.B5"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '5B')"
                                  :class="{ 'has-error': errors.has('meal_id_5B') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_5B') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_6B') }"
                >
                    <label>Day 6</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.B6"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '6B')"
                                  :class="{ 'has-error': errors.has('meal_id_6B') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_6B') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_7B') }"
                >
                    <label>Day 7</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.B7"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '7B')"
                                  :class="{ 'has-error': errors.has('meal_id_7B') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_7B') }}</span>
                </div>











            </div>
            <div class="col-sm-6">

                <h2>Dinners</h2>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_1D') }"
                >
                    <label>Day 1</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.D1"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '1D')"
                                  :class="{ 'has-error': errors.has('meal_id_1D') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_1D') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_2D') }"
                >
                    <label>Day 2</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.D2"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '2D')"
                                  :class="{ 'has-error': errors.has('meal_id_2D') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_2D') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_3D') }"
                >
                    <label>Day 3</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.D3"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '3D')"
                                  :class="{ 'has-error': errors.has('meal_id_3D') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_3D') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_4D') }"
                >
                    <label>Day 4</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.D4"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '4D')"
                                  :class="{ 'has-error': errors.has('meal_id_4D') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_4D') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_5D') }"
                >
                    <label>Day 5</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.D5"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '5D')"
                                  :class="{ 'has-error': errors.has('meal_id_5D') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_5D') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_6D') }"
                >
                    <label>Day 6</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.D6"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '6D')"
                                  :class="{ 'has-error': errors.has('meal_id_6D') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_6D') }}</span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_id_7D') }"
                >
                    <label>Day 7</label>
                    <basic-select :options="mealsSelect"
                                  :selected-option="form.meals.D7"
                                  placeholder="Select Meal..."
                                  @select="onSelect($event, '7D')"
                                  :class="{ 'has-error': errors.has('meal_id_7D') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('meal_id_7D') }}</span>
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
                meal: {
                    value: '',
                    text: '',
                },
                form: {
                    package_id: null,
                    meals: [],
                }
            };
        },
        methods: {
            ...mapActions('meals', [
                'loadMeals',
            ]),
            ...mapActions('packages', [
                'closeMealPlanEditorModal'
            ]),
            onSelect(meal, calendar_code) {
                this.errors.clear('meal_id_' + calendar_code);
                this.form.meals[this.reverseString(calendar_code)] = {...meal,  calendar_code };
            },
            populateFormFromPackage(pkg) {
                this.form.package_id = pkg.id;
                this.form.meals =
                    this.toMealPlanObject(pkg.meals.map(meal => {
                         return {
                            text: meal.label + ' (' + meal.id + ')',
                            value: meal.id,
                            calendar_code: meal.pivot.calendar_code,
                        };
                    })
                );

            },
            save() {
                let vm = this;
                axios.post('/admin/api/packages/' + vm.form.package_id + '/mealPlan', this.form)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                alert('done');
            },
            toMealPlanObject(mealsArray) {
                let rv = {};
                for (let i = 0; i < mealsArray.length; ++i)
                    rv[this.reverseString(mealsArray[i].calendar_code)] = mealsArray[i];
                return rv;
            },
            reverseString(str) {
                let splitString = str.split('');
                let reverseArray = splitString.reverse();
                return reverseArray.join('');
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
            }
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