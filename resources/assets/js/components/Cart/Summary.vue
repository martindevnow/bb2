<template>
    <div>
        <h1>In Your Cart</h1>
        <span>Bento: </span><span>{{ getSubscriptionPackage(cart.sub_package_id).label }}</span>
        <span>Shipping: </span><span>{{ shippingFrequency(cart.sub_shipping_modifier) }}</span>
        <span>Meal Cost:</span><span> ${{ servingCost.toFixed(2) }}</span>
    </div>
</template>

<script>
    import swal from 'sweetalert2';
    import Subscriptions, {Cart} from '../../mixins/Subscriptions';


export default {
    mixins: [Subscriptions],
    props: ['cart_hash', 'cart_data'],
    data() {
        return {
            cart: {},
        };
    },
    mounted() {
        this.cart = new Cart(this.cart_data);
    }
}
</script>

<style>

</style>