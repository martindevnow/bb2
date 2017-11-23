import * as mutations from './mutationTypes';

export default {
    [mutations.CREATE_MODE] (state) {
        state.show.creator = true;
    },

    [mutations.CLEAR_MODE] (state) {
        state.show.creator = false;
    },

    [mutations.SET_TARGET_MODEL] (state, targetModel) {
        state.targeted = targetModel;
    },

    [mutations.UNSET_TARGET_MODEL] (state) {
        state.targeted = {};
    },
};


