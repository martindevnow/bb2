<template>
    <div>

    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import { mapGetters, mapState, mapActions } from 'vuex';
    import isSortable from '../../../mixins/isSortable';
    export default {
        mixins: [
            isSortable
        ],
        data() {
            let columns = [
                'id',
                'customer_name',
                'pet_name',
                'package_label',
                'weeks_of_food',
                'weeks_per_shipment',
                'cost',
            ];
            let numColumns = columns.length;
            let sortOrders = {};
            columns.forEach(function(key) {
                sortOrders[key] = 1;
            });

            return {
                columns: columns,
                numColumns: numColumns,
                sortOrders: sortOrders,
                plansToOrder: [],
                meatsToOrder: [],
            }
        },
        mounted() {
            this.loadPlans();
            this.loadPackages();
            this.loadMeals();
        },
        methods: {
            ...mapActions('plans', [
                'openPlanCreatorModal',
                'closePlanCreatorModal',
                'loadPlans',
                'editPlan',
            ]),
            ...mapActions('packages', [
                'loadPackages',
            ]),
        },
        computed: {
            ...mapState('plans', [
                'collection',
                'show',
                'selected',
                'mode',
            ])
        },
    }
</script>

<style>

</style>