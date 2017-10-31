export const openToppingCreatorModal = (context) => {
    context.commit('showToppingCreatorModal');
};

export const closeToppingCreatorModal = (context) => {
    context.commit('hideToppingCreatorModal');
};

export const editTopping = (context, topping) => {
    context.commit('setSelectedTopping', topping);
    context.commit('showToppingCreatorModal');
    context.commit('enableEditMode');
};

export const loadToppings = (context) => {
    axios.get('/admin/api/toppings')
        .then(response => context.commit('populateToppingsCollection', response.data))
        .catch(error => console.log(error));
};