<template>
    <div>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th v-bind:colspan="numColumns + 1">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       v-model="sortable.filterKey"
                                />
                                <span class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <button class="btn btn-primary"
                                    @click="openPlanCreatorModal()"
                            >
                                New
                            </button>
                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th v-for="key in columns"
                    @click="sortBy(key)"
                    :class="{ active: sortable.sortKey == key }">
                    {{ key | capitalize }}
                    <span class="fa" :class="sortOrders[key] > 0 ? 'fa-sort-asc' : 'fa-sort-desc'">
                  </span>
                </th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="plan in filteredData(collection)" :key="plan.id">
                <td>{{ plan.id }}</td>
                <td>{{ plan.customer_name }}</td>
                <td>{{ plan.pet_name }}</td>
                <td>
                    {{ plan.package_label }}
                    <!--<admin-package-selector @select="onSelect"-->
                                            <!--:selected-package-id="plan.package_id"-->
                                            <!--:autonomous="1"-->
                                            <!--model-api="plans"-->
                                            <!--:model="plan"-->
                    <!--&gt;</admin-package-selector>-->
                </td>
                <td>{{ plan.weeks_of_food }}</td>
                <td>{{ plan.weeks_per_shipment }}</td>
                <td>{{ plan.cost }}</td>
                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="editPlan(plan)"
                    >
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>


        <admin-common-modal v-if="show.planCreatorModal"
                            @close="closePlanCreatorModal()"
        >
            <p slot="header" v-if="! mode">Add a Plan</p>
            <p slot="header" v-if="mode == 'EDIT'">Edit Plan: {{ selected.customer.name }} - {{ selected.pet.name }}</p>
            <admin-plans-creator @close="$emit('close')"
                                  slot="body"
            ></admin-plans-creator>
        </admin-common-modal>
    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import { mapGetters, mapState, mapActions } from 'vuex';
    import isSortable from '../../../mixins/isSortable';
    export default {
        mixins: [
            isSortable
        ],
        data() {
            let columns = [
                'id',
                'customer_name',
                'pet_name',
                'package_label',
                'weeks_of_food',
                'weeks_per_shipment',
                'cost',
            ];
            let numColumns = columns.length;
            let sortOrders = {};
            columns.forEach(function(key) {
                sortOrders[key] = 1;
            });

            return {
                columns: columns,
                numColumns: numColumns,
                sortOrders: sortOrders
            }
        },
        mounted() {
            this.loadPlans();
            this.loadPackages();
        },
        methods: {
            ...mapActions('plans', [
                'openPlanCreatorModal',
                'closePlanCreatorModal',
                'loadPlans',
                'editPlan',
            ]),
            ...mapActions('packages', [
                'loadPackages',
            ]),
            mealSize(plan) {
                return (plan.plan.pet_weight * plan.plan.pet_activity_level / 2 * 454 / 100).toFixed(0);
            },
            onSelect(val) {
                console.log('selected package...');
                console.log(val);

            }
        },
        computed: {
            ...mapState('plans', [
                'collection',
                'show',
                'selected',
                'mode',
            ])
        },
    }
</script>

<style>

</style>
