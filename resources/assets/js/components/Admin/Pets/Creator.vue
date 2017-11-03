<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('owner_id') }"
                >
                    <label>Owner</label>
                    <admin-user-selector v-model="form.owner"
                                         @input="errors.clear('owner_id')"
                    ></admin-user-selector>
                    <span class="help-block">{{ errors.get('owner_id') }}</span>
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
                     :class="{ 'has-error': errors.has('birthday') }"
                >
                    <label>Birthday</label>
                    <datepicker v-model="form.birthday"
                                id="birthday"
                                name="birthday"
                                format="yyyy-MM-dd"
                                input-class="form-control"
                    >
                    </datepicker>
                    <span class="help-block">{{ errors.get('birthday') }}</span>
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
                <div class="form-group"
                     :class="{ 'has-error': errors.has('daily_meals') }"
                >
                    <label for="daily_meals">Daily Meals</label>
                    <input type="text"
                           class="form-control"
                           id="daily_meals"
                           name="daily_meals"
                           v-model="form.daily_meals"
                    >
                    <span class="help-block">{{ errors.get('daily_meals') }}</span>
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
    },
    data() {
        return {
            form: {
                owner: {},
                owner_id: null,
                name: '',
                breed: '',
                species: 'dog',
                weight: null,
                activity_level: null,
                birthday: null,
                daily_meals: 2,
            }
        };
    },
    methods: {
        ...mapMutations('pets', [
            'addToPetsCollection',
            'updatePet',
        ]),
        ...mapActions('users', [
            'loadUsers',
        ]),
        save() {
            let vm = this;
            let birthday = this.form.birthday ? moment(this.birthday).format('YYYY-MM-DD') : null;
            let owner_id = this.form.owner.id;
            return axios.post('/admin/api/pets', {
                ...this.form,
                birthday,
                owner_id,
            }).then(response => {
                console.log('api call done...');
                vm.addToPetsCollection(response.data);
                vm.$emit('saved');
            }).catch(error => {
                console.log('error in pet creator');
                console.log(error);
                vm.errors.record(error.response.data.errors);
            });
        },
        update() {
            let vm = this;
            let birthday = this.form.birthday ? moment(this.birthday).format('YYYY-MM-DD') : null;
            let owner_id = this.form.owner.id;
            return axios.patch('/admin/api/pets/' + this.selected.id, {
                    ...this.form,
                    birthday,
                    owner_id,
            }).then(response => {
                console.log('api call done...');
                vm.updatePet(response.data);
                vm.$emit('saved');
            }).catch(error => {
                console.log('error in pet creator');
                console.log(error);
                vm.errors.record(error.response.data.errors);
            });
        },
        populateFormFromPet(pet) {
            this.form.owner = pet.owner;

            this.form.name = pet.name;
            this.form.breed = pet.breed;
            this.form.species = pet.species;
            this.form.weight = pet.weight;
            this.form.activity_level = pet.activity_level;
            this.form.birthday = pet.birthday;
            this.form.daily_meals = pet.daily_meals;
        }
    },
    computed: {
        ...mapState('pets', [
            'collection',
            'mode',
            'selected',
            'show',
        ]),
        ...mapState('users', {
            'users': 'collection'
        }),
    },
    mounted() {
        this.loadUsers();
        if (this.mode == 'EDIT') {
            this.populateFormFromPet(this.selected);
        }
    },
    watch: {
        selected(newSelected) {
            this.populateFormFromPet(newSelected);
        }
    }
}
</script>

<style>

</style>