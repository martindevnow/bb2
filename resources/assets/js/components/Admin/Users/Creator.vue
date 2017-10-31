<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
          autocomplete="off"
    >
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('name') }"
                >
                    <label for="name">Name</label>
                    <input type="text"
                           class="form-control"
                           id="name"
                           name="name"
                           v-model="form.name"
                    >
                    <span class="help-block">{{ errors.get('name') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('email') }"
                >
                    <label for="email">Email</label>
                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           v-model="form.email"
                           autocomplete="off"
                    >
                    <span class="help-block">{{ errors.get('email') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('password') }"
                >
                    <label for="password">Password</label>
                    <input type="password"
                           class="form-control"
                           id="password"
                           name="password"
                           v-model="form.password"
                           autocomplete="off"
                    >
                    <span class="help-block">{{ errors.get('password') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('phone_number') }"
                >
                    <label for="phone_number">Phone Number</label>
                    <input type="text"
                           class="form-control"
                           id="phone_number"
                           name="phone_number"
                           v-model="form.phone_number"
                    >
                    <span class="help-block">{{ errors.get('phone_number') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('first_name') }"
                >
                    <label>First Name</label>
                    <input type="text"
                           v-model="form.first_name"
                           id="first_name"
                           name="first_name"
                           class="form-control"
                    >
                    <span class="help-block">{{ errors.get('first_name') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('last_name') }"
                >
                    <label for="last_name">Last Name</label>
                    <input type="text"
                           class="form-control"
                           id="last_name"
                           name="last_name"
                           v-model="form.last_name"
                    >
                    <span class="help-block">{{ errors.get('last_name') }}</span>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-primary btn-block"
                        :disabled="errors.any()"
                        @click="save()"
                        v-if="! mode"
                >
                    Save
                </button>
                <button class="btn btn-primary btn-block"
                        :disabled="errors.any()"
                        @click="update()"
                        v-if="mode == 'EDIT'"
                >
                    Update
                </button>
            </div>
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-default btn-block"
                        @click="closeUserCreatorModal()"
                >
                    Cancel
                </button>
            </div>
        </div>


    </form>
</template>

<script>
    import hasErrors from '../../../mixins/hasErrors';
    import Form from '../../../models/Form';
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';
    import { ModelListSelect } from 'vue-search-select';

export default {
    mixins: [
        hasErrors
    ],
    components: {
        ModelListSelect,
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                first_name: null,
                last_name: null,
                phone_number: null,
            }
        };
    },
    methods: {
        ...mapActions('users', [
            'closeUserCreatorModal'
        ]),
        ...mapMutations('users', [
            'addToUsersCollection',
            'updateUser',
        ]),
        save() {
            let vm = this;

            return axios.post('/admin/api/users', this.form
            ).then(response => {
                vm.addToUsersCollection(response.data);
                vm.closeUserCreatorModal();
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        update() {
            let vm = this;

            return axios.patch('/admin/api/users/' + this.selected.id,
                this.form
            ).then(response => {
                vm.updateUser(response.data);
                vm.closeUserCreatorModal();
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        populateFormFromUser(user) {
            this.form.name = user.name;
            this.form.email = user.email;
            this.form.password = '';
            this.form.first_name = user.first_name;
            this.form.last_name = user.last_name;
            this.form.phone_number = user.phone_number;
        }
    },
    computed: {
        ...mapState('users', [
            'collection',
            'mode',
            'selected',
            'show',
        ]),
    },
    mounted() {
        if (this.mode == 'EDIT') {
            this.populateFormFromUser(this.selected);
        }
    },
    watch: {
        selected(newSelected) {
            this.populateFormFromUser(newSelected);
        }
    }
}
</script>

<style>

</style>