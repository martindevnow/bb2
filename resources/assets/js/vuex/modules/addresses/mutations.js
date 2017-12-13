export const populateAddressesCollection = (state, data) => {
    state.collection = data;
};

export const addToAddressesCollection = (state, addressData) => {
    state.collection.unshift(addressData);
};

export const showAddressCreatorModal = (state) => {
    state.show.addressCreatorModal = true;
};

export const hideAddressCreatorModal = (state) => {
    state.show.addressCreatorModal = false;
};

export const setSelectedAddress = (state, address) => {
    state.selected = address;
};

export const deselectAddress = (state) => {
    state.selected = null;
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const updateAddress = (state, payload) => {
    state.collection = state.collection.map(model => {
        if (model.id == payload.id)
            return payload;
        return model;
    });
};
