<template>
    <basic-select :options="petOptions"
                  :selected-option="selectedPet"
                  placeholder="Select Pet..."
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
            'selectedPetId',
            'autonomous',
            'hasError',
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
            this.selectedId = this.selectedPetId;
        },
        methods: {
            ...mapActions('pets', [
                'loadPets'
            ]),
            onSelect(pet) {
                this.selectedId = pet.value;
                if (this.selectedId === this.selectedPetId) {
                    return null;
                }

                if (! this.autonomous) {
                    return this.$emit('select', pet);
                }

                let vm = this;
                swal({
                    title: 'Are you sure?',
                    text: "Changing the plan will affect all open orders...",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then(function () {
                    axios.post('/admin/api/'+ vm.modelApi + '/' + vm.model.id + '/updatePet',
                        { pet_id: pet.value }
                    )
                        .then(response => {
                            swal('Updated', 'The pet has been updated.', 'success');
                        })
                        .catch(error => {
                            swal('Failed...', 'The pet could not be updated...', 'error');
                        });
                }, function(dismiss) {
                    swal('You did not approve... ');
                });
            }
        },
        computed: {
            ...mapState('pets', [
                'collection',
            ]),
            petOptions() {
                return this.collection.map(model => {
                    return { value: model.id, text: model.label + ' (' + model.id + ')' };
                });
            },
            selectedPet() {
                let vm = this;
                return this.petOptions.filter(pet => {
                    return pet.value === vm.selectedId;
                })[0];
            }
        }
    }
</script>

<style>

</style>