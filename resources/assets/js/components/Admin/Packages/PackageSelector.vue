<template>
    <basic-select :options="packageOptions"
                  :selected-option="selectedPackage"
                  placeholder="Select Package..."
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
            'selectedPackageId',
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
//            this.loadPackages();
            this.selectedId = this.selectedPackageId;
        },
        methods: {
            ...mapActions('packages', [
                'loadPackages'
            ]),
            onSelect(pkg) {
                this.selectedId = pkg.value;
                if (! this.autonomous) {
                    return this.$emit('select', pkg);
                }
                console.log('this is autonomous....');
                let vm = this;
                axios.post('/admin/api/'+ this.modelApi + '/' + this.model.id + '/updatePackage', { package_id: pkg.id })
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error);
                    })

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