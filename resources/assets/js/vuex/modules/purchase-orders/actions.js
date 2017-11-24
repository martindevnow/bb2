import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
    [actions.FETCH_ALL] ({commit, state}, force = false) {
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
    },

    [actions.CREATE] ({commit}, model) {
        commit(mutations.SELECT, model);
        commit(mutations.CREATE_MODE);
    },

    [actions.CANCEL] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.CLEAR_MODE);
    },


    [actions.OPEN_ORDERED_MODAL] ({commit}, model) {
        commit(mutations.SELECT, model);
        commit(mutations.SHOW_ORDERED_MODAL);
    },

    [actions.CLOSE_ORDERED_MODAL] ({commit}) {
        commit(mutations.HIDE_ORDERED_MODAL);
        commit(mutations.DESELECT);
    },

    [actions.OPEN_RECEIVED_MODAL] ({commit}, model) {
        commit(mutations.SELECT, model);
        commit(mutations.SHOW_RECEIVED_MODAL);
    },

    [actions.CLOSE_RECEIVED_MODAL] ({commit}) {
        commit(mutations.HIDE_RECEIVED_MODAL);
        commit(mutations.DESELECT);
    },

};

export const openReceivedModal = (context, purchaseOrder) => {
    context.commit('setSelectedPurchaseOrder', purchaseOrder);
    context.commit('showReceivedModal');
};

export const closeReceivedModal = (context) => {
    context.commit('hideReceivedModal');
};