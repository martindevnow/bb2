import * as actions from './actionTypes';
import * as addressMutations from './mutationTypes';

export default {
    [addressMutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data.map(modelData => (modelData));
    },

    [addressMutations.ADD_TO_COLLECTION] (state, modelData) {
        state.collection.unshift((modelData));
    },

    [addressMutations.CREATE_MODE] (state) {
        state.show.creator = true;
        state.mode = null;
    },

    [addressMutations.EDIT_MODE] (state) {
        state.show.creator = true;
        state.mode = 'EDIT';
    },

    [addressMutations.CLEAR_MODE] (state) {
        state.show.creator = false;
        state.mode = null;
    },

    [addressMutations.SELECT] (state, model) {
        state.selected = model;
    },

    [addressMutations.DESELECT] (state) {
        state.selected = null;
    },

    [addressMutations.UPDATE] (state, payload) {
        state.collection = state.collection.map(model => {
            if (model.id === payload.id)
                return { ...payload};
            return model;
        });
    },
};
