<template>
    <div :class="{ 'input-group' : deletable }">
        <basic-select :options="options"
                      :selected-option="value"
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

    export default {
        props: ['value', 'hasError', 'deletable'],
        components: {
            BasicSelect
        },
        data() {
            return {};
        },
        mounted() {
            this.loadToppings();
        },
        methods: {
            ...mapActions('toppings', [
                'loadToppings',
            ]),
        },
        computed: {
            ...mapState('toppings', [
                'collection',
            ]),
            options() {
                let arr = this.collection.map(item => {
                    return {
                        ...item,
                        text: item.label + ' (' + item.id + ')',
                    };
                });
                arr.unshift({
                    id: 0,
                    text: "None",
                });
                return arr;
            }
        }
    }
</script>

<style>

</style>