<template>
    <div>
        <table class="table table-bordered table-responsive table-striped">
            <thead>
            <tr>
                <th v-bind:colspan="numColumns + 1">
                    <div class="input-group">
                        <input type="text"
                               class="form-control"
                               v-model="sortable.filterKey"
                        />
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
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
            <tr v-for="meat in filteredData(meats)">
                <td>{{ meat.type }}</td>
                <td>{{ meat.variety }}</td>
                <td>{{ meat.code }}</td>
                <td>${{ meat.cost_per_lb.toFixed(2) }}</td>
                <td>
                    <button class="btn btn-primary btn-xs">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
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
        this.loadMeats();
    },
    methods: {
        ...mapActions('meats', [
            'loadMeats',
        ]),
    },
    computed: {
        ...mapState('meats', [
            'collection',
            'show']
        )
    }
}
</script>

<style>

</style>