import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export const openPetCreatorModal = (context) => {
    context.commit('showPetCreatorModal');
};

export const closePetCreatorModal = (context) => {
    context.commit('hidePetCreatorModal');
    context.commit('deselectPet');
    context.commit('disableEditMode');
};

export const loadPets = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (! force && state.collection.length)
            return resolve(state.collection);

        axios.get('/admin/api/pets')
            .then(response => {
                commit('populatePetsCollection', response.data);
                resolve(response);
            })
            .catch(error => {
                console.log(error);
                reject(error);
            });
    });
};

export const editPet = (context, pet) => {
    context.commit('setSelectedPet', pet);
    context.commit('showPetCreatorModal');
    context.commit('enableEditMode');
};