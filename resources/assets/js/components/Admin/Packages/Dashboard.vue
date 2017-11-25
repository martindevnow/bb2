<template>
    <div>
        <table class="table table-bordered table-responsive table-striped">
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
                                    @click="openPackageCreatorModal()"
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
            <tr v-for="package in filteredData(collection)">
                <td>{{ package.label }}</td>
                <td>{{ package.code }}</td>
                <td>
                    <button class="btn btn-circle btn-xs"
                            :class="boolBtnClass(package.active)"
                    >
                        <i class="fa"
                           :class="boolIconClass(package.active)"
                        ></i>
                    </button>
                </td>
                <td>
                    <button class="btn btn-circle btn-xs"
                            :class="boolBtnClass(package.public)"
                    >
                        <i class="fa"
                           :class="boolIconClass(package.public)"
                        ></i>
                    </button>
                </td>
                <td>
                    <button class="btn btn-circle btn-xs"
                            :class="boolBtnClass(package.customization)"
                    >
                        <i class="fa"
                           :class="boolIconClass(package.customization)"
                        ></i>
                    </button>
                </td>
                <td>{{ package.level }}</td>
                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="openMealPlanEditorModal(package)"
                    >
                        Meals
                    </button>
                </td>
                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="edit(package)"
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
                            @close="closePackageCreatorModal()"
        >
            <p slot="header" v-if="! mode">Add a Package</p>
            <p slot="header" v-if="mode == 'EDIT'">Edit Package: {{ selected.label }}</p>
            <admin-packages-creator @cancelled="closePackageCreatorModal()"
                                    @updated="closePackageCreatorModal()"
                                    @saved="closePackageCreatorModal()"
                                    slot="body"
            ></admin-packages-creator>
        </admin-common-modal>

        <admin-common-modal v-if="show.mealPlanEditor"
                            @close="closeMealPlanEditorModal()"
        >
            <p slot="header">Edit Meal Plan for {{ selected.label }} Bento</p>
            <admin-meal-plan-editor @cancelled="closeMealPlanEditorModal()"
                                    @updated="closeMealPlanEditorModal()"
                                    @saved="closeMealPlanEditorModal()"
                                    slot="body"
            ></admin-meal-plan-editor>
        </admin-common-modal>
    </div>
</template>

<script>
    import { mapGetters, mapState, mapActions } from 'vuex';
    import isSortable from '../../../mixins/isSortable';
    import * as packageActions from '../../../vuex/modules/packages/actionTypes';

    export default {
        mixins: [
            isSortable,
        ],
        data() {
            let columns = [
                'label',
                'code',
                'active',
                'public',
                'custom',
                'level',
                'meals',
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
            this.$store.dispatch('packages/' + packageActions.FETCH_ALL);
        },
        methods: {
            openPackageCreatorModal() {
                this.$store.dispatch('packages/' + packageActions.CREATE);
            },
            closePackageCreatorModal() {
                this.$store.dispatch('packages/' + packageActions.CANCEL);
            },
            openMealPlanEditorModal(model) {
                this.$store.dispatch('packages/' + packageActions.OPEN_MEAL_PLAN_EDITOR, model);
            },
            closeMealPlanEditorModal() {
                this.$store.dispatch('packages/' + packageActions.CLOSE_MEAL_PLAN_EDITOR);
            },
            edit(model) {
                this.$store.dispatch('packages/' + packageActions.EDIT, model);
            },
            boolIconClass(val) {
                if (val)
                    return 'fa-check';
                return 'fa-times';
            },
            boolBtnClass(val) {
                if (val)
                    return 'btn-success';
                return 'btn-danger';
            }
        },
        computed: {
            ...mapState('packages', [
                'collection',
                'show',
                'selected',
                'mode'
            ])
        }
    }
</script>

<style>

</style>