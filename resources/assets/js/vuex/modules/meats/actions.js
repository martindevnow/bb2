export const loadMeats = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (! force && state.collection.length)
            resolve(state.collection);

        axios.get('/admin/api/meats')
            .then(response => {
                commit('populateMeatsCollection', response.data);
                resolve(response);
            })
            .catch(error => {
                console.log(error);
                reject(error);
            });
    });

};

export const openMeatCreatorModal = (context) => {
    context.commit('showMeatCreatorModal');
};

export const closeMeatCreatorModal = (context) => {
    context.commit('hideMeatCreatorModal');
    context.commit('disableEditMode');
    context.commit('deselectMeat');
};

export const editMeat = (context, meat) => {
    context.commit('setSelectedMeat', meat);
    context.commit('showMeatCreatorModal');
    context.commit('enableEditMode');
};
