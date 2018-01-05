import {loadProductFromData} from "../../../models/Product";

export const populateProductsCollection = (state, data) => {
    state.collection = data.map(productData => loadProductFromData(productData));
};

export const addToProductsCollection = (state, product) => {
    state.collection.unshift(loadProductFromData(product));
};

export const showProductCreatorModal = (state) => {
    state.show.productCreatorModal = true;
};

export const hideProductCreatorModal = (state) => {
    state.show.productCreatorModal = false;
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const setSelectedProduct = (state, product) => {
    state.selected = product;
};

export const deselectProduct = (state) => {
    state.selected = {};
};

export const updateProduct = (state, payload) => {
    console.log('updating the model in the collection of products.');
    state.collection = state.collection.map(model => {
        if (model.id === payload.id)
            return loadProductFromData(payload);
        return model;
    });
};