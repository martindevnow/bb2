<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >
        <div class="row">

            <div class="col-sm-6">
                <div class="form-group"
                     v-bind:class="{'has-error': errors.has('ordered_at') }"
                >
                    <label>Ordered At</label>
                    <datepicker v-model="ordered_at"
                                id="ordered_at"
                                name="ordered_at"
                                format="yyyy-MM-dd"
                                input-class="form-control"
                    >
                    </datepicker>
                    <span class="help-block">{{ errors.get('ordered_at') }}</span>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-6">
                        <label>&nbsp;</label>
                        <button class="btn btn-success btn-block"
                                :disabled="errors.any()"
                                @click="save()"
                        >
                            Save
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <label>&nbsp;</label>
                        <button class="btn btn-default btn-block"
                                @click="closeOrderedModal()"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import Datepicker from 'vuejs-datepicker';
import moment from 'moment';
import hasErrors from '../../../mixins/hasErrors';

export default {
    mixins: [
        hasErrors
    ],
    components: {
        Datepicker,
    },
    data() {
        return {
            ordered_at: null,
        };
    },
    methods: {
        ...mapActions([
            'closeOrderedModal',
        ]),
        save() {
            let vm = this;

            return axios.post('/admin/api/purchase-orders/' + this.$store.state.selected.purchaseOrder.id + '/ordered', {
                ordered_at: moment(vm.ordered_at).format('YYYY-MM-DD'),
            }).then(response => {
                vm.$store.commit('updateSelectedPurchaseOrder', { ordered: true });
                vm.$store.dispatch('closeOrderedModal');

            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
    },
    computed: {
        ...mapState([
            'show',
            'selected'
        ]),
    },
    mounted() {
        this.ordered_at = new Date();
    }
}
</script>

<style>

</style>