<template>
    <basic-select :options="userOptions"
                  :selected-option="selectedUser"
                  placeholder="Select User..."
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
            'selectedUserId',
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
            this.selectedId = this.selectedUserId;
        },
        methods: {
            ...mapActions('users', [
                'loadUsers'
            ]),
            onSelect(user) {
                this.selectedId = user.value;
                if (this.selectedId === this.selectedUserId) {
                    return null;
                }

                if (! this.autonomous) {
                    return this.$emit('select', user);
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
                    axios.post('/admin/api/'+ vm.modelApi + '/' + vm.model.id + '/updateUser',
                        { user_id: user.value }
                    )
                        .then(response => {
                            swal('Updated', 'The user has been updated.', 'success');
                        })
                        .catch(error => {
                            swal('Failed...', 'The user could not be updated...', 'error');
                        });
                }, function(dismiss) {
                    swal('You did not approve... ');
                });
            }
        },
        computed: {
            ...mapState('users', [
                'collection',
            ]),
            userOptions() {
                return this.collection.map(model => {
                    return { value: model.id, text: model.label + ' (' + model.id + ')' };
                });
            },
            selectedUser() {
                let vm = this;
                return this.userOptions.filter(user => {
                    return user.value === vm.selectedId;
                })[0];
            }
        }
    }
</script>

<style>

</style>