<template>
    <admin-notes-creator @cancelled="$emit('cancelled')"
                         @saved="cancelOrder()"
    >
    </admin-notes-creator>
</template>

<script>
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    import * as orderActions from "../../../vuex/modules/orders/actionTypes";

    export default {
        data() {
            return {};
        },
        methods: {
            cancelOrder() {
                let vm = this;

                this.$store.dispatch('orders/' + orderActions.SAVE_CANCELLED
                ).then(response => {
                    vm.$emit('saved');
                }).catch(error => {
                    vm.errors.record(error.response.data.errors);
                });
            }
        },
        computed: {
            ...mapState('orders', [
                'selected',
            ]),
        }
    }
</script>

<style>

</style>