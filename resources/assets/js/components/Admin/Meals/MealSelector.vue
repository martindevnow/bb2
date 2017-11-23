<template>
    <div :class="{ 'input-group' : deletable }">
        <basic-select :options="options"
                      :selected-option="selectedItem"
                      @select="$emit('input', $event)"
                      :isError="hasError"
        >
        </basic-select>
        <div class="input-group-btn" v-if="deletable">
            <button class="btn btn-danger"
                    type="button"
                    @click="$emit('delete')"
            >
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

</template>

<script>
    import { BasicSelect } from 'vue-search-select';
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';
    import * as actions from '../../../vuex/modules/meats/actionTypes';
    import * as mutations from '../../../vuex/modules/meats/mutationTypes';

    export default {
        props: [
            'value',
            'hasError',
            'deletable'
        ],
        components: {
            BasicSelect
        },
        data() {
            return {};
        },
        mounted() {
            this.$store.dispatch('meals/' + actions.FETCH_ALL);
        },
        methods: {
            getText(item) {
                return item.label + ' (' + item.id + ')';
            }
        },
        computed: {
            ...mapState('meals', [
                'collection',
            ]),
            options() {
                let vm = this;
                let arr = this.collection.map(item => {
                    return {
                        ...item,
                        text: vm.getText(item),
                    };
                });
                return arr;
            },
            selectedItem() {
                if ( ! this.value.id) {
                    return { text: 'Select ...' };
                }

                return {
                    ...this.value,
                    text: this.getText(this.value),
                };
            }
        },
    }
</script>

<style>

</style>