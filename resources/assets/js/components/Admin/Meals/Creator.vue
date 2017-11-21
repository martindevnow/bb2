<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('code') }"
                >
                    <label for="code">Code</label>
                    <input type="text"
                           class="form-control"
                           id="code"
                           name="code"
                           v-model="form.code"
                           placeholder="M-CH-BL"
                    >
                    <span class="help-block">{{ errors.get('code') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('label') }"
                >
                    <label for="label">Label</label>
                    <input type="text"
                           class="form-control"
                           id="label"
                           name="label"
                           v-model="form.label"
                           placeholder="Chicken (Boneless)"
                    >
                    <span class="help-block">{{ errors.get('label') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meal_value') }"
                >
                    <label for="meal_value">Meal Value (1 or 2 meals worth of food)</label>
                    <input type="text"
                           class="form-control"
                           id="meal_value"
                           name="meal_value"
                           v-model="form.meal_value"
                    >
                    <span class="help-block">{{ errors.get('meal_value') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('meats') }"
                >
                <h2>Meats</h2>
                    <admin-meat-selector v-for="(mealMeat, index) in form.meats"
                                         :key="index"
                                         v-model="form.meats[index]"
                                         @input="errors.clear('meats')"
                                         :deletable="true"
                                         @delete="removeMeat(index)"
                    >
                    </admin-meat-selector>
                    <button class="btn btn-block"
                            @click="form.meats.push({})"
                    >+</button>
                    <span class="help-block">{{ errors.get('meats') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <h2>Toppings</h2>
                <admin-topping-selector v-for="(mealTopping, index) in form.toppings"
                                        :key="index"
                                        v-model="form.toppings[index]"
                                        @input="errors.clear('toppings')"
                                        :deletable="true"
                                        @delete="removeTopping(index)"
                >
                </admin-topping-selector>
                <button class="btn btn-block"
                        @click="form.toppings.push({})"
                >+</button>
                <span class="help-block">{{ errors.get('toppings') }}</span>
            </div>
        </div>



        <div class="row">
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-success btn-block"
                        :disabled="errors.any()"
                        @click="save()"
                        v-if="! mode"
                >
                    Save
                </button>
                <button class="btn btn-primary btn-block"
                        :disabled="errors.any()"
                        @click="update()"
                        v-if="mode == 'EDIT'"
                >
                    Update
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
import hasErrors from '../../../mixins/hasErrors';
import Form from '../../../models/Form';
import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';
import moment from 'moment';

export default {
    mixins: [
        hasErrors
    ],
    data() {
        return {
            form: {
                code: '',
                label: '',
                meal_value: null,
                meats: [],
                toppings: [],
            },
        };
    },
    methods: {
        ...mapActions('meals', [
            'editMeal',
        ]),
        ...mapMutations('meals', [
            'addToMealsCollection',
            'updateMeal',
        ]),
        removeTopping(index) {
            this.form.toppings.splice(index, 1);
        },
        removeMeat(index) {
            this.form.meats.splice(index, 1);
        },
        populateFormFromMeal(meal) {
            this.form.code = meal.code;
            this.form.label = meal.label;
            this.form.meal_value = meal.meal_value;
            this.form.meats = meal.meats;
            this.form.toppings = meal.toppings;
        },
        save() {
            let vm = this;
            let meats = this.form.meats.map(meat => meat.id);
            let toppings = this.form.toppings.map(topping => topping.id);
            return axios.post('/admin/api/meals', {
                ...this.form, meats, toppings
            }).then(response => {
                vm.addToMealsCollection(response.data);
                vm.$emit('saved');
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        update() {
            let vm = this;
            let meats = this.form.meats.filter(item => item.id).map(item => item.id);
            let toppings = this.form.toppings.filter(item => item.id).map(item => item.id);

            return axios.patch('/admin/api/meals/' + this.selected.id, {
                ...this.form, meats, toppings
            }).then(response => {
                vm.updateMeal(response.data);
                vm.$emit('saved');
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        }
    },
    computed: {
        ...mapState('meals', ['show', 'selected', 'mode', 'collection']),
    },
    mounted() {
        if (this.mode == 'EDIT') {
            this.populateFormFromMeal(this.selected);
        }
    },
    watch: {
        selected(newSelected) {
            this.populateFormFromMeal(newSelected);
        }
    }
}
</script>

<style>

</style>