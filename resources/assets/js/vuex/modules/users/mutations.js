export const populateUsersCollection = (state, data) => {
    state.collection = data.map(user => {
        if (! user.pets) {
            return user;
        }
        let pets = user.pets.reduce(function(carry, pet) {
            if (carry == '')
                return pet.name;
            return carry + ", " + pet.name
        }, '');
        return {...user, pets};
    });
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
    state.collection = state.collection.filter(model => model.id !== payload.id);
    state.collection.unshift(payload);
};