<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <p>Note: if you update the package or # of weeks shipped here, it will update their Order for this shipment.</p>
                <p>It will not change their plan.</p>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="weeks_shipped">Weeks Shipped</label>
                    <input type="text" class="form-control"
                           id="weeks_shipped"
                           v-model="weeks_shipped"
                    >
                </div>

            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="shipped_package_id">Package</label>
                    <select v-model="shipped_package_id"
                            class="form-control"
                            id="shipped_package_id"
                    >
                        <option v-for="package in packages"
                                :selected="selected.order.plan.package_id == package.id"
                                :value="package.id"
                        >{{ package.label }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Date Shipped</label>
                    <datepicker v-model="shipped_at"
                                id="shipped_at"
                                format="yyyy-MM-dd"
                                input-class="form-control"
                    >
                    </datepicker>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="courier_id">Courier</label>
                    <select v-model="courier_id"
                            class="form-control"
                            id="courier_id"
                    >
                        <option v-for="courier in couriers"
                                :value="courier.id"
                        >{{ courier.label }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <button class="btn btn-primary btn-block"
                        @click="save()"
                >
                    Save
                </button>
            </div>
            <div class="col-sm-6">
                <button class="btn btn-default btn-block"
                        @click="closeShippedModal()"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import eventBus from '../../../events/eventBus';
import Datepicker from 'vuejs-datepicker';
import moment from 'moment';
export default {
    components: {
        Datepicker,
    },
    data() {
        return {
            weeks_shipped: null,
            shipped_package_id: null,
            shipped_at: null,
            courier_id: null,
        };
    },
    methods: {
        ...mapActions([
            'closeShippedModal',
            'loadCouriers',
        ]),
        save() {
            let vm = this;

            return axios.post('/admin/api/orders/'+ this.$store.state.selected.order.id +'/shipped', {
                courier_id: this.courier_id,
                shipped_at: moment(this.shipped_at).format('YYYY-MM-DD'),
                weeks_shipped: this.weeks_shipped,
                shipped_package_id: this.shipped_package_id,
            }).then(response => {
                vm.$store.commit('updateSelectedOrder', {
                    shipped: true,
                    shipped_at: moment(this.shipped_at).format('YYYY-MM-DD'),
                    weeks_shipped: this.weeks_shipped,
                    shipped_package_id: this.shipped_package_id,
                });
                vm.$store.dispatch('closeShippedModal');
            }).catch(error => {
                console.log('error', error);
            });
        },
    },
    computed: {
        ...mapState([
            'show',
            'selected',
            'packages',
            'couriers',
        ]),
    },
    mounted() {
        this.loadCouriers();
        this.shipped_at = new Date();
        this.shipped_package_id = this.selected.order.packed_package_id
            || this.selected.order.plan.package_id;
        this.weeks_shipped = this.selected.order.weeks_packed
            || this.selected.order.plan.weeks_of_food_per_shipment;
    }
}
</script>

<style>
span.label {
    color: black;
}
</style>