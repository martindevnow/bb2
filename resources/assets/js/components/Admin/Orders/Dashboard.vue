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
                    <span class="arrow" :class="sortOrders[key] > 0 ? 'fa-sort-asc' : 'fa-sort-desc'">
                  </span>
                </th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="order in filteredData(orders)">
                <td>{{ order.customer.name }} ({{ order.plan.pet.name }})</td>
                <td>{{ mealSize(order) }}</td>
                <td>{{ order.plan.package.label }}</td>
                <td>{{ order.plan.weeks_of_food_per_shipment }}</td>
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
            <admin-payment-logger @close="$emit('close')"
                                  slot="body"
            ></admin-payment-logger>
        </admin-common-modal>

        <admin-common-modal v-if="show.packedModal"
                            @close="closePackedModal()"
        >
            <admin-packed-logger @close="$emit('close')"
                                 slot="body"
            ></admin-packed-logger>
        </admin-common-modal>

        <admin-common-modal v-if="show.shippedModal"
                            @close="closeShippedModal()"
        >
            <admin-shipped-logger @close="$emit('close')"
                                  slot="body"
            ></admin-shipped-logger>
        </admin-common-modal>
    </div>
</template>

<script>
import swal from 'sweetalert2';
import eventBus from '../../../events/eventBus';
import { mapGetters, mapState, mapActions } from 'vuex';
import sortable from '../../../mixins/sortable';

export default {
    mixins: [sortable],
    data() {
        let columns = [
            'Pet (Breed) - Owner',
            'Meal Size',
            'Package',
            '# of Weeks',
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
            'loadOrders',
            'loadPackages',
        ]),
        mealSize(order) {
            return (order.plan.pet_weight * order.plan.pet_activity_level / 2 * 454 / 100).toFixed(0);
        }
    },
    computed: {
        ...mapState(['orders', 'show'])
    },


}
</script>

<style scoped>
.row {
    border-bottom: 1px solid black;
}
</style>