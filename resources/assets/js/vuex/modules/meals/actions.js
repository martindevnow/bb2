import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
    [actions.CREATE] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.CREATE_MODE);
    },

    [actions.EDIT] ({commit}, model) {
        commit(mutations.SELECT, model);
        commit(mutations.EDIT_MODE);
    },

    [actions.FETCH_ALL] ({commit, state}, force = false) {
        return new Promise((resolve, reject) => {
            if (! force && state.collection.length)
                return resolve(state.collection);

            axios.get('/admin/api/meals')
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

    [actions.SAVE] ({commit}, formData) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/meals',
                formData
            ).then(response => {
                commit(mutations.ADD_TO_COLLECTION, response.data);
                resolve(response);
            }).catch(error => {
                console.log(error);
                reject(error);
            });
        });
    },

    [actions.UPDATE] ({commit, state}, formData) {
        return new Promise((resolve, reject) => {
            axios.patch('/admin/api/meals/' + state.selected.id,
                formData
            ).then(response => {
                commit(mutations.UPDATE, response.data);
                resolve(response);
            }).catch(error => {
                console.log(error);
                reject(error);
            });
        });
    },
};