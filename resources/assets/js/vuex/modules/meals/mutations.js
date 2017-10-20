export const populateMealsCollection = (state, data) => {
    state.collection = data;
};

export const addToMealCollection = (state, meal) => {
    console.log(meal);
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
