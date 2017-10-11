export const populatePetsCollection = (state, data) => {
    state.collection = data;
};

export const addToPetsCollection = (state, pet) => {
    console.log(pet);
    state.collection.unshift(pet);
};

export const showPetCreatorModal = (state) => {
    state.show.petCreatorModal = true;
};

export const hidePetCreatorModal = (state) => {
    state.show.petCreatorModal = false;
};