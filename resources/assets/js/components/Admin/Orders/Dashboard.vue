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
                    @click="markAsPacked(order)"
                >Paid</button>
                <button class="btn btn-xs">Packed</button>
                <button class="btn btn-xs">Picked</button>
                <button class="btn btn-xs">Shipped</button>
                <button class="btn btn-xs">Delivered</button>
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
            axios.get('/api/orders')
                .then(response => vm.orders = response.data)
                .catch(error => vm.errors = error);
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
                        // TODO: Add the ajax request here...

                        console.log(' you packed ' + weeks + ' weeks of food');
                        resolve();
                    })
                },
                allowOutsideClick: false
            }).then(function (weeks) {
                swal({
                    type: 'success',
                    title: 'Packed',
                    html: 'Thank you for packing ' + weeks + ' weeks of food'
                })
            })
        }
    },
    computed: {
    }

}
</script>

<style>

</style>