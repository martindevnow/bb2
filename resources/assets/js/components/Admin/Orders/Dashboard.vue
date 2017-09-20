<template>
    <div>
        <div class="row">
            <div class="col-sm-2">Date / Customer</div>
            <div class="col-sm-1">Meal Size</div>
            <div class="col-sm-2">Package</div>
            <div class="col-sm-1"># of Weeks</div>
            <div class="col-sm-6">Actions</div>
        </div>


        <div class="row" v-for="order in orders">
            <div class="col-sm-2">{{ order.deliver_by }} <br />{{ order.plan.pet.name }}</div>
            <div class="col-sm-1">{{ (order.plan.pet.weight * .02 / 2 * 454).toFixed(2) }}g</div>
            <div class="col-sm-2">{{ order.plan.package.label }}</div>
            <div class="col-sm-1">{{ order.plan.weeks_at_a_time }}</div>
            <div class="col-sm-6">
                <button class="btn btn-xs"
                        @click="markAsPaid(order)"
                        :class="{ 'btn-danger': !order.paid, 'btn-success': order.paid}"
                >Paid</button>
                <button class="btn btn-xs"
                        @click="markAsPacked(order)"
                        :class="{ 'btn-danger': !order.packed, 'btn-success': order.packed}"
                >Packed</button>
                <button class="btn btn-xs"
                        @click="markAsPicked(order)"
                        :class="{ 'btn-danger': !order.picked, 'btn-success': order.picked}"
                >Picked</button>
                <button class="btn btn-xs"
                        :class="{ 'btn-danger': !order.shipped, 'btn-success': order.shipped}"
                >Shipped</button>
                <button class="btn btn-xs"
                        :class="{ 'btn-danger': !order.delivered, 'btn-success': order.delivered}"
                >Shipped</button>
            </div>
        </div>
    </div>
</template>

<script>
import swal from 'sweetalert2';

export default {
    data() {
        return {
            orders: [],
        };
    },
    mounted() {
        this.getOrders();
    },
    methods: {
        getOrders() {
            let vm = this;
            axios.get('/admin/api/orders')
                .then(response => vm.orders = response.data)
                .catch(error => vm.errors = error);
        },
        markAsPaid(order) {
            let vm = this;
            swal({
                title: 'Multiple inputs',
                html:
                'Method: <input id="swal-method" class="swal2-input" value="cash">' +
                'Amount: <input id="swal-amount" class="swal2-input" value="' + order.plan.weekly_cost + '">' +
                'Date: <input id="swal-date" class="swal2-input" value="today">',
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {

                        let format = $('#swal-method').val();
                        let amount_paid = $('#swal-amount').val();
                        let received_at = $('#swal-date').val();

                        axios.post('/admin/api/orders/'+ order.id +'/paid', {format, amount_paid, received_at})
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
                    })
                },
                onOpen: function () {
                    $('#swal-method').focus()
                }
            }).then(function (result) {
                console.log(result);
                swal('That order has been marked as paid.');
            }).catch(error => {
                swal('There was an error...');
            })
        },
        markAsPacked(order) {
            let vm = this;
            swal({
                title: 'How many weeks were packed?',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                showLoaderOnConfirm: true,
                preConfirm: function (weeks) {
                    return new Promise(function (resolve, reject) {
                        if (! weeks || weeks <= 0 || weeks == false) {
                            return reject('You must enter a positive number..');
                        }

                        axios.post('/admin/api/orders/' + order.id + '/packed', {weeks})
                            .then((response) => {
                                return resolve();
                            })
                            .catch((error) => {
                                return reject('There was an error.. Please try again.');
                            });
                    })
                },
                allowOutsideClick: false
            }).then(function (weeks) {
                order.packed = 1;
                swal({
                    type: 'success',
                    title: 'Packed',
                    html: 'Thank you for packing ' + weeks + ' weeks of food'
                })
            }).catch(function (weeks) {
                // Do nothing.. they just clicked the cancel button
            })
        },
        markAsPicked(order) {

        },
        markAsShipped(order) {

        },
        markAsDelivered(order) {

        },
    },
    computed: {
    }

}
</script>

<style>

</style>