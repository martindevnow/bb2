<template>
    <div>
        Method: <input id="swal-method" v-model="format"><br />
        Amount: <input id="swal-amount" v-model="amount_paid"><br />
        Date:   <input id="swal-date"   v-model="received_at">
    </div>
</template>

<script>
export default {
    props: ['order_id'],
    data() {
        return {
            amount_paid: 0,
            received_at: null,
            format: null,
            order: null,
        };
    },
    methods: {
        alertMe() {
            alert('Alerted!!!');
        },
        markAsPaid(order) {
            if (order.paid) {
                return null;
            }

            let vm = this;

            axios.post('/admin/api/orders/'+ order_id +'/paid', {
                format: this.format,
                amount_paid: this.amount_paid,
                received_at: this.received_at,
            })
                .then(response => {
                    order.paid = 1;
                    return resolve(response);
                })
                .catch(error => {
                    console.log(error.response);
                    let errorMessage = '';
                    for (let propertyName in error.response.data.errors) {
                        errorMessage = errorMessage + ' ' + error.response.data.errors[propertyName];
                    }
                    return reject(errorMessage);
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

</style>