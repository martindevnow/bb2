<template>
    <div class="input-group">
        <model-select :options="options"
                      @input="$emit('input', $event)"
                      v-model="topping"
                      :isError="hasError"
        >
        </model-select>
        <div class="input-group-btn">
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
    import { ModelSelect } from 'vue-search-select';
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';

    export default {
        props: ['value', 'hasError'],
        components: {
            ModelSelect,
        },
        data() {
            return {topping: {}};
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
                        value: item.id,
                        text: item.label + ' (' + item.id + ')',
                    };
                });
                arr.unshift({
                    value: 0,
                    text: "None",
                });
                return arr;
            }
        }
    }
</script>

<style>

</style>