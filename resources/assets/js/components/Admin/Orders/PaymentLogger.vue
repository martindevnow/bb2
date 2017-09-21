<template>
    <div>
        Method: <input id="swal-method" class="swal2-input" v-model="format">
        Amount: <input id="swal-amount" class="swal2-input" v-model="amount_paid">
        Date: <input id="swal-date" class="swal2-input" v-model="received_at">
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
        };
    },
    methods: {

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