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

export const loadToppings = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (! force && state.collection.length)
            return resolve(state.collection);

        axios.get('/admin/api/toppings')
            .then(response => {
                commit('populateToppingsCollection', response.data);
                resolve(response);
            })
            .catch(error => {
                console.log(error);
                reject(error);
            });
    });

};