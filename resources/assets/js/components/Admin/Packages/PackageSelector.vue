<template>
    <basic-select :options="packageOptions"
                  :selected-option="selectedPackage"
                  placeholder="Select Package..."
                  @select="onSelect"
    >
    </basic-select>
</template>

<script>
    import swal from 'sweetalert2'
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
            'selectedPackageId',
            'autonomous',
            'errorsObj'
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
//            this.loadPackages();
            this.selectedId = this.selectedPackageId;
            this.errors = this.errorsObj;
        },
        methods: {
            ...mapActions('packages', [
                'loadPackages'
            ]),
            onSelect(pkg) {
                this.selectedId = pkg.value;
                if (this.selectedId === this.selectedPackageId) {
                    return null;
                }

                if (! this.autonomous) {
                    return this.$emit('select', pkg);
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
                    axios.post('/admin/api/'+ vm.modelApi + '/' + vm.model.id + '/updatePackage',
                        { package_id: pkg.value }
                    )
                        .then(response => {
                            swal('Updated', 'The package has been updated.', 'success');
                        })
                        .catch(error => {
                            swal('Failed...', 'The package could not be updated...', 'error');
                        });
                }, function(dismiss) {
                    swal('You did not approve... ');
                });

            }
        },
        computed: {
            ...mapState('packages', [
                'collection',
            ]),
            packageOptions() {
                return this.collection.map(model => {
                    return { value: model.id, text: model.label + ' (' + model.id + ')' };
                });
            },
            selectedPackage() {
                let vm = this;
                return this.packageOptions.filter(pkg => {
                    return pkg.value === vm.selectedId;
                })[0];
            }

        }

    }
</script>

<style>

</style>