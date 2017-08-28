<template>
    <div>
        <div class="row">
            <div class="col-md-9">
                <div class="card mb-1">
                    <table class="table table-responsive table-no-border vertical-center">
                        <tbody><tr>
                            <td class="hidden-xs">
                                <img src="/barfbento/img/basic.jpg" alt=""
                                     height="100px"
                                     class="img"> </td>
                            <td>
                                <h4 class="">Basic Bento</h4>
                            </td>
                            <td>
                                <h4>Halley (50lb)</h4>
                            </td>
                            <td>
                                <h5>Weekly Shipping</h5>
                            </td>
                            <td>
                                <span class="color-success">$61.99 / week</span>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-success">
                    <div class="card-header">
                        <i class="fa fa-list-alt" aria-hidden="true"></i> Plan</div>
                    <div class="card-block">
                        <ul class="list-unstyled">
                            <li>
                                <strong>Price: </strong> $1984.26</li>
                            <li>
                                <strong>Tax: </strong> $47.22</li>
                            <li>
                                <strong>Tax: </strong> $47.22</li>
                            <li>
                                <strong>Shipping costs: </strong>
                                <span class="color-warning">$5.25</span>
                            </li>
                        </ul>
                        <h3>
                            <strong>Total:</strong>
                            <span class="color-success">$2456.45</span>
                        </h3>
                        <a href="javascript:void(0)" class="btn btn-raised btn-success btn-block btn-raised mt-2 no-mb">
                            <i class="zmdi zmdi-shopping-cart-plus"></i> Purchase</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert2'
export default {
    props: ['hash'],
    data() {
        return {
            formData: {
                stripeEmail: '',
                stripeToken: '',
                cartHash: '',
            },
        };
    },
    methods: {
        getCart() {
            let vm = this;
            axios.get('/api/cart')
        }
    },
    mounted() {
        let vm = this;
        this.stripe = StripeCheckout.configure({
            key: BarfBento.stripeKey,
            image: "https://stripe.com/img/documentation/checkout/marketplace.png",
            locale: "auto",
            panelLabel: "Subscribe For",
            token: function(token) {
                vm.formData.stripeToken = token.id;
                vm.formData.stripeEmail = token.email;
                vm.formData.cartHash = vm.hash;
                vm.formData.shipping_modifier = vm.shipping_modifier;
                axios.post('/plans/subscribe', vm.formData)
                    .then(function(response) { alert('Complete! Thanks for your payment!'); })
                    .catch(function(response) {console.log({'response': response});});
            }
        });
    }
}
</script>

<style>

</style>