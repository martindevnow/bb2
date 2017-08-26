<template>
    <div>
        <div class="overlay" v-show="loading">
            <div id="loading-img"></div>
        </div>
        <form v-show="showForm">

            <h3>Existing User</h3>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email"
                       v-model="email"
                       class="form-control"
                       id="email"
                >
            </div>

            <div class="form-group">
                <label for="email">Password:</label>
                <input type="password"
                       v-model="password"
                       class="form-control"
                       id="password"
                >
            </div>

            <button @click.prevent="login()"
                    type="submit"
                    class="btn btn-block btn-primary"
            >
                Login
            </button>


        </form>
        <form v-show="! showForm">
            <div class="form-group">
                <label for="users_email_address">Continue as...:</label>
                <input type="email"
                       class="form-control"
                       id="users_email_address"
                       v-model="email"
                       disabled
                >
            </div>
        </form>

    </div>
</template>

<script>
import eventBus from '../../events/eventBus';
import swal from 'sweetalert2'

export default {
    props: ['hash'],
    data() {
        return {
            user: {},
            loading: false,
            name: "",
            email: "",
            password: "",
            showForm: true,
        }
    },
    methods: {
        loadUser(user) {
            this.user = user;
            this.showForm = false;
        },
        login() {
            this.loading = true;
            let vm = this;
            axios.post('/api/login', {email: this.email, password: this.password})
                .then(function(response) {
                    eventBus.$emit('user-logged-in', response.data.user);
                    console.log('Login was successful');
                    window.location = ('/quote/details/' + vm.hash);
                })
                .catch(function(error) {
                    console.log(error);
                    swal('there was an error....');
                });
            this.loading = false;
        },
    },
    mounted() {
        console.log('loginForm MOUNTED');
    },
    created() {
        eventBus.$on('user-logged-in', this.loadUser);
        console.log('loginForm CREATED');
    },
    beforeDestroy() {
        eventBus.$off('user-logged-in', this.loadUser);
    }
}
</script>

<style>
    #loading-img {
        background: url(http://preloaders.net/preloaders/360/Velocity.gif) center center no-repeat;
        height: 100%;
        z-index: 20;
    }

    .overlay {
        background: #e9e9e9;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        opacity: 0.5;
    }
</style>
