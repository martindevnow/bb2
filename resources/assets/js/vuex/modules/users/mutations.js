import {loadUserFromData} from "../../../models/User";

export const populateUsersCollection = (state, data) => {
    state.collection = data.map(userData => loadUserFromData(userData));
};

export const addToUsersCollection = (state, userData) => {
    state.collection.unshift(loadUserFromData(userData));
};

export const showUserCreatorModal = (state) => {
    state.show.userCreatorModal = true;
};

export const hideUserCreatorModal = (state) => {
    state.show.userCreatorModal = false;
};

export const setSelectedUser = (state, user) => {
    state.selected = user;
};

export const deselectUser = (state) => {
    state.selected = null;
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const updateUser = (state, payload) => {
    state.collection = state.collection.map(model => {
        if (model.id == payload.id)
            return loadUserFromData(payload);
        return model;
    });
};

export const attachAddressToUser = (state, payload) => {
    console.log('payload');
    console.log(payload);

    state.collection = state.collection.map(model => {
        if (model.id === state.selected.id) {
            model.addresses = [ ...model.addresses, payload ];
        }
        return model;
    });
};

export const removeAddress = (state, payload) => {
    state.collection.map((user) => {
        let addresses = user.addresses.filter((address) => {
            if (address.id !== payload.id)
                return true;

        });
        user.addresses = [...addresses];
        return user;
    });
};