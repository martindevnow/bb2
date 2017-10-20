import Meat from '../../../models/Meat';

export const populateMeatsCollection = (state, data) => {
    state.collection = data;
    //     .map(meatData => {
    //     return new Meat(meatData);
    // });
};

export const addToMeatCollection = (state, meat) => {
    state.collection.unshift(meat);
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
