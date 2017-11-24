import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
    [actions.FETCH_ALL] ({commit, state}, force = false) {
        return new Promise((resolve, reject) => {
            if (! force && state.collection.length)
                return resolve(state.collection);

            axios.get('/admin/api/addresses')
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
            axios.post('/admin/api/addresses',
                formData
            ).then(response => {
                commit(mutations.ADD_TO_COLLECTION, formData);
                resolve(response);
            }).catch(error => {
                console.log(error);
                reject(error);
            });
        });
    },

    [actions.EDIT] ({commit}, model) {
        commit(mutations.SELECT, model);
        commit(mutations.EDIT_MODE);
    },

    [actions.UPDATE] ({commit, state}, formData) {
        return new Promise((resolve, reject) => {
            axios.patch('/admin/api/addresses/' + state.selected.id,
                formData
            ).then(response => {
                commit(mutations.UPDATE_IN_COLLECTION, formData)
                resolve(response);
            }).catch(error => {
                console.log(error);
                reject(error);
            });
        });
    },

    [actions.DELETE] ({commit}, model) {
        return new Promise((resolve, reject) => {
            axios.delete('/admin/api/addresses/' + model.id).then(response => {
                commit('users/removeAddress', model, {root: true});
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    [actions.CANCEL] ({commit}) {
        commit(mutations.CLEAR_MODE);
    },
};
