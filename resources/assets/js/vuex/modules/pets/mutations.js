import {loadPetFromData} from "../../../models/Pet";

export const populatePetsCollection = (state, data) => {
    state.collection = data.map(petData => loadPetFromData(petData));
};

export const addToPetsCollection = (state, pet) => {
    state.collection.unshift(loadPetFromData(pet));
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
    state.selected = {};
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const updatePet = (state, payload) => {
    state.collection = state.collection.map(model => {
        if (model.id === payload.id)
            return loadPetFromData(payload);
        return model;
    });
};