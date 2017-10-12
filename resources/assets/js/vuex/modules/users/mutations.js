export const populateUsersCollection = (state, data) => {
    state.collection = data;
};

export const addToUsersCollection = (state, user) => {
    state.collection.unshift(user);
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
    console.log(payload.pets);
    let pets = {...payload.pets};
    let user = {...payload, pets};
    state.collection = state.collection.filter(model => model.id !== user.id);
    console.log(3);
    state.collection.unshift(user);
    console.log(4);
};