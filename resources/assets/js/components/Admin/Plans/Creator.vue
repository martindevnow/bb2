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
                                  :class="{ 'has-error': errors.has('pet_id') }"
                    >
                    </basic-select>
                    <span class="help-block">{{ errors.get('pet_id') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('pet_id') }"
                >
                    <label>Package</label>
                    <admin-package-selector @select="onPackageSelect"
                                            :autonomous="0"
                                            :selected-package-id="pkg.value"
                                            :errorsObj="errors"
                    ></admin-package-selector>
                    <span class="help-block">{{ errors.get('pet_id') }}</span>
                </div>
            </div>
        </div>
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
                     :class="{ 'has-error': errors.has('breed') }"
                >
                    <label for="breed">Breed</label>
                    <input type="text"
                           class="form-control"
                           id="breed"
                           name="breed"
                           v-model="form.breed"
                    >
                    <span class="help-block">{{ errors.get('breed') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('species') }"
                >
                    <label for="species">Species</label>
                    <input type="text"
                           class="form-control"
                           id="species"
                           name="species"
                           v-model="form.species"
                    >
                    <span class="help-block">{{ errors.get('species') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('activity_level') }"
                >
                    <label for="activity_level">Activity Level</label>
                    <input type="text"
                           class="form-control"
                           id="activity_level"
                           name="activity_level"
                           v-model="form.activity_level"
                    >
                    <span class="help-block">{{ errors.get('activity_level') }}</span>
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
                    >
                    </datepicker>
                    <span class="help-block">{{ errors.get('first_delivery_at') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('weight') }"
                >
                    <label for="weight">Weight</label>
                    <input type="text"
                           class="form-control"
                           id="weight"
                           name="weight"
                           v-model="form.weight"
                    >
                    <span class="help-block">{{ errors.get('weight') }}</span>
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
                weekly_cost: 0,
                weeks_of_food_per_shipment: 1,
                ships_every_x_weeks: null,
                first_delivery_at: null,
                comment: null,
                payment_method: 'cash',
                active: null,
            }
        };
    },
    methods: {
        ...mapActions('plans', [
            'closePlanCreatorModal',
        ]),
        ...mapMutations('plans', [
            'addToPlansCollection',
        ]),
        ...mapActions('pets', [
            'loadPets',
        ]),
        save() {
            let vm = this;
            let first_delivery_at = this.first_delivery_at ? moment(this.first_delivery_at).format('YYYY-MM-DD') : null;
            let pet_id = this.pet.value;
            return axios.post('/admin/api/plans', {
                ...this.form,
                first_delivery_at,
                pet_id,
            }).then(response => {
                vm.addToPetsCollection(response.data);
                vm.closePetCreatorModal();
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