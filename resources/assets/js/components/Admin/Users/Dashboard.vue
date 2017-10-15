<template>
    <div>
        <table class="table table-bordered table-responsive table-striped">
            <thead>
            <tr>
                <th v-bind:colspan="numColumns + 1">
                    <div class="row">
                        <div class="col-sm-6">
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
                        <div class="col-sm-6">
                            <button class="btn btn-primary"
                                    @click="openUserCreatorModal()"
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
            <tr v-for="user in filteredData(users)">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.pets }}</td>
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

        <admin-common-modal v-if="show.userCreatorModal"
                            @close="closeCreatorModal()"
        >
            <p slot="header">Add a User</p>
            <admin-users-creator @close="$emit('close')"
                               slot="body"
            ></admin-users-creator>
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
                'name',
                'email',
                'pets',
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
            this.loadUsers();
        },
        methods: {
            ...mapActions([
                'loadUsers',
                'openUserCreatorModal',
                'closeUserCreatorModal',
            ]),
        },
        computed: {
            ...mapState(['users', 'show'])
        }
    }
</script>

<style>

</style>