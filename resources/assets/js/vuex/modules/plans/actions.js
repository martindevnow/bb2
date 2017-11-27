import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
    [actions.FETCH_ALL] ({commit, state}, force = false) {
        return new Promise((resolve, reject) => {
            if (!force && state.collection.length)
                return resolve(state.collection);

            axios.get('/admin/api/plans')
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
            axios.post('/admin/api/plans',
                formData
            ).then(response => {
                commit(mutations.ADD_TO_COLLECTION, response.data);
                resolve(response)
            }).catch(error => {
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
            axios.patch('/admin/api/plans/' + state.selected.id,
                formData
            ).then(response => {
                commit(mutations.UPDATE_IN_COLLECTION, response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    [actions.CANCEL] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.CLEAR_MODE);
    },

    [actions.OPEN_MEAL_REPLACEMENT_CREATOR] ({commit}, model) {
        commit(mutations.SELECT, model);
        commit(mutations.SHOW_MEAL_REPLACEMENT_CREATOR);
    },

    [actions.CLOSE_MEAL_REPLACEMENT_CREATOR] ({commit}) {
        commit(mutations.HIDE_MEAL_REPLACEMENT_CREATOR);
        commit(mutations.DESELECT);
    },

    [actions.SAVE_MEAL_REPLACEMENT] ({commit, state}, formData) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/plans/' + state.selected.id + '/replaceMeal',
                formData
            ).then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    [actions.DELETE_MEAL_REPLACEMENT] ({commit}, mr_id) {
        return new Promise((resolve, reject) => {
            axios.delete('/admin/api/mealReplacements/' + mr_id
            ).then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },
};