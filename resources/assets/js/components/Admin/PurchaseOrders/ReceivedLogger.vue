<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >
        <div class="row">

            <div class="col-sm-6">
                <div class="form-group"
                     v-bind:class="{'has-error': errors.has('received_at') }"
                >
                    <label>Received At</label>
                    <datepicker v-model="received_at"
                                id="received_at"
                                name="received_at"
                                format="yyyy-MM-dd"
                                input-class="form-control"
                    >
                    </datepicker>
                    <span class="help-block">{{ errors.get('received_at') }}</span>
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
                                @click="closeReceivedModal()"
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
            received_at: null,
        };
    },
    methods: {
        ...mapActions([
            'closeReceivedModal',
        ]),
        save() {
            let vm = this;

            return axios.post('/admin/api/purchase-orders/' + this.$store.state.selected.purchaseOrder.id + '/received', {
                received_at: moment(vm.received_at).format('YYYY-MM-DD'),
            }).then(response => {
                console.log('api request done...');
                vm.$store.commit('updateSelectedPurchaseOrder', { received: true });
                console.log('committed change to selected Purchase Order');
                vm.$store.dispatch('closeReceivedModal');
                console.log('closed Modal');

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
        this.received_at = new Date();
    }
}
</script>

<style>

</style>