import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
    [actions.FETCH_ALL] ({commit, state}, force = false) {
        return new Promise((resolve, reject) => {
            if (!force && state.collection.length)
                return resolve(state.collection);

            axios.get('/admin/api/purchase-orders')
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

    [actions.OPEN_ORDERED_LOGGER] ({commit}, model) {
        commit(mutations.SELECT, model);
        commit(mutations.SHOW_ORDERED_LOGGER);
    },

    [actions.CLOSE_ORDERED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_ORDERED_LOGGER);
    },

    [actions.OPEN_RECEIVED_LOGGER] ({commit}, model) {
        commit(mutations.SELECT, model);
        commit(mutations.SHOW_RECEIVED_LOGGER);
    },

    [actions.CLOSE_RECEIVED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_RECEIVED_LOGGER);
    },
};