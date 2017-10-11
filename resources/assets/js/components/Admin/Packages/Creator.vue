<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('code') }"
                >
                    <label for="code">Name</label>
                    <input type="text"
                           class="form-control"
                           id="code"
                           name="code"
                           v-model="form.code"
                    >
                    <span class="help-block">{{ errors.get('code') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('label') }"
                >
                    <label for="label">Breed</label>
                    <input type="text"
                           class="form-control"
                           id="label"
                           name="label"
                           v-model="form.label"
                    >
                    <span class="help-block">{{ errors.get('label') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('active') }"
                >
                    <label for="active">Species</label>
                    <input type="text"
                           class="form-control"
                           id="active"
                           name="active"
                           v-model="form.active"
                    >
                    <span class="help-block">{{ errors.get('active') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('customization') }"
                >
                    <label for="customization">Activity Level</label>
                    <input type="text"
                           class="form-control"
                           id="customization"
                           name="customization"
                           v-model="form.customization"
                    >
                    <span class="help-block">{{ errors.get('customization') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('level') }"
                >
                    <label>Birthday</label>
                    <input v-model="form.level"
                           type="text"
                            id="level"
                            name="level"
                            class="form-control"
                    >
                    <span class="help-block">{{ errors.get('level') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('public') }"
                >
                    <label for="public">Weight</label>
                    <input type="text"
                           class="form-control"
                           id="public"
                           name="public"
                           v-model="form.public"
                    >
                    <span class="help-block">{{ errors.get('public') }}</span>
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
    import { mapGetters, mapState, mapActions } from 'vuex';
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
        ...mapActions([
            'closePetCreatorModal',
            'addToPetsCollection',
            'loadUsers',
        ]),
        save() {
            let vm = this;

            let birthday = moment(this.birthday).format('YYYY-MM-DD');
            let owner_id = this.owner.value;
            return axios.post('/admin/api/pets', {
                ...this.form,
                birthday,
                owner_id,
            }).then(response => {
                vm.$store.commit('addToPetCollection', { pet: response.data });
                vm.$store.dispatch('closePetCreatorModal');
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
        ...mapState(['show', 'selected', 'users']),
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