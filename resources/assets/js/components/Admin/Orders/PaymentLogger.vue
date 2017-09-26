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
    </div>
</template>

<script>
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
        processForm() {
            let vm = this;

            axios.post('/admin/api/orders/'+ vm.order_id +'/paid', {
                format:      this.format,
                amount_paid: this.amount_paid,
                received_at: this.received_at,
            })
                .then(response => {
                    console.log('success....');
                    eventBus.$emit('order-marked-as-paid', { order_id: vm.order_id });
                    eventBus.$emit('close-modal', {model_type: 'order', model_id: vm.order_id});
                })
                .catch(error => {
                    console.log('error.response', error.response);
                    let errorMessage = '';
                    for (let propertyName in error.response.data.errors) {
                        errorMessage = errorMessage + ' ' + error.response.data.errors[propertyName];
                    }
                });
        },
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