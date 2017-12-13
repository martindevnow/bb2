<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">name</label>
                    <input class="form-control"
                           type="text"
                           id="name"
                           name="name"
                           v-model="form.name"
                    >
                    <span class="help-block">{{ errors.get('name') }}</span>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="description">Description</label>
                    <input class="form-control"
                           type="text"
                           id="description"
                           name="description"
                           v-model="form.description"
                    >
                    <span class="help-block">{{ errors.get('description') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="street_1">Street</label>
                    <input class="form-control"
                           type="text"
                           id="street_1"
                           name="street_1"
                           v-model="form.street_1"
                    >
                    <span class="help-block">{{ errors.get('street_1') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="street_2">Street (cont..)</label>
                    <input class="form-control"
                           type="text"
                           id="street_2"
                           name="street_2"
                           v-model="form.street_2"
                    >
                    <span class="help-block">{{ errors.get('street_2') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="city">City</label>
                    <input class="form-control"
                           type="text"
                           id="city"
                           name="city"
                           v-model="form.city"
                    >
                    <span class="help-block">{{ errors.get('city') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="province">State / Province</label>
                    <input class="form-control"
                           type="text"
                           id="province"
                           name="province"
                           v-model="form.province"
                    >
                    <span class="help-block">{{ errors.get('province') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="postal_code">Postal / Zip</label>
                    <input class="form-control"
                           type="text"
                           id="postal_code"
                           name="postal_code"
                           v-model="form.postal_code"
                    >
                    <span class="help-block">{{ errors.get('postal_code') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="country">Country</label>
                    <input class="form-control"
                           type="text"
                           id="country"
                           name="country"
                           v-model="form.country"
                    >
                    <span class="help-block">{{ errors.get('country') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input class="form-control"
                           type="text"
                           id="phone"
                           name="phone"
                           v-model="form.phone"
                    >
                    <span class="help-block">{{ errors.get('phone') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="buzzer">Buzzer</label>
                    <input class="form-control"
                           type="text"
                           id="buzzer"
                           name="buzzer"
                           v-model="form.buzzer"
                    >
                    <span class="help-block">{{ errors.get('buzzer') }}</span>
                </div>
            </div>
        </div>



        <div class="row">
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
    </form>
</template>

<script>
    import hasErrors from '../../../mixins/hasErrors';
    import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';

    export default {
        mixins: [
            hasErrors,
        ],
        data() {
            return {
                form: {
                    name: '',
                    description: '',
                    company: '',
                    street_1: '',
                    street_2: '',
                    city: '',
                    province: 'Ontario',
                    country: 'Canada',
                    postal_code: '',
                    phone: '',
                    buzzer: '',
                },
            };
        },
        methods: {
            ...mapMutations('addresses', [
                'addToAddressesCollection',
                'updateAddress',
            ]),
            save() {
                let vm = this;

                return axios.post('/admin/api/addresses', this.form
                ).then(response => {
                    vm.addToAddressesCollection(response.data);
                    vm.$emit('saved', response.data);
                }).catch(error => {
                    vm.errors.record(error.response.data.errors);
                });
            },
            update() {
                let vm = this;

                return axios.patch('/admin/api/addresses/' + this.selected.id, this.form
                ).then(response => {
                    vm.updateAddress(response.data);
                    vm.$emit('saved', response.data);
                }).catch(error => {
                    vm.errors.record(error.response.data.errors);
                });
            },

            populateFormFromModel(model) {
                for (let prop in this.form) {
                    if (this.form.hasOwnProperty(prop)) {
                        this.form[prop] = model[prop];
                    }
                }
            }
        },
        computed: {
            ...mapState('addresses', [
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
                this.populateFormFromModel(newSelected);
            }
        }
    }
</script>

<style>
    
</style>