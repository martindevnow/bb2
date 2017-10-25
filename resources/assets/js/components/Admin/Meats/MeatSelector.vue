<template>
    <basic-select :options="meatOptions"
                  :selected-option="selectedMeat"
                  placeholder="Select Meat..."
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
            'selectedMeatId',
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
            ...mapActions('meats', [
                'loadMeats'
            ]),
            onSelect(meat) {
                this.selectedMeatId = meat.value;

                if (! this.autonomous) {
                    return this.$emit('select', meat);
                }

                let vm = this;
                swal({
                    title: 'Are you sure?',
                    text: "Changing the meat will affect all ... using this ...",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then(function () {
                    axios.post('/admin/api/'+ vm.modelApi + '/' + vm.model.id + '/updateMeat',
                        { meat_id: meat.value }
                    )
                        .then(response => {
                            swal('Updated', 'The meat has been updated.', 'success');
                        })
                        .catch(error => {
                            swal('Failed...', 'The meat could not be updated...', 'error');
                        });
                }, function(dismiss) {
                    swal('You did not approve... ');
                });
            }
        },
        computed: {
            ...mapState('meats', [
                'collection',
            ]),
            meatOptions() {
                let arr = this.collection.map(model => {
                    return { value: model.id, text: model.label + ' (' + model.id + ')' };
                });
                arr.unshift({value: 0, text: 'None'});
                return arr;
            },
            selectedMeat() {
                let vm = this;
                return this.meatOptions.filter(meat => {
                    return meat.value === vm.selectedMeatId;
                })[0];
            }
        }
    }
</script>

<style>

</style>