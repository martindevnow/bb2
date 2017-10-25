export const openMealCreatorModal = (context) => {
    context.commit('showMealCreatorModal');
};

export const closeMealCreatorModal = (context) => {
    context.commit('hideMealCreatorModal');
};

export const editMeal = (context, meal) => {
    context.commit('setSelectedMeal', meal);
    context.commit('showMealCreatorModal');
    context.commit('enableEditMode');
};

export const loadMeals = (context) => {
    axios.get('/admin/api/meals')
        .then(response => context.commit('populateMealsCollection', response.data))
        .catch(error => console.log(error));
};