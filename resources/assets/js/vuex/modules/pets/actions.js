export const openPetCreatorModal = (context) => {
    context.commit('showPetCreatorModal');
};

export const closePetCreatorModal = (context) => {
    context.commit('hidePetCreatorModal');
};

export const loadPets = (context) => {
    axios.get('/admin/api/pets')
        .then(response => context.commit('populatePetsCollection', response.data))
        .catch(error => console.log(error));
};