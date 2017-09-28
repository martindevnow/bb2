<template>
    <div>
        <div class="row">
            <div class="col-sm-4">
                <span class="label">Amount Paid</span>
            </div>
            <div class="col-sm-8">
                <label class="input">
                    <input type="text" class="input-sm"
                           v-model="amount_paid"
                    >
                </label>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-4">
                <span class="label">Date Received</span>
            </div>
            <div class="col-sm-8">
                <input type="text" class="input-sm"
                       v-model="received_at"
                >
            </div>
        </div>


        <div class="row">
            <div class="col-sm-4">
                <span class="label">Format</span>
            </div>
            <div class="col-sm-8">
                <select v-model="format">
                    <option v-for="format in paymentFormats">{{ format }}</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <button class="btn btn-primary"
                        @click="save()"
                >
                    Save
                </button>
                <button class="btn btn-default"
                        @click="$emit('close')"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import eventBus from '../../../events/eventBus';

export default {
    props: ['order_id'],
    data() {
        return {
            amount_paid: 0,
            received_at: null,
            format: null,
            order: null,
            paymentFormats: [
                'cash',
                'interac',
                'e-transfer',
                'stripe',
                'paypal',
            ],
        };
    },
    methods: {
        save() {
            let vm = this;

            return axios.post('/admin/api/orders/'+ vm.order_id +'/paid', {
                format:      this.format,
                amount_paid: this.amount_paid,
                received_at: this.received_at,
            }).then(response => {
                vm.$store.commit('setSelectedOrder', { paid: true });
            });

        },
    },
    computed: mapState(['show', 'selected']),
    mounted() {
        this.amount_paid = 0;
        this.format = 'cash';
        this.received_at = '2017-09-01';
    }
}
</script>

<style>
span.label {
    color: black;
}
</style>