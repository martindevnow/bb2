export const populateCouriersCollection = (state, data) => {
    state.couriers = data;
};

export const populateMeatsCollection = (state, data) => {
    state.meats = data;
};

export const populatePlansCollection = (state, data) => {
    state.plans = data;
};

export const populatePetsCollection = (state, data) => {
    state.pets = data;
};

export const addToPetsCollection = (state, pet) => {
    state.pets.unshift(pet);
};

export const addToUsersCollection = (state, user) => {
    state.users.unshift(user);
};

export const populateUsersCollection = (state, data) => {
    state.users = data.map(user => {
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

export const showPetCreatorModal = (state) => {
    state.show.petCreatorModal = true;
};

export const hidePetCreatorModal = (state) => {
    state.show.petCreatorModal = false;
};

export const showUserCreatorModal = (state) => {
    state.show.userCreatorModal = true;
};

export const hideUserCreatorModal = (state) => {
    state.show.userCreatorModal = false;
};



