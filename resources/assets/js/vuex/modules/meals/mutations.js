import {loadMealFromData} from "../../../models/Meal";

export const populateMealsCollection = (state, data) => {
    state.collection = data.map(mealData => loadMealFromData(mealData));
};

export const addToMealCollection = (state, meal) => {
    state.collection.unshift(meal);
};

export const showMealCreatorModal = (state) => {
    state.show.mealCreatorModal = true;
};

export const hideMealCreatorModal = (state) => {
    state.show.mealCreatorModal = false;
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const setSelectedMeal = (state, meal) => {
    state.selected = meal;
};
