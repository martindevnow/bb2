<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('label') }"
                >
                    <label for="label">Label</label>
                    <input type="text"
                           class="form-control"
                           id="label"
                           name="label"
                           v-model="form.label"
                    >
                    <span class="help-block">{{ errors.get('label') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('public') }"
                >
                    <label>Availability</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   class="checkbox style-0"
                                   name="public"
                                   id="public"
                                   v-model="form.public">
                            <span>Public</span>
                        </label>
                    </div>
                    <span class="help-block">{{ errors.get('public') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('code') }"
                >
                    <label for="code">Code</label>
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
                     :class="{ 'has-error': errors.has('customization') }"
                >
                    <label>Type</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   class="checkbox style-0"
                                   name="customization"
                                   id="customization"
                                   v-model="form.customization">
                            <span>Customized</span>
                        </label>
                    </div>
                    <span class="help-block">{{ errors.get('customization') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('level') }"
                >
                    <label>Level</label>
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
                     :class="{ 'has-error': errors.has('active') }"
                >
                    <label>Status</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   class="checkbox style-0"
                                   name="active"
                                   id="active"
                                   v-model="form.active">
                            <span>Active</span>
                        </label>
                    </div>
                    <span class="help-block">{{ errors.get('active') }}</span>
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
                        @click="closePackageCreatorModal()"
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
                code: '',
                label: '',
                customization: false,
                level: null,
                active: false,
                public: false,
            }
        };
    },
    methods: {
        ...mapActions('packages', [
            'closePackageCreatorModal',
            'addToPackagesCollection',
        ]),
        ...mapActions('meals', [
            'loadMeals'
        ]),
        save() {
            let vm = this;
            return axios.post('/admin/api/packages', {
                ...this.form
            }).then(response => {
                vm.addToPackagesCollection({ package: response.data });
                vm.closePackageCreatorModal();
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        update() {
            let vm = this;

            return axios.patch('/admin/api/users/' + this.selected.id, this.form
            ).then(response => {
                console.log(response);
                console.log(response.data);
                vm.updateUser(response.data);
                vm.closeUserCreatorModal();
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        populateFormFromPackage(pkg) {
            this.form.label = pkg.label;
            this.form.code = pkg.code;
            this.form.active = pkg.active;
            this.form.level = pkg.level;
            this.form.customization = pkg.customization;
            this.form.public = pkg.public;
        },
        onSelect(owner) {
            this.errors.clear('owner_id');
            this.owner = owner;
        }
    },
    computed: {
        ...mapState('packages', [
            'collection',
            'mode',
            'selected',
            'show',
        ]),
        ownersSelect() {
            return this.users.map(user => {
                return { value: user.id, text: user.name + ' (' + user.id + ')' };
            });
        }
    },
    mounted() {
        this.loadMeals();

        if (this.mode == 'EDIT') {
            this.populateFormFromPackage(this.selected);
        }
    },
    watch: {
        selected(newSelected) {
            this.populateFormFromPackage(newSelected);
        }
    }
}
</script>

<style>

</style>