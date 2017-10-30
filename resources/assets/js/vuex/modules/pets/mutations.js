import {loadPetFromData} from "../../../models/Pet";

export const populatePetsCollection = (state, data) => {
    state.collection = data.map(petData => loadPetFromData(petData));
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

export const setSelectedPet = (state, pet) => {
    state.selected = pet;
};

export const deselectPet = (state) => {
    state.selected = null;
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const updatePet = (state, payload) => {
    state.collection = state.collection.filter(model => model.id !== payload.id);
    state.collection.unshift(loadPetFromData(payload));
};