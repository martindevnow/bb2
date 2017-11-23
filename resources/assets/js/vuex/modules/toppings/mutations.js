import {loadToppingFromData} from "../../../models/Topping";
import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
    [mutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data.map(modelData => loadToppingFromData(modelData));
    },

    [mutations.ADD_TO_COLLECTION] (state, modelData) {
        state.collection.ushift(loadToppingFromData(modelData));
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

    [mutations.UPDATE] (state, payload) {
        state.collection = state.collection.map(model => {
            if (model.id === payload.id)
                return loadToppingFromData(payload);
            return model;
        });
    },
};

