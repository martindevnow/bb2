<template>
    <admin-notes-creator @close="$emit('close')"
                         @saved="cancelOrder()"
    >
    </admin-notes-creator>
</template>

<script>
    import { mapState, mapActions, mapMutations, mapGetters } from 'vuex';

    export default {
        data() {
            return {};
        },
        methods: {
            ...mapMutations('orders', [
                'updateSelectedOrder'
            ]),
            cancelOrder() {
                let vm = this;

                axios.post('/admin/api/orders/' + vm.selected.id + '/cancel')
                    .then(response => {
                        vm.updateSelectedOrder({cancelled: true});
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