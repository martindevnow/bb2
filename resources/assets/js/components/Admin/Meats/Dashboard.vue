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
                                    @click="create()"
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
            <tr v-for="meat in filteredData(collection)">
                <td>{{ meat.type }}</td>
                <td>{{ meat.variety }}</td>
                <td>{{ meat.code }}</td>
                <td>${{ meat.cost_per_lb.toFixed(2) }}</td>
                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="edit(meat)"
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
                            @close="closeCreator()"
        >
            <p slot="header" v-if="! mode">Add a Meat</p>
            <p slot="header" v-if="mode == 'EDIT' && selected">Edit Meat: {{ selected.type }} {{ selected.variety }}</p>
            <admin-meats-creator @saved="closeCreator()"
                                 @cancelled="closeCreator()"
                                 slot="body"
            ></admin-meats-creator>
        </admin-common-modal>

    </div>
</template>

<script>
import { mapGetters, mapState, mapActions } from 'vuex';
import isSortable from '../../../mixins/isSortable';
import * as actions from '../../../vuex/modules/meats/actionTypes';
import * as mutations from '../../../vuex/modules/meats/mutationTypes';

export default {
    mixins: [
        isSortable,
    ],
    data() {
        let columns = [
            'type',
            'variety',
            'code',
            'cost_per_lb',
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
        this.$store.dispatch('meats/' + actions.FETCH_ALL);
    },
    methods: {
        create() {
            this.$store.dispatch('meats/' + actions.CREATE);
        },
        closeCreator() {
            this.$store.commit('meats/' + mutations.CLEAR_MODE)
        },
        edit(model) {
            this.$store.dispatch('meats/' + actions.EDIT, model);
        }
    },
    computed: {
        ...mapState('meats', [
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