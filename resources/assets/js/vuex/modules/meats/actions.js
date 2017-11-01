export const loadMeats = ({commit, state}, force = false) => {
    if (! force && state.collection.length)
        return;

    axios.get('/admin/api/meats')
        .then(response => commit('populateMeatsCollection', response.data))
        .catch(error => console.log(error));
};

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
