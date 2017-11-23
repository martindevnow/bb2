import * as actions from './actionTypes';
import * as mutations from './mutationTypes';
import * as noteMutations from './../notes/mutationTypes';

export default {
    [actions.FETCH_ALL] ({commit, state}, force = false) {
        return new Promise((resolve, reject) => {
            if (! force && state.collection.length)
                return resolve(state.collection);

            axios.get('/admin/api/orders')
                .then(response => {
                    commit(mutations.POPULATE_COLLECTION, response.data);
                    resolve(response);
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                });
        });
    },

    [actions.OPEN_PAYMENT_LOGGER] ({commit}, order) {
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_PAYMENT_LOGGER);
    },

    [actions.CLOSE_PAYMENT_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_PAYMENT_LOGGER);
    },

    [actions.OPEN_PACKED_LOGGER] ({commit}, order) {
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_PACKED_LOGGER);
    },

    [actions.CLOSE_PACKED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_PACKED_LOGGER);
    },

    [actions.OPEN_PICKED_LOGGER] ({commit}, order) {
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_PICKED_LOGGER);
    },

    [actions.CLOSE_PICKED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_PICKED_LOGGER);
    },

    [actions.OPEN_SHIPPED_LOGGER] ({commit}, order) {
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_SHIPPED_LOGGER);
    },

    [actions.CLOSE_SHIPPED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_SHIPPED_LOGGER);
    },

    [actions.OPEN_DELIVERED_LOGGER] ({commit}, order) {
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_DELIVERED_LOGGER);
    },

    [actions.CLOSE_DELIVERED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_DELIVERED_LOGGER);
    },

    [actions.OPEN_CANCELLED_LOGGER] ({commit}, order) {
        commit('notes/' + noteMutations.SET_TARGET_MODEL, {model: order, type: 'order'}, { root: true });
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_CANCELLED_LOGGER);
    },

    [actions.CLOSE_CANCELLED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit('notes/' + noteMutations.UNSET_TARGET_MODEL, null, { root: true });
        commit(mutations.HIDE_CANCELLED_LOGGER);
    }
};


