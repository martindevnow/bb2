import {loadMeatFromData} from "../../../models/Meat";

export const populateMeatsCollection = (state, data) => {
    state.collection = data.map(meatData => loadMeatFromData(meatData));
};

export const addToMeatsCollection = (state, meat) => {
    state.collection.unshift(loadMeatFromData(meat));
};

export const showMeatCreatorModal = (state) => {
    state.show.meatCreatorModal = true;
};

export const hideMeatCreatorModal = (state) => {
    state.show.meatCreatorModal = false;
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const setSelectedMeat = (state, meat) => {
    state.selected = meat;
};

export const deselectMeat = (state) => {
    state.selected = null;
};

export const updateMeat = (state, payload) => {
    state.collection = state.collection.map(model => {
        if (model.id === payload.id)
            return loadMeatFromData(payload);
        return model;
    });
};