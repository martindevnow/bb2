<template>
    <admin-notes-creator @cancelled="$emit('cancelled')"
                         @saved="cancelOrder()"
    >
    </admin-notes-creator>
</template>

<script>
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';
    import * as orderMutations from "../../../vuex/modules/orders/mutationTypes";

    export default {
        data() {
            return {};
        },
        methods: {
            cancelOrder() {
                let vm = this;

                axios.post('/admin/api/orders/' + vm.selected.id + '/cancel')
                    .then(response => {
                        vm.$store.commit('orders/' + orderMutations.UPDATE_IN_COLLECTION, {cancelled: true});
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