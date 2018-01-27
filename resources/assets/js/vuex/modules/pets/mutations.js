import {loadPetFromData} from "../../../models/Pet";
import * as mutations from './mutationTypes';

export default {
    [mutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data.map(modelData => loadPetFromData(modelData));
    },

    [mutations.ADD_TO_COLLECTION] (state, modelData) {
        state.collection.unshift(loadPetFromData(modelData));
    },

    [mutations.CREATE_MODE] (state) {
        state.show.creator = true;
        state.mode = null;
    },

    [mutations.EDIT_MODE] (state) {
        state.show.creator = true;
        state.mode = 'EDIT';
    },

    [mutations.CLEAR_MODE] (state) {
        state.show.creator = false;
        state.mode = null;
    },

    [mutations.SELECT] (state, model) {
        state.selected = model;
    },

    [mutations.DESELECT] (state) {
        state.selected = null;
    },

    [mutations.UPDATE_IN_COLLECTION] (state, payload) {
        state.collection = state.collection.map(model => {
            if (model.id === payload.id)
                return loadPetFromData(payload);
            return model;
        });
    },
};
