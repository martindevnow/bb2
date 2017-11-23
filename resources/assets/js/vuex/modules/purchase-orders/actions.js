import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export const loadPurchaseOrders = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (! force && state.collection.length)
            return resolve(state.collection);

        axios.get('/admin/api/purchase-orders')
            .then(response => {
                commit('populatePurchaseOrdersCollection', response.data);
                resolve(response);
            })
            .catch(error => {
                console.log(error);
                reject(error);
            });
    });

};

export const openOrderedModal = (context, purchaseOrder) => {
    context.commit('setSelectedPurchaseOrder', purchaseOrder);
    context.commit('showOrderedModal');
};

export const closeOrderedModal = (context) => {
    context.commit('hideOrderedModal');
};

export const openReceivedModal = (context, purchaseOrder) => {
    context.commit('setSelectedPurchaseOrder', purchaseOrder);
    context.commit('showReceivedModal');
};

export const closeReceivedModal = (context) => {
    context.commit('hideReceivedModal');
};