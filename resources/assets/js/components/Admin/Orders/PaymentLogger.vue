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
                    <label>Received At</label>
                    <datepicker v-model="received_at"
                                id="received_at"
                                format="yyyy-MM-dd"
                                input-class="form-control"
                    >
                    </datepicker>
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
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import eventBus from '../../../events/eventBus';
import Datepicker from 'vuejs-datepicker';
import moment from 'moment';

export default {
    components: {
        Datepicker,
    },
    data() {
        return {
            amount_paid: null,
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
                received_at: moment(this.received_at).format('YYYY-MM-DD'),
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
        this.format = 'cash';
        this.received_at = new Date();
        this.amount_paid = this.selected.order.plan.weekly_cost;
    }
}
</script>

<style>
span.label {
    color: black;
}
</style>