<template>
    <div>

        <div class="row">
            <div class="col-xs-2">Pet (Breed) - Customer</div>
            <div class="col-xs-1">Meal Size</div>
            <div class="col-xs-2">Package</div>
            <div class="col-xs-1"># of Weeks</div>
            <div class="col-xs-6">Actions</div>
        </div>


        <div class="row" v-for="order in orders">
            <div class="col-xs-4">{{ order.customer.name }} ({{ order.plan.pet.name }})</div>
            <div class="col-xs-2">{{ order.plan.weeks_at_a_time }}</div>
            <div class="col-xs-3">{{ order.plan.package.label }}</div>
            <div class="col-xs-3">
                <button @click="openPaymentModal(order)"
                        class="btn"
                        :class="{
                            'btn-danger': ! order.paid,
                            'btn-success': order.paid
                        }"
                >
                    Paid
                </button>
                <button @click="openPackedModal(order)"
                        class="btn"
                        :class="{
                            'btn-danger': ! order.packed,
                            'btn-success': order.packed
                        }"
                >
                    Packed
                </button>
                <button @click="openShippedModal(order)"
                        class="btn"
                        :class="{
                            'btn-danger': ! order.shipped,
                            'btn-success': order.shipped
                        }"
                >
                    Shipped
                </button>
            </div>
        </div>

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
export default {
    data() {
        return {};
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