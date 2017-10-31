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
            <tr v-for="pet in filteredData(collection)">
                <td>{{ pet.name }}</td>
                <td>{{ pet.breed }}</td>
                <td>{{ pet.ownerName() }}</td>
                <td>{{ pet.weight }} lb</td>
                <td>{{ pet.activity_level }} %</td>
                <td>{{ pet.birthday }}</td>
                <td>{{ pet.daily_meals }}</td>
                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="editPet(pet)"
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

        <admin-common-modal v-if="show.petCreatorModal"
                            @close="closePetCreatorModal()"
        >
            <p slot="header" v-if="! mode">Add a Pet</p>
            <p slot="header" v-if="mode == 'EDIT'">Edit Pet: {{ selected.name }}</p>
            <admin-pets-creator @close="$emit('close')"
                               slot="body"
            ></admin-pets-creator>
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
                'breed',
                'ownerName',
                'weight',
                'activity_level',
                'birthday',
                'daily_meals',
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
            this.loadPets();
        },
        methods: {
            ...mapActions('pets', [
                'loadPets',
                'openPetCreatorModal',
                'closePetCreatorModal',
                'editPet',
            ]),
        },
        computed: {
            ...mapState('pets', [
                'collection',
                'show',
                'selected',
                'mode',
            ])
        }
    }
</script>

<style>

</style>