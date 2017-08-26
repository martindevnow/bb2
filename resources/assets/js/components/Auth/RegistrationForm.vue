<template>
    <div>
        <div class="overlay" v-show="loading">
            <div id="loading-img"></div>
        </div>
        <form v-show="showForm">

            <h3>New User</h3>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="name"
                       v-model="name"
                       class="form-control"
                       id="name"
                >
            </div>

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

            <button @click.prevent="register()"
                    type="submit"
                    class="btn btn-block btn-default"
            >
                Register
            </button>


        </form>
        <form v-show="! showForm">
            <div class="form-group">
                <label for="users_email_address">Logged in as:</label>
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
    data() {
        return {
            user: null,
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
        register() {
            this.loading = true;
            let vm = this;
            swal({
                title: 'Please Confirm',
                text: 'Please enter your password again to confirm',
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Register',

                input: 'password',
                inputAttributes: {
                    'maxlength': 16,
                    'autocapitalize': 'off',
                    'autocorrect': 'off'
                },
            }).then(function(password) {
                if ( ! password || vm.password != password)
                    return swal('Please try again...');

                axios.post('/api/register', {
                    'name':             vm.name,
                    'email':            vm.email,
                    'password':         vm.password,
                    'password-confirm': password
                })
                    .then(function(response) {
                        console.log(response.data);
                        eventBus.$emit('user-logged-in', response.data.user);
                    }, function(error) {
                        swal('Could not login.');
                    });
            }, function(dismiss) {
                swal('You must either register or login to subscribe to BARF Bento');
            });
            this.loading = false;
        }
    },
    created() {
        eventBus.$on('user-logged-in', this.loadUser);
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
