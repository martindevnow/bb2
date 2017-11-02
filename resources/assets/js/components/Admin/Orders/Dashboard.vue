<template>
    <div>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th v-bind:colspan="numColumns + 1">
                    <div class="input-group">
                        <input type="text"
                               class="form-control"
                               v-model="sortable.filterKey"
                        />
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </th>
            </tr>
            <tr>
                <th v-for="key in columns"
                    @click="sortBy(key)"
                    :class="{ active: sortable.sortKey == key }">
                    {{ key | capitalize }}
                    <span class="fa" :class="sortOrders[key] > 0 ? 'fa-sort-asc' : 'fa-sort-desc'">
                  </span>
                </th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="order in filteredData(collection)" :key="order.id">
                <td>{{ order.pet_breed_customer }}</td>
                <td>{{ order.meal_size }}</td>
                <td>
                    {{ order.plan.package.label }}
                </td>
                <td>{{ order.plan.weeks_of_food_per_shipment }}</td>
                <td>{{ order.deliver_by }}</td>
                <td>

                    <button @click="openPaymentModal(order)"
                            class="btn btn-xs"
                            :class="{
                            'btn-danger': ! order.paid,
                            'btn-success': order.paid
                        }"
                    >
                        Paid
                    </button>
                    <button @click="openPackedModal(order)"
                            class="btn btn-xs"
                            :class="{
                            'btn-danger': ! order.packed,
                            'btn-success': order.packed
                        }"
                    >
                        Packed
                    </button>
                    <button @click="openShippedModal(order)"
                            class="btn btn-xs"
                            :class="{
                            'btn-danger': ! order.shipped,
                            'btn-success': order.shipped
                        }"
                    >
                        Shipped
                    </button>
                    <button @click="openCancellationModal(order)"
                            class="btn btn-xs btn-danger"

                    >
                        Cancel
                    </button>
                </td>
            </tr>
            </tbody>
        </table>


        <admin-common-modal v-if="show.paymentModal">
            <p slot="header">Log a Payment</p>
            <admin-payment-logger @saved="closePaymentModal()"
                                  @cancelled="closePaymentModal()"
                                  slot="body"
            ></admin-payment-logger>
        </admin-common-modal>

        <admin-common-modal v-if="show.packedModal">
            <p slot="header">Log Packing an Order</p>
            <admin-packed-logger @saved="closePackedModal()"
                                 @cancelled="closePackedModal()"
                                 slot="body"
            ></admin-packed-logger>
        </admin-common-modal>

        <admin-common-modal v-if="show.shippedModal">
            <p slot="header">Log a Shipment</p>
            <admin-shipped-logger @saved="closeShippedModal()"
                                  @cancelled="closeShippedModal()"
                                  slot="body"
            ></admin-shipped-logger>
        </admin-common-modal>

        <admin-common-modal v-if="show.cancellationModal">
            <p slot="header">Cancel an Order</p>
            <p slot="body">Reason:</p>
            <admin-orders-canceller @saved="closeCancellationModal()"
                                   @cancelled="closeCancellationModal()"
                                   slot="body"
            ></admin-orders-canceller>
        </admin-common-modal>
    </div>
</template>


<script>
import { mapGetters, mapState, mapActions } from 'vuex';
import isSortable from '../../../mixins/isSortable';

export default {
    mixins: [
        isSortable
    ],
    data() {
        let columns = [
            'pet_breed_customer',
            'meal_size',
            'package_label',
            '# of Weeks',
            'deliver_by',
        ];
        let numColumns = columns.length;
        let sortOrders = {};
        columns.forEach(function(key) {
            sortOrders[key] = 1;
        });

        return {
            columns: columns,
            numColumns: numColumns,
            sortOrders: sortOrders
        }
    },
    mounted() {
        this.loadOrders();
        this.loadPackages();
    },
    methods: {
        ...mapActions('orders', [
            'openPaymentModal',
            'closePaymentModal',
            'openPackedModal',
            'closePackedModal',
            'openShippedModal',
            'closeShippedModal',
            'openCancellationModal',
            'closeCancellationModal',
            'loadOrders',
        ]),
        ...mapActions('packages', [
            'loadPackages',
        ]),
        mealSize(order) {
            return (order.plan.pet_weight * order.plan.pet_activity_level / 2 * 454 / 100).toFixed(0);
        },
        onSelect(val) {
            console.log('selected package...');
            console.log(val);
        }
    },
    computed: {
        ...mapState('orders', [
            'collection',
            'show',
            'selected'
        ])
    },


}
</script>

<style>

</style>