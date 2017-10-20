<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('code') }"
                >
                    <label for="code">code</label>
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
                    <label for="label">label</label>
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
                <h2>Meats</h2>



            </div>
            <div class="col-sm-6">
                <h2>Toppings</h2>


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
                        @click="closeMealCreatorModal()"
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
        ...mapActions('meals', [
            'closeMealCreatorModal',
        ]),
        ...mapMutations('meals', [
            'addToMealsCollection',
        ]),
        ...mapActions('meats', [
            'loadMeats',
        ]),
        save() {
            let vm = this;
            return axios.post('/admin/api/pets', {
                ...this.form,
            }).then(response => {
                vm.addToMealsCollection(response.data);
                vm.closeMealCreatorModal();
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
        ...mapState('meals', ['show', 'selected']),
        ...mapState('meats', {
            'meats': 'collection'
        }),
        ownersSelect() {
            return this.meats.map(model => {
                return { value: model.id, text: model.name + ' (' + model.id + ')' };
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