<template>
    <form @keydown="errors.clear($event.target.name)"
          @submit.prevent=""
    >

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('name') }"
                >
                    <label for="name">name</label>
                    <input type="text"
                           class="form-control"
                           id="name"
                           name="name"
                           v-model="form.name"
                    >
                    <span class="help-block">{{ errors.get('name') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('description') }"
                >
                    <label for="description">description</label>
                    <input type="text"
                           class="form-control"
                           id="description"
                           name="description"
                           v-model="form.description"
                    >
                    <span class="help-block">{{ errors.get('description') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('description_long') }"
                >
                    <label for="description_long">description_long</label>
                    <input type="text"
                           class="form-control"
                           id="description_long"
                           name="description_long"
                           v-model="form.description_long"
                    >
                    <span class="help-block">{{ errors.get('description_long') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('size') }"
                >
                    <label for="size">size</label>
                    <input type="text"
                           class="form-control"
                           id="size"
                           name="size"
                           v-model="form.size"
                    >
                    <span class="help-block">{{ errors.get('size') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('sku') }"
                >
                    <label for="sku">sku</label>
                    <input type="text"
                           class="form-control"
                           id="sku"
                           name="sku"
                           v-model="form.sku"
                    >
                    <span class="help-block">{{ errors.get('sku') }}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('price') }"
                >
                    <label for="price">price</label>
                    <input type="text"
                           class="form-control"
                           id="price"
                           name="price"
                           v-model="form.price"
                    >
                    <span class="help-block">{{ errors.get('price') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('ingredients') }"
                >
                    <label for="ingredients">ingredients</label>
                    <input type="text"
                           class="form-control"
                           id="ingredients"
                           name="ingredients"
                           v-model="form.ingredients"
                    >
                    <span class="help-block">{{ errors.get('ingredients') }}</span>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group"
                     :class="{ 'has-error': errors.has('active') }"
                >
                    <label>Status</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   class="checkbox style-0"
                                   name="active"
                                   id="active"
                                   v-model="form.active">
                            <span>Active</span>
                        </label>
                    </div>
                    <span class="help-block">{{ errors.get('active') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-success btn-block"
                        :disabled="errors.any()"
                        @click="save()"
                        v-if="! mode"
                >
                    Save
                </button>
                <button class="btn btn-primary btn-block"
                        :disabled="errors.any()"
                        @click="update()"
                        v-if="mode == 'EDIT'"
                >
                    Update
                </button>
            </div>
            <div class="col-sm-6">
                <label>&nbsp;</label>
                <button class="btn btn-default btn-block"
                        @click="$emit('cancelled')"
                >
                    Cancel
                </button>
            </div>
        </div>


    </form>
</template>

<script>
import hasErrors from '../../../mixins/hasErrors';
import Form from '../../../models/Form';
import { mapGetters, mapState, mapActions, mapMutations } from 'vuex';
import moment from 'moment';

export default {
    mixins: [
        hasErrors
    ],
    data() {
        return {
            form: {
                name: '',
                description: '',
                description_long: '',
                size: '',
                sku: '',
                ingredients: '',
                price: '',
                active: false,
            },
        };
    },
    methods: {
        ...mapActions('products', [
            'editProduct',
        ]),
        ...mapMutations('products', [
            'addToProductsCollection',
            'updateProduct',
        ]),
        ...mapActions('products', [
            'loadProducts',
        ]),
        ...mapActions('toppings', [
            'loadToppings',
        ]),
        populateFormFromProduct(product) {
            this.form.name = product.name;
            this.form.description = product.description;
            this.form.description_long = product.description_long;
            this.form.size = product.size;
            this.form.sku = product.sku;
            this.form.ingredients = product.ingredients;
            this.form.price = product.price;
            this.form.active = product.active;
        },
        save() {
            let vm = this;
            return axios.post('/admin/api/products', {
                ...this.form,
            }).then(response => {
                vm.addToProductsCollection(response.data);
                vm.$emit('saved');
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
        update() {
            let vm = this;

            return axios.patch('/admin/api/products/' + this.selected.id, this.form
            ).then(response => {
                vm.updateProduct(response.data);
                vm.$emit('saved');
            }).catch(error => {
                vm.errors.record(error.response.data.errors);
            });
        },
    },
    computed: {
        ...mapState('products', ['show', 'selected', 'mode', 'collection']),
    },
    mounted() {
        this.loadProducts();
        this.loadToppings();
        if (this.mode == 'EDIT') {
            this.populateFormFromProduct(this.selected);
        }
    },
    watch: {
        selected(newSelected) {
            this.populateFormFromProduct(newSelected);
        }
    }
}
</script>

<style>

</style>