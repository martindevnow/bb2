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
                     :class="{ 'has-error': errors.has('type') }"
                >
                    <label for="type">type</label>
                    <input type="text"
                           class="form-control"
                           id="type"
                           name="type"
                           v-model="form.type"
                    >
                    <span class="help-block">{{ errors.get('type') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('variety') }"
                >
                    <label for="variety">variety</label>
                    <input type="text"
                           class="form-control"
                           id="variety"
                           name="variety"
                           v-model="form.variety"
                    >
                    <span class="help-block">{{ errors.get('variety') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('cost_per_lb') }"
                >
                    <label for="cost_per_lb">cost_per_lb</label>
                    <input cost_per_lb="text"
                           class="form-control"
                           id="cost_per_lb"
                           name="cost_per_lb"
                           v-model="form.cost_per_lb"
                    >
                    <span class="help-block">{{ errors.get('cost_per_lb') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('has_bone') }"
                >
                    <label>Status</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   class="checkbox style-0"
                                   name="has_bone"
                                   id="has_bone"
                                   v-model="form.has_bone">
                            <span>Has Bone?</span>
                        </label>
                    </div>
                    <span class="help-block">{{ errors.get('has_bone') }}</span>
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
import Form from '../../../models/Form';
import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';
import moment from 'moment';
import * as actions from '../../../vuex/modules/meats/actionTypes';
import * as mutations from '../../../vuex/modules/meats/mutationTypes';

export default {
    mixins: [
        hasErrors
    ],
    data() {
        return {
            form: {
                code: '',
                type: '',
                variety: '',
                has_bone: '',
                cost_per_lb: '',
            },
        };
    },
    methods: {
        ...mapMutations('meats', [
            'addToMeatsCollection',
            'updateMeat',
        ]),
        populateFormFromMeat(meat) {
            this.form.code = meat.code;
            this.form.type = meat.type;
            this.form.variety = meat.variety;
            this.form.cost_per_lb = meat.cost_per_lb;
            this.form.has_bone = meat.has_bone;
        },
        save() {
            let vm = this;
            this.$store.dispatch('meats/' + actions.SAVE,
                this.form
            ).then(response => {
                vm.$emit('saved');
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        update() {
            let vm = this;
            this.$store.dispatch('meats/' + actions.UPDATE,
                this.form
            ).then(response => {
                vm.$emit('saved');
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
    },
    computed: {
        ...mapState('meats', ['show', 'selected', 'mode']),
        ...mapState('meats', {
            'meats': 'collection'
        }),
    },
    mounted() {
        this.$store.dispatch('meats/' + actions.FETCH_ALL);
        if (this.mode == 'EDIT') {
            this.populateFormFromMeat(this.selected);
        }
    },
    watch: {
        selected(newSelected) {
            this.populateFormFromMeat(newSelected);
        }
    }
}
</script>

<style>

</style>