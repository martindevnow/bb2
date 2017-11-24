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

    [actions.EDIT] ({commit}, model) {
        commit(mutations.SELECT, model);
        commit(mutations.EDIT_MODE);
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
};