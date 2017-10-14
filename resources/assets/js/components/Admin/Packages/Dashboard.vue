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
                    <button class="btn btn-primary"
                            @click="openPackageCreatorModal()"
                    >
                        New
                    </button>
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
                <td>{{ package.code }}</td>
                <td>{{ package.label }}</td>
                <td>{{ package.active }}</td>
                <td>{{ package.public }}</td>
                <td>{{ package.customization }}</td>
                <td>{{ package.level }}</td>
                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="editPackage(package)"
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

        <admin-common-modal v-if="show.packageCreatorModal"
                            @close="closePackageCreatorModal()"
        >
            <p slot="header" v-if="! mode">Add a Package</p>
            <p slot="header" v-if="mode == 'EDIT'">Edit Package: {{ selected.label }}</p>
            <admin-packages-creator @close="$emit('close')"
                               slot="body"
            ></admin-packages-creator>
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
                'code',
                'label',
                'active',
                'public',
                'customization',
                'level',
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
            this.loadPackages();
        },
        methods: {
            ...mapActions('packages', [
                'loadPackages',
                'openPackageCreatorModal',
                'closePackageCreatorModal',
                'editPackage',
            ]),
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