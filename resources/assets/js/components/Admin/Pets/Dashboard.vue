<template>
    <div>
        <table class="table table-bordered table-responsive">
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
                                    @click="openPetCreatorModal()"
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
            <tr v-for="pet in filteredData(collection)"
                :class="{'in-active': getActivePlanCount(pet) == 0 }"
            >
                <td>{{ pet.name }}</td>
                <td>{{ pet.breed }}</td>
                <td>{{ pet.ownerName() }}</td>
                <td>{{ pet.weight }} lb</td>
                <td>{{ pet.activity_level }} %</td>
                <td>{{ pet.birthday }}</td>
                <td>{{ pet.daily_meals }}</td>
                <td>{{ getActivePlanCount(pet) }}</td>
                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="edit(pet)"
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
                            @close="closePetCreatorModal()"
        >
            <p slot="header" v-if="! mode">Add a Pet</p>
            <p slot="header" v-if="mode == 'EDIT'">Edit Pet: {{ selected.name }}</p>
            <admin-pets-creator @saved="closePetCreatorModal()"
                                @updated="closePetCreatorModal()"
                                @cancelled="closePetCreatorModal()"
                                slot="body"
            ></admin-pets-creator>
        </admin-common-modal>
    </div>
</template>

<script>
    import { mapGetters, mapState, mapActions } from 'vuex';
    import isSortable from '../../../mixins/isSortable';
    import * as petActions from "../../../vuex/modules/pets/actionTypes";

    export default {
        mixins: [
            isSortable,
        ],
        data() {
            let columns = [
                'name',
                'breed',
                'ownerName',
                'weight',
                'activity_level',
                'birthday',
                'daily_meals',
                'active_plans',
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
                this.$store.dispatch('pets/' + petActions.FETCH_ALL);
            },
            openPetCreatorModal() {
                this.$store.dispatch('pets/' + petActions.CREATE);
            },
            closePetCreatorModal() {
                this.$store.dispatch('pets/' + petActions.CANCEL);
            },
            edit(model) {
                this.$store.dispatch('pets/' + petActions.EDIT, model)
            },
            getActivePlanCount(pet) {
                return pet.plans.length ? pet.plans.filter((plan) => plan.active == 1).length : 0;
            },
        },
        computed: {
            ...mapState( 'pets', [
                'collection',
                'show',
                'selected',
                'mode',
            ])
        }
    }
</script>

<style scoped>
.in-active {
    background-color: orange;
}
</style>