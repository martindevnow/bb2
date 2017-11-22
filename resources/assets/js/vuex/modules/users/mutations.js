import {loadUserFromData} from "../../../models/User";
import * as mutations from './mutationTypes';

export default {
    [mutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data.map(modelData => loadUserFromData(modelData));
    },

    [mutations.ADD_TO_COLLECTION] (state, modelData) {
        console.log('modelData');
        console.log(modelData);
        state.collection.unshift(loadUserFromData(modelData));
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
                return loadUserFromData(payload);
            return model;
        });
    },

    [mutations.ATTACH_ADDRESS] (state, payload) {
        console.log('payload');
        console.log(payload);

        state.collection = state.collection.map(model => {
            if (model.id === state.selected.id) {
                model.addresses = [ ...model.addresses, payload ];
            }
            return model;
        });
    },

    [mutations.REMOVE_ADDRESS] (state, payload) {
        state.collection.map((user) => {
            let addresses = user.addresses.filter((address) => {
                if (address.id !== payload.id)
                    return true;

            });
            user.addresses = [...addresses];
            return user;
        });
    }
};
