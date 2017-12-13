import { loadMealFromData } from "../../../models/Meal";

export const populateMealsCollection = (state, data) => {
    state.collection = data.map(mealData => loadMealFromData(mealData));
};

export const addToMealsCollection = (state, meal) => {
    state.collection.unshift(loadMealFromData(meal));
};

export const showMealCreatorModal = (state) => {
    state.show.mealCreatorModal = true;
};

export const hideMealCreatorModal = (state) => {
    state.show.mealCreatorModal = false;
};

export const setSelectedMeal = (state, meal) => {
    state.selected = { ...meal };
};

export const deselectMeal = (state) => {
    state.selected = {};
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const updateMeal = (state, payload) => {
    state.collection = state.collection.map(model => {
        if (model.id == payload.id)
            return loadMealFromData(payload)
        return model;
    });
};