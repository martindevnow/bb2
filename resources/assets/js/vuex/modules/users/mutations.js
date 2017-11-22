import {loadUserFromData} from "../../../models/User";
import * as userMutations from './userMutations';

export default {
    [userMutations.POPULATE_COLLECTION]: (state, data) => {
        state.collection = data.map(userData => loadUserFromData(userData));
    },

    [userMutations.ADD_TO_COLLECTION]: (state, userData) => {
        console.log('userData');
        console.log(userData);
        state.collection.unshift(loadUserFromData(userData));
    },

    [userMutations.CREATE_MODE]: (state) => {
        state.show.userCreatorModal = true;
        state.mode = null;
    },

    [userMutations.EDIT_MODE]: (state) => {
        state.show.userCreatorModal = true;
        state.mode = 'EDIT';
    },

    [userMutations.CLEAR_MODE]: (state) => {
        state.show.userCreatorModal = false;
        state.mode = null;
    },

    [userMutations.SELECT]: (state, user) => {
        state.selected = user;
    },

    [userMutations.DESELECT]: (state) => {
        state.selected = null;
    },

    [userMutations.UPDATE]: (state, payload) => {
        state.collection = state.collection.map(model => {
            if (model.id === payload.id)
                return loadUserFromData(payload);
            return model;
        });
    },

    [userMutations.ATTACH_ADDRESS]: (state, payload) => {
        console.log('payload');
        console.log(payload);

        state.collection = state.collection.map(model => {
            if (model.id === state.selected.id) {
                model.addresses = [ ...model.addresses, payload ];
            }
            return model;
        });
    },

    [userMutations.REMOVE_ADDRESS]: (state, payload) => {
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
