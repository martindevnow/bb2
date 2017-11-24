<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
          autocomplete="off"
    >
        <div class="row" v-if="addAddress">
            <div class="col-sm-12">
                <h1>Editing Addresses ...</h1>
            </div>
        </div>
        <div class="row" v-if="! addAddress">
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

        <div class="row" v-if="! addAddress">
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
        <div class="row" v-if="! addAddress">
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


        <div class="row" v-if="! addAddress">
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-success btn-block"
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
                        @click="$emit('cancelled')"
                >
                    Cancel
                </button>
            </div>
        </div>

        <div class="row" v-if="showAddresses">
            <div class="col-sm-12">
                <h1> Current Addresses:</h1>
            </div>
            <div class="col-sm-12">
                <div class="row" v-for="address in selected.addresses">
                    <div class="col-xs-10">
                        <button class="btn btn-default btn-block"
                                @click="editAddress(address)"
                        >
                            <i class="fa fa-pencil"></i>
                            {{ address.street_1 }}
                            {{ address.street_2 }}
                            {{ address.city }}
                            {{ address.province }}
                            {{ address.postal_code }}
                            {{ address.country }}
                        </button>
                    </div>
                    <div class="col-xs-2">
                        <button class="btn btn-danger btn-block"
                                @click="deleteAddress(address)"
                        >
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if="! addAddress && showAddresses">
            <div class="col-sm-12">
                <button class="btn btn-block btn-primary"
                        @click="addAddress = true"
                >
                    <i class="fa fa-plus"></i> Add an Address
                </button>
            </div>
        </div>

        <div class="row" v-if="showAddresses && addAddress">
            <div class="col-sm-12">
                <admin-addresses-creator @cancelled="addAddress = false"
                                         @saved="attachAddress"
                                         @updated="updateUserAddress"
                ></admin-addresses-creator>
            </div>
        </div>


    </form>
</template>

<script>
    import hasErrors from '../../../mixins/hasErrors';
    import Form from '../../../models/Form';
    import swal from 'sweetalert2';
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';
    import * as userActions from '../../../vuex/modules/users/actionTypes';
    import * as userMutations from '../../../vuex/modules/users/mutationTypes';
    import * as addressActions from "../../../vuex/modules/addresses/actionTypes";

export default {
    mixins: [
        hasErrors
    ],
    components: {},
    props: ['showAddresses'],
    data() {
        return {
            addAddress: false,
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
        save() {
            let vm = this;
            this.$store.dispatch('users/' + userActions.SAVE,
                this.form
            ).then(response => {
                vm.$emit('saved');
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        update() {
            let vm = this;
            this.$store.dispatch('users/' + userActions.UPDATE,
                this.form
            ).then(response => {
                vm.$emit('saved');
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        attachAddress(data) {
            let vm = this;
            axios.put('/admin/api/users/' + this.selected.id + '/attachAddress',
                { address_id: data.id }
            ).then(response => {
                alert('Address attached');
                vm.$store.commit('users/' + userMutations.ATTACH_ADDRESS, data);
                vm.addAddress = false;
            }).catch(error => {
                alert('error');
            })
        },
        updateUserAddress(address) {
            this.$store.commit('users/' + userMutations.UPDATE_ADDRESS, address);
            this.addAddress = false;
        },
        populateFormFromModel(model) {
            for (let prop in this.form) {
                if (this.form.hasOwnProperty(prop)) {
                    this.form[prop] = model[prop];
                }
            }
            this.form.password = '';
        },
        editAddress(address) {
            this.addAddress = true;
            this.$store.dispatch('addresses/' + addressActions.EDIT, address);
        },
        deleteAddress(address) {
            swal('error', 'You shouldnt do that...', 'error');
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
            this.populateFormFromModel(this.selected);
        }
    },
    watch: {
        selected(newSelected) {
            if (newSelected)
                this.populateFormFromModel(newSelected);
        }
    }
}
</script>

<style>

</style>