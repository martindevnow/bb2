<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('code') }"
                >
                    <label for="code">code</label>
                    <input type="text"
                           class="form-control"
                           id="code"
                           name="code"
                           v-model="form.code"
                    >
                    <span class="help-block">{{ errors.get('code') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('label') }"
                >
                    <label for="label">label</label>
                    <input type="text"
                           class="form-control"
                           id="label"
                           name="label"
                           v-model="form.label"
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
                    <label for="meal_value">meal_value</label>
                    <input type="text"
                           class="form-control"
                           id="meal_value"
                           name="meal_value"
                           v-model="form.meal_value"
                    >
                    <span class="help-block">{{ errors.get('meal_value') }}</span>
                </div>
            </div>
            <!--<div class="col-sm-6">-->
                <!--<div class="form-group"-->
                     <!--:class="{ 'has-error': errors.has('label') }"-->
                <!--&gt;-->
                    <!--<label for="label">label</label>-->
                    <!--<input type="text"-->
                           <!--class="form-control"-->
                           <!--id="label"-->
                           <!--name="label"-->
                           <!--v-model="form.label"-->
                    <!--&gt;-->
                    <!--<span class="help-block">{{ errors.get('label') }}</span>-->
                <!--</div>-->
            <!--</div>-->
        </div>

        <div class="row">
            <div class="col-sm-6">
                <h2>Meats</h2>
                <model-list-select v-for="(mealMeat, index) in form.meats"
                                   :key="index"
                                   :list="meats"
                                   v-model="form.meats[index]"
                                   option-value="code"
                                   option-text="label"
                                   :custom-text="meatLabel"
                                   placeholder="select meat">
                </model-list-select>
                <button class="btn btn-block"
                        @click="form.meats.push({})"
                >+</button>
            </div>
            <div class="col-sm-6">
                <h2>Toppings</h2>
                <model-list-select v-for="(mealTopping, index) in form.toppings"
                                   :key="index"
                                   :list="toppings"
                                   v-model="form.toppings[index]"
                                   option-value="code"
                                   option-text="label"
                                   :custom-text="toppingLabel"
                                   placeholder="select topping">
                </model-list-select>
                <button class="btn btn-block"
                        @click="form.toppings.push({})"
                >+</button>
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
                        @click="closeMealCreatorModal()"
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
import Datepicker from 'vuejs-datepicker';
import { BasicSelect, ModelListSelect } from 'vue-search-select'

export default {
    mixins: [
        hasErrors
    ],
    components: {
        Datepicker,
        BasicSelect,
        ModelListSelect,
    },
    data() {
        return {
            owner: {
                value: '',
                text: '',
            },
            form: {
                code: '',
                label: '',
                meats: [],
                toppings: [],
            },
        };
    },
    methods: {
        ...mapActions('meals', [
            'closeMealCreatorModal',
        ]),
        ...mapMutations('meals', [
            'addToMealsCollection',
        ]),
        ...mapActions('meats', [
            'loadMeats',
        ]),
        ...mapActions('toppings', [
            'loadToppings',
        ]),
        meatLabel (item) {
            return `${item.type} - ${item.variety} - ${item.code}`
        },
        toppingLabel (item) {
            return `${item.label} - ${item.code}`
        },
        populateFormFromMeal(meal) {
            this.form.code = meal.code;
            this.form.label = meal.label;
            this.form.meats = meal.meats;
            this.form.toppings = meal.toppings;
        },
        save() {
            let vm = this;
            let meats = this.form.meats.map(meat => meat.id);
            let toppings = this.form.toppings.map(topping => topping.id);
            this.form.meats = meats;
            this.form.toppings = toppings;
            return axios.post('/admin/api/meals', {
                ...this.form,
            }).then(response => {
                vm.addToMealsCollection(response.data);
                vm.closeMealCreatorModal();
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
    },
    computed: {
        ...mapState('meals', ['show', 'selected', 'mode']),
        ...mapState('meats', {
            'meats': 'collection'
        }),
        ...mapState('toppings', {
            'toppings': 'collection'
        }),
    },
    mounted() {
        this.loadMeats();
        this.loadToppings();
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