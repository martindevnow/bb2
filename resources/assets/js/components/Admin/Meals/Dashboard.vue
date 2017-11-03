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
                                    @click="openMealCreatorModal()"
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
            <tr v-for="meal in filteredData(collection)">
                <td>{{ meal.id }}</td>
                <td>{{ meal.label }}</td>
                <td>{{ meal.code }}</td>
                <td>
                    {{ meal.meats.length ? meal.meats.map(meat => meat.type + ' (' + meat.variety + ')').join(', ') : '' }}
                </td>
                <td>
                    {{ meal.toppings.length ? meal.toppings.map(topping => topping.label).join(', ') : '' }}
                </td>
                <td>{{ meal.meal_value }}</td>
                <td>${{ meal.costPerLb().toFixed(2) }}</td>

                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="editMeal(meal)"
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

        <admin-common-modal v-if="show.mealCreatorModal">
            <p slot="header" v-if="! mode">Add a Meal</p>
            <p slot="header" v-if="mode == 'EDIT'">Edit Meal: {{ selected.label }}</p>
            <admin-meals-creator @saved="closeMealCreatorModal()"
                                 @cancelled="closeMealCreatorModal()"
                               slot="body"
            ></admin-meals-creator>
        </admin-common-modal>

    </div>
</template>

<script>
    import { mapGetters, mapState, mapActions } from 'vuex';
    import isSortable from '../../../mixins/isSortable';

    export default {
        mixins: [
            isSortable,
        ],
        data() {
            let columns = [
                'id',
                'label',
                'code',
                'meats',
                'toppings',
                'meal_value',
                'costPerLb',
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
            this.loadMeals();
        },
        methods: {
            ...mapActions('meals', [
                'loadMeals',
                'openMealCreatorModal',
                'closeMealCreatorModal',
                'editMeal',
            ]),
        },
        computed: {
            ...mapState('meals', [
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