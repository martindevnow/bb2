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
        props: ['model'],
        components: {
            BasicSelect,
        },
        data() {
            return {
                selectedPackage: {
                    text: '',
                    value: ''
                },
            };
        },
        methods: {
            onSelect()
        },
        computed: {
            ...mapState('packages', [
                'collection',
            ]),
            packageOptions() {
                return this.collection.map(model => {
                    return { value: model.id, text: model.name + ' (' + model.id + ')' };
                });
            }

        }

    }
</script>

<style>

</style>