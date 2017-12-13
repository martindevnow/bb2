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
                                    @click="openProductCreatorModal()"
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
            <tr v-for="product in filteredData(collection)">
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.description_long }}</td>
                <td>{{ product.size }}</td>
                <td>{{ product.sku }}</td>
                <td>${{ product.price.toFixed(2) }}</td>
                <td>{{ product.ingredients }}</td>
                <td>
                    <button class="btn btn-primary btn-xs"
                            @click="editProduct(product)"
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

        <admin-common-modal v-if="show.productCreatorModal"
                            @close="closeProductCreatorModal()"
        >
            <p slot="header" v-if="! mode">Add a Product</p>
            <p slot="header" v-if="mode == 'EDIT'">Edit Product: {{ selected.type }} {{ selected.variety }}</p>
            <admin-products-creator @saved="closeProductCreatorModal()"
                                 @cancelled="closeProductCreatorModal()"
                                 slot="body"
            ></admin-products-creator>
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
            'description',
            'description_long',
            'size',
            'sku',
            'price',
            'ingredients',
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
        this.loadProducts();
    },
    methods: {
        ...mapActions('products', [
            'loadProducts',
            'openProductCreatorModal',
            'closeProductCreatorModal',
            'editProduct',
        ]),
    },
    computed: {
        ...mapState('products', [
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