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
    import * as petsActions from "../../../vuex/modules/pets/actionTypes";

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
            this.$store.dispatch('pets/' + petsActions.FETCH_ALL);
        },
        methods: {
            getText(item) {
                return item.name + ' (' + (item.owner ? item.owner.name : '') + ')';
            }
        },
        computed: {
            ...mapState('pets', [
                'collection',
            ]),
            options() {
                let vm = this;
                return this.collection.map(item => {
                    return {
                        ...item,
                        text: vm.getText(item),
                    };
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