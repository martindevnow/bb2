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
            <tr v-for="purchaseOrder in filteredData(purchaseOrders)">
                <td>{{ purchaseOrder.id }}</td>
                <td>{{ purchaseOrder.created_at }}</td>
                <td>{{ getVendorName(purchaseOrder) }}</td>
                <td>{{ purchaseOrder.total_cost }}</td>
                <td>{{ purchaseOrder.deliver_by }}</td>
                <td>
                    <button @click="openPaymentModal(purchaseOrder)"
                            class="btn btn-xs"
                            :class="{
                            'btn-danger': ! purchaseOrder.paid,
                            'btn-success': purchaseOrder.paid
                        }"
                    >
                        Paid
                    </button>
                    <button @click="openPackedModal(purchaseOrder)"
                            class="btn btn-xs"
                            :class="{
                            'btn-danger': ! purchaseOrder.packed,
                            'btn-success': purchaseOrder.packed
                        }"
                    >
                        Packed
                    </button>
                    <button @click="openShippedModal(purchaseOrder)"
                            class="btn btn-xs"
                            :class="{
                            'btn-danger': ! purchaseOrder.shipped,
                            'btn-success': purchaseOrder.shipped
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
        ...mapActions([
            'openPaymentModal',
            'closePaymentModal',
            'openPackedModal',
            'closePackedModal',
            'openShippedModal',
            'closeShippedModal',
            'loadPurchaseOrders',
            'loadPackages',
        ]),
        getVendorName(purchaseOrder) {
            return purchaseOrder.vendor ? purchaseOrder.vendor.name : '';
        }
    },
    computed: {
        ...mapState(['purchaseOrders', 'show'])
    },


}
</script>

<style>

</style>