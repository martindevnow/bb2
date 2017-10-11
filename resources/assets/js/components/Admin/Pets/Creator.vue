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
                    <basic-select :options="ownersSelect"
                                  :selected-option="owner"
                                  placeholder="Select Owner..."
                                  @select="onSelect"
                                  :class="{ 'has-error': errors.has('name') }"
                    >
                    </basic-select>
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
                        @click="closePetCreatorModal()"
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
            ownerSearchText: '',
            owner: {
                value: '',
                text: '',
            },
            form: {
                name: '',
                breed: '',
                species: 'dog',
                weight: null,
                activity_level: null,
                birthday: null,
            }
        };
    },
    methods: {
        ...mapActions('pets', [
            'closePetCreatorModal',
        ]),
        ...mapMutations('pets', [
            'addToPetsCollection',
        ]),
        ...mapActions('users', [
            'loadUsers',
        ]),
        save() {
            let vm = this;
            let birthday = this.birthday ? moment(this.birthday).format('YYYY-MM-DD') : null;
            let owner_id = this.owner.value;
            return axios.post('/admin/api/pets', {
                ...this.form,
                birthday,
                owner_id,
            }).then(response => {
                vm.addToPetsCollection(response.data);
                vm.closePetCreatorModal();
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        onSelect(owner) {
            this.errors.clear('owner_id');
            this.owner = owner;
        }
    },
    computed: {
        ...mapState('pets', ['show', 'selected']),
        ...mapState('users', {
            'users': 'collection'
        }),
        ownersSelect() {
            return this.users.map(user => {
                return { value: user.id, text: user.name + ' (' + user.id + ')' };
            });
        }
    },
    mounted() {
        this.loadUsers();
    }
}
</script>

<style>

</style>