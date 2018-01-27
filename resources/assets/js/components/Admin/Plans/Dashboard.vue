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
                </td>
                <td>{{ plan.weeks_of_food }} / {{ plan.weeks_per_shipment }}</td>
                <td>${{ plan.weekly_cost }}</td>
                <td>
                    <button class="btn btn-default btn-xs"
                            @click="createNote({ model: plan, type: 'plan' })"
                    >
                        + Note
                    </button>
                    <button class="btn btn-xs btn-primary"
                            @click="openMealReplacementModal(plan)"
                    >
                        Replace Meal
                    </button>
                    <button class="btn btn-primary btn-xs"
                            @click="edit(plan)"
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


        <admin-common-modal v-if="show.creator"
                            @close="closePlanCreatorModal()"
        >
            <p slot="header" v-if="! mode">Add a Plan</p>
            <p slot="header" v-if="mode == 'EDIT'">Edit Plan: {{ selected.customer.name }} - {{ selected.pet.name }}</p>
            <admin-plans-creator @saved="closePlanCreatorModal()"
                                 @updated="closePlanCreatorModal()"
                                 @cancelled="closePlanCreatorModal()"
                                 slot="body"
            ></admin-plans-creator>
        </admin-common-modal>
        <admin-common-modal v-if="notesShow.creator"
                            @close="closeNoteCreatorModal()"
        >
            <admin-notes-creator @saved="closeNoteCreatorModal()"
                                 @updated="closeNoteCreatorModal()"
                                 @cancelled="closeNoteCreatorModal()"
                                 slot="body"
            >
            </admin-notes-creator>
        </admin-common-modal>
        <admin-common-modal v-if="show.mealReplacementModal"
                            @close="closeMealReplacementModal()"
        >
            <admin-plans-meal-replacement @saved="closeMealReplacementModal()"
                                          @updated="closeMealReplacementModal()"
                                          @cancelled="closeMealReplacementModal()"
                                          slot="body"
            >
            </admin-plans-meal-replacement>
        </admin-common-modal>
    </div>
</template>

<script>
    import swal from 'sweetalert2'
    import { mapGetters, mapState, mapActions } from 'vuex';
    import isSortable from '../../../mixins/isSortable';

    import * as packageActions from '../../../vuex/modules/packages/actionTypes';
    import * as planActions from '../../../vuex/modules/plans/actionTypes';
    import * as noteActions from "../../../vuex/modules/notes/actionTypes";

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
                'X wks food every X wks',
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
            this.fetchAll();
        },
        methods: {
            fetchAll() {
                this.$store.dispatch('plans/' + planActions.FETCH_ALL);
                this.$store.dispatch('packages/' + packageActions.FETCH_ALL);
            },
            openPlanCreatorModal() {
                this.$store.dispatch('plans/' + planActions.CREATE)
            },
            closePlanCreatorModal() {
                this.$store.dispatch('plans/' + planActions.CANCEL)
            },
            edit(plan) {
                this.$store.dispatch('plans/' + planActions.EDIT, plan);
            },
            openMealReplacementModal(plan) {
                this.$store.dispatch('plans/' + planActions.OPEN_MEAL_REPLACEMENT_CREATOR, plan)
            },
            closeMealReplacementModal() {
                this.$store.dispatch('plans/' + planActions.CLOSE_MEAL_REPLACEMENT_CREATOR)
            },
            openNoteCreatorModal(dto) {
                this.$store.dispatch('notes/' + noteActions.CREATE, dto)
            },
            closeNoteCreatorModal() {
                this.$store.dispatch('notes/' + noteActions.CANCEL)
            },
            createNote(dto) {
                this.$store.dispatch('notes/' + noteActions.CREATE, dto);
            }
        },
        computed: {
            ...mapState('plans', [
                'collection',
                'show',
                'selected',
                'mode',
            ]),
            ...mapState('notes', {
                'notesShow': 'show',
            }),
        },
    }
</script>

<style>

</style>
