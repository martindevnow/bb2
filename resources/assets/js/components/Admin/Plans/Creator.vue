<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('pet_id') }"
                >
                    <label>Owner</label>
                    <basic-select :options="petsSelect"
                                  :selected-option="pet"
                                  placeholder="Select Pet..."
                                  @select="onPetSelect"
                                  :isError="errors.has('pet_id')"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('pet_id') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('package_id') }"
                >
                    <label>Package</label>
                    <admin-package-selector @select="onPackageSelect"
                                            :autonomous="0"
                                            :selected-package-id="pkg.value"
                                            :hasError="errors.has('package_id')"
                    ></admin-package-selector>
                    <span class="help-block">{{ errors.get('package_id') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('shipping_cost') }"
                >
                    <label for="shipping_cost">shipping_cost</label>
                    <input type="text"
                           class="form-control"
                           id="shipping_cost"
                           name="shipping_cost"
                           v-model="form.shipping_cost"
                    >
                    <span class="help-block">{{ errors.get('shipping_cost') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('weekly_cost') }"
                >
                    <label for="weekly_cost">weekly_cost</label>
                    <input type="text"
                           class="form-control"
                           id="weekly_cost"
                           name="weekly_cost"
                           v-model="form.weekly_cost"
                    >
                    <span class="help-block">{{ errors.get('weekly_cost') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('weeks_of_food_per_shipment') }"
                >
                    <label for="weeks_of_food_per_shipment">weeks_of_food_per_shipment</label>
                    <input type="text"
                           class="form-control"
                           id="weeks_of_food_per_shipment"
                           name="weeks_of_food_per_shipment"
                           v-model="form.weeks_of_food_per_shipment"
                    >
                    <span class="help-block">{{ errors.get('weeks_of_food_per_shipment') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('ships_every_x_weeks') }"
                >
                    <label for="ships_every_x_weeks">ships_every_x_weeks</label>
                    <input type="text"
                           class="form-control"
                           id="ships_every_x_weeks"
                           name="ships_every_x_weeks"
                           v-model="form.ships_every_x_weeks"
                    >
                    <span class="help-block">{{ errors.get('ships_every_x_weeks') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('first_delivery_at') }"
                >
                    <label>First Delivery At</label>
                    <datepicker v-model="form.first_delivery_at"
                                id="first_delivery_at"
                                name="first_delivery_at"
                                format="yyyy-MM-dd"
                                input-class="form-control"
                                @selected="errors.clear('first_delivery_at')"
                    >
                    </datepicker>
                    <span class="help-block">{{ errors.get('first_delivery_at') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('payment_method') }"
                >
                    <label for="payment_method">payment_method</label>
                    <select v-model="form.payment_method"
                            class="form-control"
                            id="payment_method"
                            name="payment_method"
                            @change="errors.clear('payment_method')"
                    >
                        <option v-for="format in paymentFormats">{{ format }}</option>
                    </select>
                    <span class="help-block">{{ errors.get('payment_method') }}</span>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-primary btn-block"
                        :disabled="errors.any()"
                        @click="save()"
                >
                    Save
                </button>
            </div>
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-default btn-block"
                        @click="closePlanCreatorModal()"
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
import moment from 'moment';
import Datepicker from 'vuejs-datepicker';
import { BasicSelect } from 'vue-search-select'

export default {
    mixins: [
        hasErrors
    ],
    components: {
        Datepicker,
        BasicSelect,
    },
    data() {
        return {
            pet: {
                value: '',
                text: '',
            },
            pkg: {
                value: '',
                text: '',
            },
            form: {
                shipping_cost: 0,
                package_id: 0,
                pet_id: 0,
                weekly_cost: 0,
                weeks_of_food_per_shipment: 1,
                ships_every_x_weeks: null,
                first_delivery_at: null,
                payment_method: 'cash',
            },
            paymentFormats: [
                'cash',
                'e-transfer',
                'stripe',
                'paypal',
                'interac',
            ],
        };
    },
    methods: {
        ...mapActions('plans', [
            'closePlanCreatorModal'
        ]),
        ...mapMutations('plans', [
            'addToPlansCollection',
        ]),
        ...mapActions('pets', [
            'loadPets',
        ]),
        save() {
            let vm = this;
            let first_delivery_at = this.form.first_delivery_at ? moment(this.form.first_delivery_at).format('YYYY-MM-DD') : null;
            return axios.post('/admin/api/plans', {
                ...this.form,
                first_delivery_at,
            }).then(response => {
                vm.addToPlansCollection(response.data);
                vm.closePlanCreatorModal();
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        onPetSelect(pet) {
            this.errors.clear('pet_id');
            this.pet = pet;
            this.form.pet_id = pet.value;
        },
        onPackageSelect(pkg) {
            this.errors.clear('package_id');
            this.pkg = pkg;
            this.form.package_id = pkg.value;
        }
    },
    computed: {
        ...mapState('plans', ['show', 'selected']),
        ...mapState('pets', {
            'pets': 'collection'
        }),
        petsSelect() {
            return this.pets.map(model => {
                return { value: model.id, text: model.name + ' (' + model.id + ')' };
            });
        }
    },
    mounted() {
        this.loadPets();
    }
}
</script>

<style>

</style>