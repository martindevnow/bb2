// import Topping from '../../../models/Topping';

export const populateToppingsCollection = (state, data) => {
    state.collection = data;
    //     .map(toppingData => {
    //     return new Topping(toppingData);
    // });
};

export const addToToppingCollection = (state, topping) => {
    state.collection.unshift(topping);
};

export const showToppingCreatorModal = (state) => {
    state.show.toppingCreatorModal = true;
};

export const hideToppingCreatorModal = (state) => {
    state.show.toppingCreatorModal = false;
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const setSelectedTopping = (state, topping) => {
    state.selected = topping;
};
