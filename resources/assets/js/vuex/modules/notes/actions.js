import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
    [actions.CREATE] ({commit}, targetModel) {
        commit(mutations.SET_TARGET_MODEL, targetModel);
        commit(mutations.CREATE_MODE);
    },

    [actions.SAVE] ({commit}, formData) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/notes',
                formData
            ).then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    [actions.DELETE] ({commit}, id) {
        return new Promise((resolve, reject) => {
            axios.delete('/admin/api/notes/' + id)
            .then(response => {
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    [actions.CANCEL] ({commit}) {
        commit(mutations.UNSET_TARGET_MODEL);
        commit(mutations.CLEAR_MODE);
    }
};
