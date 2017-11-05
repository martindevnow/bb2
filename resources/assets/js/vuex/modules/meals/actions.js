export const openMealCreatorModal = (context) => {
    context.commit('showMealCreatorModal');
};

export const closeMealCreatorModal = (context) => {
    context.commit('hideMealCreatorModal');
    context.commit('disableEditMode');
    context.commit('deselectMeal');
};

export const editMeal = (context, meal) => {
    context.commit('setSelectedMeal', meal);
    context.commit('showMealCreatorModal');
    context.commit('enableEditMode');
};

export const loadMeals = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (! force && state.collection.length)
            resolve(state.collection);

        axios.get('/admin/api/meals')
        .then(response => {
            commit('populateMealsCollection', response.data);
            resolve(response);
        })
        .catch(error => {
            console.log(error);
            reject(error);
        });
    });
};