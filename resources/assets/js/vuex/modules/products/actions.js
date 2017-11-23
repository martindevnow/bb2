import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export const loadProducts = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (! force && state.collection.length)
            return resolve(state.collection);

        axios.get('/admin/api/products')
            .then(response => {
                commit('populateProductsCollection', response.data);
                resolve(response);
            })
            .catch(error => {
                console.log(error);
                reject(error);
            });
    });

};

export const openProductCreatorModal = (context) => {
    context.commit('showProductCreatorModal');
};

export const closeProductCreatorModal = (context) => {
    context.commit('hideProductCreatorModal');
    context.commit('disableEditMode');
    context.commit('deselectProduct');
};

export const editProduct = (context, product) => {
    context.commit('setSelectedProduct', product);
    context.commit('showProductCreatorModal');
    context.commit('enableEditMode');
};
