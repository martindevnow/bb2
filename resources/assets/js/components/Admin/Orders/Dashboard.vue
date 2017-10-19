<template>
    <div>
        New Package


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
                    <admin-package-selector @select="onSelect"
                                            :selected-package-id="order.plan.package_id"
                                            :autonomous="1"
                                            model-api="plans"
                                            :model="order.plan"
                    ></admin-package-selector>
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
                </td>
            </tr>
            </tbody>
        </table>


        <admin-common-modal v-if="show.paymentModal"
                             @close="closePaymentModal()"
        >
            <p slot="header">Log a Payment</p>
            <admin-payment-logger @close="$emit('close')"
                                  slot="body"
            ></admin-payment-logger>
        </admin-common-modal>

        <admin-common-modal v-if="show.packedModal"
                            @close="closePackedModal()"
        >
            <p slot="header">Log Packing an Order</p>
            <admin-packed-logger @close="$emit('close')"
                                 slot="body"
            ></admin-packed-logger>
        </admin-common-modal>

        <admin-common-modal v-if="show.shippedModal"
                            @close="closeShippedModal()"
        >
            <p slot="header">Log a Shipment</p>
            <admin-shipped-logger @close="$emit('close')"
                                  slot="body"
            ></admin-shipped-logger>
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