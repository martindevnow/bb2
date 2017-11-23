import * as addressActions from './actionTypes';
import * as addressMutations from './mutationTypes';

export default {
    [addressActions.CREATE] ({commit}) {
        commit(addressMutations.DESELECT);
        commit(addressMutations.CREATE_MODE);
    },

    [addressActions.EDIT] ({commit}, model) {
        commit(addressMutations.SELECT, model);
        commit(addressMutations.EDIT_MODE);
    },

    [addressActions.FETCH_ALL] ({commit, state}, force = false) {
        return new Promise((resolve, reject) => {
            if (! force && state.collection.length)
                return resolve(state.collection);

            axios.get('/admin/api/addresses')
                .then(response => {
                    commit(addressMutations.POPULATE_COLLECTION, response.data);
                    resolve(response);
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                });
        });
    },

    [addressActions.SAVE] ({commit}, formData) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/addresses', {
                formData
            }).then(response => {
                commit(addressMutations.ADD_TO_COLLECTION, formData);
                resolve(response);
            }).catch(error => {
                console.log(error);
                reject(error);
            });
        });
    },

    [addressActions.UPDATE] ({commit, state}, formData) {
        return new Promise((resolve, reject) => {
            axios.patch('/admin/api/addresses/' + state.selected.id, {
                formData
            }).then(response => {
                commit(addressMutations.UPDATE, formData)
                resolve(response);
            }).catch(error => {
                console.log(error);
                reject(error);
            });
        });
    },

    [addressActions.DELETE] ({commit}, model) {
        return new Promise((resolve, reject) => {
            axios.delete('/admin/api/addresses/' + model.id).then(response => {
                commit('users/removeAddress', model, {root: true});
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },
};
