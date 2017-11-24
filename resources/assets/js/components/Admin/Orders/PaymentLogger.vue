<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     v-bind:class="{'has-error': errors.has('amount_paid') }"
                >
                    <label for="amount_paid">Amount Paid</label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text"
                               class="form-control"
                               placeholder="10"
                               id="amount_paid"
                               name="amount_paid"
                               v-model="amount_paid"
                        >
                    </div>
                    <span class="help-block">{{ errors.get('amount_paid') }}</span>

                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group"
                     v-bind:class="{'has-error': errors.has('received_at') }"
                >
                    <label>Received At</label>
                    <datepicker v-model="received_at"
                                id="received_at"
                                name="received_at"
                                format="yyyy-MM-dd"
                                input-class="form-control"
                    >
                    </datepicker>
                    <span class="help-block">{{ errors.get('received_at') }}</span>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     v-bind:class="{'has-error': errors.has('format') }"
                >
                    <label for="format">Format</label>
                    <select v-model="format"
                            class="form-control"
                            id="format"
                            name="format"
                            @change="errors.clear('format')"
                    >
                        <option v-for="format in paymentFormats">{{ format }}</option>
                    </select>
                    <span class="help-block">{{ errors.get('format') }}</span>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-6">
                        <label>&nbsp;</label>
                        <button class="btn btn-success btn-block"
                                :disabled="errors.any()"
                                @click="save()"
                        >
                            Save
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <label>&nbsp;</label>
                        <button class="btn btn-default btn-block"
                                @click="$emit('cancelled')"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex';
import Datepicker from 'vuejs-datepicker';
import moment from 'moment';
import hasErrors from '../../../mixins/hasErrors';
import * as orderMutations from "../../../vuex/modules/orders/mutationTypes";

export default {
    mixins: [
        hasErrors
    ],
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
                'e-transfer',
                'stripe',
                'paypal',
                'interac',
            ],
        };
    },
    methods: {
        ...mapMutations('orders', [
            'updateSelectedOrder'
        ]),
        save() {
            let vm = this;

            return axios.post('/admin/api/orders/' + this.selected.id + '/paid', {
                format:      this.format,
                amount_paid: this.amount_paid,
                received_at: moment(this.received_at).format('YYYY-MM-DD'),
            }).then(response => {
                vm.$store.commit('orders/' + orderMutations.UPDATE_IN_COLLECTION, { paid: true });
                vm.$emit('saved');
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
    },
    computed: {
        ...mapState('orders', [
            'selected'
        ]),
    },
    mounted() {
        this.format = this.selected.plan.payment_method;
        this.received_at = new Date();
        this.amount_paid = this.selected.plan.weekly_cost;
    }
}
</script>

<style>

</style>