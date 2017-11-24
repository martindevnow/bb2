import {loadPkgFromData} from "../../../models/Package";
import * as mutations from './mutationTypes';

export default {
    [mutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data.map(pkgData => loadPkgFromData(pkgData));
    },

    [mutations.ADD_TO_COLLECTION] (state, pkg) {
        state.collection.unshift(pkg);
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
                return loadPkgFromData(payload);
            return model;
        });
    },

    [mutations.SHOW_MEAL_PLAN_EDITOR] (state) {
        state.show.mealPlanEditor = true;
    },

    [mutations.HIDE_MEAL_PLAN_EDITOR] (state) {
        state.show.mealPlanEditor = false;
    }
};