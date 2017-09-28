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
            <div class="col-xs-4">{{ order.customer }} ({{ order.pet }})</div>
            <div class="col-xs-4">{{ order.weeks_at_a_time }}</div>
            <div class="col-xs-3">{{ order.plan}}</div>
            <div class="col-xs-1">
                <button @click="openPaymentModal(order)">Paid</button>
            </div>
        </div>

        <admin-payment-modal v-if="show.paymentModal"
                             @close="closePaymentModal"
        ></admin-payment-modal>
    </div>
</template>

<script>
import swal from 'sweetalert2';
import eventBus from '../../../events/eventBus';
import {mapGetters, mapState} from 'vuex';
export default {
    data() {
        return {};
    },
    mounted() {
    },
    methods: {
        openPaymentModal(order) {
            this.$store.dispatch('openPaymentModal', { order });
        },
        closePaymentModal() {
            this.$store.dispatch('closePaymentModal');
        }
    },
    computed: mapState(['orders', 'show']),


}
</script>

<style>

</style>