export const openPetCreatorModal = (context) => {
    context.commit('showPetCreatorModal');
};

export const closePetCreatorModal = (context) => {
    context.commit('hidePetCreatorModal');
};

export const loadPets = ({commit, state}, force = false) => {
    if (! force && state.collection.length)
        return;

    axios.get('/admin/api/pets')
        .then(response => commit('populatePetsCollection', response.data))
        .catch(error => console.log(error));
};