import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
    [actions.CREATE] ({commit}, targetModel) {
        commit(mutations.SET_TARGET_MODEL, targetModel);
        commit(mutations.CREATE_MODE);
    },

    [actions.CANCEL] ({commit}) {
        commit(mutations.UNSET_TARGET_MODEL);
        commit(mutations.CLEAR_MODE);
    }
};
