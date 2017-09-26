<template>
    <div>
        <div class="row">
            <div class="col-sm-2">Pet (Breed) - Customer</div>
            <div class="col-sm-1">Meal Size</div>
            <div class="col-sm-2">Package</div>
            <div class="col-sm-1"># of Weeks</div>
            <div class="col-sm-6">Actions</div>
        </div>


        <div class="row" v-for="order in orders">
            <div class="col-sm-2">{{ order.plan.pet.name }} ({{ order.plan.pet.breed }}) {{ order.customer.name }}</div>
            <div class="col-sm-1">{{ (order.plan.pet.weight * .02 / 2 * 454).toFixed(2) }}g</div>
            <div class="col-sm-2">{{ order.plan.package.label }}</div>
            <div class="col-sm-1">{{ order.plan.weeks_at_a_time }}</div>
            <div class="col-sm-6">
                <button class="btn btn-xs"
                        @click="displayPaidModal(order)"
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
                        @click="markAsShipped(order)"
                        :class="{ 'btn-danger': !order.shipped, 'btn-success': order.shipped}"
                >Shipped</button>
                <button class="btn btn-xs"
                        @click="markAsDelivered(order)"
                        :class="{ 'btn-danger': !order.delivered, 'btn-success': order.delivered}"
                >Delivered</button>
            </div>
        </div>
        <admin-common-modal v-if="showPaidModal"
                            @close="showPaidModal = false"
                            model_type="order"
                            :model_id="order_id"
        >
            <div slot="title">Log a Payment</div>
            <admin-orders-payment-logger :order_id="order_id" slot="body"></admin-orders-payment-logger>
        </admin-common-modal>
        <admin-common-modal v-if="showPackedModal"
                            @close="showPackedModal = false"
                            model_type="order"
                            :model_id="order_id"
        >
            <div slot="title">How much was packed?</div>
            <admin-orders-packing-logger :order_id="order_id" slot="body"></admin-orders-packing-logger>
        </admin-common-modal>
    </div>
</template>

<script>
import swal from 'sweetalert2';
import eventBus from '../../../events/eventBus';

export default {
    data() {
        return {
            orders: [],
            showPaidModal: false,
            showPackedModal: false,
            showPickedModal: false,
            showShippedModal: false,
            showDeliveredModal: false,
            order_id: null,
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
        displayPaidModal(order) {
            this.order_id = order.id;
            this.showPaidModal = true;
        },
        markAsPaid(order) {
            if (order.paid) {
                return null;
            }

            let vm = this;
            swal({
                title: 'Payment Record',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                html:
                '<admin-orders-payment-logger :order_id="' + (order.id) + '"></admin-orders-payment-logger>',
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
                swal({
                    type: 'success',
                    title: 'Paid',
                    text: 'This payment has been recorded.',
                });
            }).catch(error => {
                // Do nothing.. modal was just closed...
            })
        },
        markAsPacked(order) {
            if (order.packed) {
                return null;
            }

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
            if (order.picked) {
                return null;
            }
            let vm = this;
            axios.post('/admin/api/orders/' + order.id + '/picked')
                .then(response => {
                    order.picked = 1;
                    swal({
                        type: 'success',
                        title: 'Picked',
                    });
                })
                .catch(error => {
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: error.data.message,
                    });
                });
        },
        markAsShipped(order) {
            if (order.shipped) {
                return null;
            }

            let vm = this;
            let today = new Date(Date.now()).toDateString();
            let options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            };

            let dateTime = Intl.DateTimeFormat('sr-RS', options);
            swal({
                title: 'Shipment Record',
                html:
                'Carrier/Courier: <input id="swal-carrier" class="swal2-input" value="cash">' +
                'Date: <input id="swal-date" class="swal2-input" value="' + dateTime.format(new Date()) + '">',
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {

                        let carrier = $('#swal-carrier').val();
                        let shipped_at = $('#swal-date').val();

                        axios.post('/admin/api/orders/'+ order.id +'/paid', {carrier, shipped_at})
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
                swal({
                    type: 'success',
                    title: 'Paid',
                    text: 'This payment has been recorded.',
                });
            }).catch(error => {
                // Do nothing... they just exited the modal.. that's all
            })
        },
        markAsDelivered(order) {

        },
        setOrderAsPaid(order_id) {
            this.order.map((order) => {
                if (order.id === order_id) {
                    order.paid = true;
                }
                return order;
            })
        },

    },
    computed: {
    },
    created() {
        eventBus.$on('order-marked-as-paid', this.setOrderAsPaid(order_id));
    },
    beforeDestroy() {
        eventBus.$off('order-marked-as-paid', this.setOrderAsPaid(order_id));
    }

}
</script>

<style>

</style>