<template>
    <basic-select :options="mealOptions"
                  :selected-option="selectedMeal"
                  placeholder="Select Meal..."
                  @select="onSelect"
                  :isError="hasError"
    >
    </basic-select>
</template>

<script>
    import swal from 'sweetalert2'
    import { BasicSelect } from 'vue-search-select'
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';

    export default {
        mixins: [
        ],
        props: [
            'model',
            'modelApi',
            'selectedMealId',
            'autonomous',
            'hasError',
        ],
        components: {
            BasicSelect,
        },
        data() {
            return {};
        },
        methods: {
            ...mapActions('meals', [
                'loadMeals'
            ]),
            onSelect(meal) {
                this.selectedMealId = meal.value;

                if (! this.autonomous) {
                    return this.$emit('select', meal);
                }

                let vm = this;
                swal({
                    title: 'Are you sure?',
                    text: "Changing the meal will affect all Plans using this ...",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then(function () {
                    axios.post('/admin/api/'+ vm.modelApi + '/' + vm.model.id + '/updateMeal',
                        { meal_id: meal.value }
                    )
                        .then(response => {
                            swal('Updated', 'The meal has been updated.', 'success');
                        })
                        .catch(error => {
                            swal('Failed...', 'The meal could not be updated...', 'error');
                        });
                }, function(dismiss) {
                    swal('You did not approve... ');
                });
            }
        },
        computed: {
            ...mapState('meals', [
                'collection',
            ]),
            mealOptions() {
                let arr = this.collection.map(model => {
                    return { value: model.id, text: model.label + ' (' + model.id + ')' };
                });
                arr.unshift({value: 0, text: 'None'});
                return arr;
            },
            selectedMeal() {
                let vm = this;
                return this.mealOptions.filter(meal => {
                    return meal.value === vm.selectedMealId;
                })[0];
            }
        }
    }
</script>

<style>

</style>