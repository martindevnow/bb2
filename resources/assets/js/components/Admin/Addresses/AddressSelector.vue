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
    import * as actions from './../../../vuex/modules/addresses/actionTypes';
    import * as mutations from './../../../vuex/modules/addresses/mutationTypes';

    export default {
        props: [
            'value',
            'hasError',
            'deletable',
            'userId',
        ],
        components: {
            BasicSelect
        },
        data() {
            return {};
        },
        mounted() {
            this.fetchAll();
        },
        methods: {
            fetchAll() {
                this.$store.dispatch('addresses/' + actions.FETCH_ALL);
            },
            getText(item) {
                return item.name + ' (' + item.street_1 + ' ' + item.city + ')';
            }
        },
        computed: {
            ...mapState('addresses', [
                'collection',
            ]),
            options() {
                let vm = this;
                return  this.collection.map(item => {
                    return {
                        ...item,
                        text: vm.getText(item),
                    };
                }).filter(item => {
                    return item.addressable_id == vm.userId
                        && item.addressable_type == 'Martin\\ACL\\User';
                });
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