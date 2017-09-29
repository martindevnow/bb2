<template>
    <div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="amount_paid">Amount Paid</label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text"
                               class="form-control"
                               placeholder="10"
                               id="amount_paid"
                               v-model="amount_paid"
                        >
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="received_at">Received At</label>
                    <input type="text"
                           class="form-control"
                           id="received_at"
                           v-model="received_at"
                    >
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="format">Format</label>
                    <select v-model="format"
                            class="form-control"
                            id="format"
                    >
                        <option v-for="format in paymentFormats">{{ format }}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-6">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary btn-block"
                                @click="save()"
                        >
                            Save
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <label>&nbsp;</label>
                        <button class="btn btn-default btn-block"
                                @click="closePaymentModal()"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">


            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import eventBus from '../../../events/eventBus';

export default {
    data() {
        return {
            amount_paid: 0,
            received_at: null,
            format: '',
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
        ...mapActions([
            'closePaymentModal',
        ]),
        save() {
            let vm = this;


            return axios.post('/admin/api/orders/'+ this.$store.state.selected.order.id +'/paid', {
                format:      this.format,
                amount_paid: this.amount_paid,
                received_at: this.received_at,
            }).then(response => {
                vm.$store.commit('updateSelectedOrder', { paid: true });
                vm.$store.dispatch('closePaymentModal');
            }).catch(error => {
                console.log('error', error);
            });
        },
    },
    computed: {
        ...mapState([
            'show',
            'selected'
        ]),
    },
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