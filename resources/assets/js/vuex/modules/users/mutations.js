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