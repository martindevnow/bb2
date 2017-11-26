import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
    [actions.FETCH_ALL] ({commit, state}, force = false) {
        return new Promise((resolve, reject) => {
            if (!force && state.collection.length)
                return resolve(state.collection);

            axios.get('/admin/api/users')
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

    [actions.CREATE] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.CREATE_MODE);
    },

    [actions.SAVE] ({commit}, formData) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/users',
                formData
            ).then(response => {
                commit(mutations.ADD_TO_COLLECTION, response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        })
    },

    [actions.EDIT] ({commit}, model) {
        commit(mutations.SELECT, model);
        commit(mutations.EDIT_MODE);
    },

    [actions.UPDATE] ({commit, state}, formData) {
        return new Promise((resolve, reject) => {
            axios.put('/admin/api/users/' + state.selected.id,
                formData
            ).then(response => {
                commit(mutations.UPDATE_IN_COLLECTION, response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        })
    },

    // TODO: Delete

    [actions.CANCEL] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.CLEAR_MODE);
    },


    [actions.ATTACH_ADDRESS] ({commit, state}, address_id) {
        return new Promise((resolve, reject) => {
            axios.put('/admin/api/users/' + state.selected.id + '/attachAddress',
                {address_id: address_id}
            ).then(response => {
                commit(mutations.ATTACH_ADDRESS_TO_USER, response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },
};
