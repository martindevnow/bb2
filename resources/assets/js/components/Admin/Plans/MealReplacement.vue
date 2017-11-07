<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >
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


            }
        },
        computed: {
            ...mapState('plans', [
                'show',
                'selected',
            ]),
        },
        mounted() {
            this.loadMeals();
        }
    }
</script>

<style>

</style>