export const openMeatCreatorModal = (context) => {
    context.commit('showMeatCreatorModal');
};

export const closeMeatCreatorModal = (context) => {
    context.commit('hideMeatCreatorModal');
};

export const editMeat = (context, meat) => {
    context.commit('setSelectedMeat', meat);
    context.commit('showMeatCreatorModal');
    context.commit('enableEditMode');
};

export const loadMeats = (context) => {
    axios.get('/admin/api/meats')
        .then(response => context.commit('populateMeatsCollection', response.data))
        .catch(error => console.log(error));
};