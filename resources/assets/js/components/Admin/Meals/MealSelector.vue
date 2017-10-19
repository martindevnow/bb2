<template>
    <basic-select :options="mealOptions"
                  :selected-option="selectedMeal"
                  placeholder="Select Meal..."
                  @select="onSelect"
                  :class="{ 'has-error': errors.has('name') }"
    >
    </basic-select>
</template>

<script>
    import { BasicSelect } from 'vue-search-select'
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';
    import hasErrors from '../../../mixins/hasErrors';

    export default {
        mixins: [
            hasErrors
        ],
        props: [
            'model',
            'modelApi',
            'selectedMealId',
            'autonomous',
        ],
        components: {
            BasicSelect,
        },
        data() {
            return {
                selectedId: null,
            };
        },
        mounted() {
//            this.loadMeals();
            this.selectedId = this.selectedMealId;
        },
        methods: {
            ...mapActions('meals', [
                'loadMeals'
            ]),
            onSelect(meal) {
                this.selectedId = meal.value;
                if (! this.autonomous) {
                    return this.$emit('select', meal);
                }
                let vm = this;
//                swal({
//                    title: 'Are you sure?',
//                    text: "Changing the plan will affect all open orders...",
//                    type: 'warning',
//                    showCancelButton: true,
//                    confirmButtonColor: '#3085d6',
//                    cancelButtonColor: '#d33',
//                    confirmButtonText: 'Yes, update it!'
//                }).then(function () {
                    axios.post('/admin/api/'+ this.modelApi + '/' + this.model.id + '/updateMeal',
                        { meal_id: meal.value }
                    )
                        .then(response => {
                            alert('That meal has been updated.');
                            swal('Updated', 'The meal has been updated.', 'success');
                        })
                        .catch(error => {
                            alert('That meal has been updated.');
                            swal2('Failed...', 'The meal could not be updated...', 'error');
                        });
//                }, function(dismiss) {
//                    swal('You did not approve... ');
//                });

            }
        },
        computed: {
            ...mapState('meals', [
                'collection',
            ]),
            mealOptions() {
                return this.collection.map(model => {
                    return { value: model.id, text: model.label + ' (' + model.id + ')' };
                });
            },
            selectedMeal() {
                let vm = this;
                return this.mealOptions.filter(meal => {
                    return meal.value === vm.selectedId;
                })[0];
            }

        }

    }
</script>

<style>

</style>