<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <p>Note: if you update the package or # of weeks packed here, it will update their Order for this shipment.</p>
                <p>It will not change their plan.</p>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="weeks_packed">Weeks Packed</label>
                    <input type="text" class="form-control"
                           id="weeks_packed"
                           v-model="weeks_packed"
                    >
                </div>

            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="packed_package_id">Package</label>
                    <select v-model="packed_package_id"
                            class="form-control"
                            id="packed_package_id"
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
                <button class="btn btn-primary btn-block"
                        @click="save()"
                >
                    Save
                </button>
            </div>
            <div class="col-sm-6">
                <button class="btn btn-default btn-block"
                        @click="closePackedModal()"
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

export default {
    data() {
        return {
            weeks_packed: 0,
            packed_package_id: null,
        };
    },
    methods: {
        ...mapActions([
            'closePackedModal',
        ]),
        save() {
            let vm = this;

            return axios.post('/admin/api/orders/'+ this.$store.state.selected.order.id +'/packed', {
                weeks_packed:      this.weeks_packed,
                packed_package_id: this.packed_package_id,
            }).then(response => {
                vm.$store.commit('updateSelectedOrder', {
                    packed: true,
                    weeks_packed: vm.weeks_packed,
                    packed_package_id: vm.packed_package_id,
                });
                vm.$store.dispatch('closePackedModal');
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
        ]),
    },
    mounted() {
        this.weeks_packed = this.selected.order.plan.weeks_of_food_per_shipment;
        this.packed_package_id = this.selected.order.plan.package_id;
    }
}
</script>

<style>
span.label {
    color: black;
}
</style>