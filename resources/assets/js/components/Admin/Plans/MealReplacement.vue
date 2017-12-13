<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >

        <div class="row">
            <div class="col-sm-6">
                <h1>{{ selected.package.label }} Bento</h1>
                <div class="row">
                    <div class="col-sm-12" v-for="meal in selected.package.meals">
                        {{ meal.label }} - {{ meal.pivot.calendar_code }}
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <h1>Customized for {{ selected.pet.name }}</h1>
                <div class="row">
                    <div class="col-sm-12" v-for="meal in selected.meals">
                        {{ meal.label }} - {{ meal.pivot.calendar_code }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h1>Replacements</h1>
                <div class="row">
                    <div class="col-sm-12" v-for="repl in selected.meal_replacements">
                        {{ getMealById(repl.removed_meal_id).label }} => {{ getMealById(repl.added_meal_id).label }}
                        <button class="btn btn-xs btn-danger"
                                @click="deleteReplacement(repl.id)"
                        >
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <h2>Meal to Remove</h2>
                    <admin-meal-selector v-model="form.removed_meal"></admin-meal-selector>
                </div>
            </div>
            <div class="col-sm-6">
                <h2>Meal to Add</h2>
                <admin-meal-selector v-model="form.added_meal"></admin-meal-selector>
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
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';
    import hasErrors from '../../../mixins/hasErrors';

    export default {
        mixins: [
            hasErrors
        ],
        data() {
            return {
                form : {
                    removed_meal: {},
                    added_meal: {},
                },
            };
        },
        methods: {
            ...mapActions('meals', [
                'loadMeals'
            ]),
            save() {
                let vm = this;
                axios.post('/admin/api/plans/' + vm.selected.id + '/replaceMeal', {
                    removed_meal_id: vm.form.removed_meal.id,
                    added_meal_id: vm.form.added_meal.id,
                }).then(response => {
                    console.log(response);
                    vm.$emit('saved');
                }).catch(error => {
                    console.log(error);
                });
            },
            getMealById(meal_id) {
                return this.collection.filter(meal => {
                    return meal.id === meal_id;
                })[0];
            },
            deleteReplacement(id) {
                let vm = this;
                axios.delete('/admin/api/mealReplacements/' + id).then(response => {
                    alert('Removed');
                }).catch(error => {
                    alert('Error');
                });
            }
        },
        computed: {
            ...mapState('plans', [
                'show',
                'selected',
            ]),
            ...mapState('meals', [
                'collection'
            ])
        },
        mounted() {
            this.loadMeals();
        }
    }
</script>

<style>

</style>