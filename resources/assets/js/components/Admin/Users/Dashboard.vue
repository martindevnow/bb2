<template>
    <div>
        <admin-topping-selector v-model="toppings[0]"></admin-topping-selector>
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
            <tr v-for="user in filteredData(collection)">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.getPets() }}</td>
                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="editUser(user)"
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

        <admin-common-modal v-if="show.userCreatorModal"
                            @close="closeUserCreatorModal()"
        >
            <p slot="header" v-if="! mode">Add a User</p>
            <p slot="header" v-if="mode == 'EDIT'">Edit User: {{ selected.name }}</p>
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
                sortOrders: sortOrders,
                toppings: [],
            }
        },
        mounted() {
            this.loadUsers();
        },
        methods: {
            ...mapActions('users', [
                'loadUsers',
                'openUserCreatorModal',
                'closeUserCreatorModal',
                'editUser',
            ]),
            log(message) {
                console.log(message);
            }
        },
        computed: {
            ...mapState('users', [
                'collection',
                'show',
                'mode',
                'selected',
            ])
        }
    }
</script>

<style>

</style>