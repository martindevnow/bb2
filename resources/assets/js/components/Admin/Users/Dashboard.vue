<template>
    <div>
        <div class="" v-if="show.userCreatorModal">
            <div class="row">

                <div class="col-sm-12">
                    <h1>User</h1>
                    <admin-users-creator @saved="closeCreator()"
                                         @cancelled="closeCreator()"
                                         slot="body"
                                         :showAddresses="mode == 'EDIT'"
                    ></admin-users-creator>
                </div>
            </div>
        </div>


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
            <tr v-for="user in filteredData(collection)">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.getPets() }}</td>
                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="edit(user)"
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

        <admin-common-modal v-if="show.userCreatorModal && false"
                            @close="closeCreator()"
        >
            <p slot="header" v-if="! mode">Add a User</p>
            <p slot="header" v-if="mode == 'EDIT'">Edit User: {{ selected.name }}</p>
            <admin-users-creator @saved="closeCreator()"
                                 @cancelled="closeCreator()"
                                 slot="body"
                                 :showAddresses="mode == 'EDIT'"
            ></admin-users-creator>
        </admin-common-modal>
    </div>
</template>

<script>
    import { mapGetters, mapState, mapActions } from 'vuex';
    import isSortable from '../../../mixins/isSortable';
    import * as actions from '../../../vuex/modules/users/userActions';
    import * as mutations from '../../../vuex/modules/users/userMutations';

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
            this.$store.dispatch('users/' + actions.FETCH_ALL);
        },
        methods: {
            create() {
                this.$store.dispatch('users/' + actions.CREATE);
            },
            closeCreator() {
                this.$store.commit('users/' + mutations.CLEAR_MODE)
            },
            edit(model) {
                this.$store.dispatch('users/' + actions.EDIT, model);
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