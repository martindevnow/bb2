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
        props: ['model', 'selectedPackageId'],
        components: {
            BasicSelect,
        },
        data() {
            return {
                selectedId: null,
            };
        },
        mounted() {
            this.loadPackages();
            this.selectedId = this.selectedPackageId;
        },
        methods: {
            ...mapActions('packages', [
                'loadPackages'
            ]),
            onSelect(pkg) {
                this.selectedId = pkg.value;
                return this.$emit('select', pkg);
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