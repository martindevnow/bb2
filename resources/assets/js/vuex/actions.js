export const openPetCreatorModal = (context) => {
    context.commit('showPetCreatorModal');
};

export const closePetCreatorModal = (context) => {
    context.commit('hidePetCreatorModal');
};

export const openUserCreatorModal = (context) => {
    context.commit('showUserCreatorModal');
};

export const closeUserCreatorModal = (context) => {
    context.commit('hideUserCreatorModal');
};

export const loadCouriers = (context) => {
    axios.get('/admin/api/couriers')
        .then(response => context.commit('populateCouriersCollection', response.data))
        .catch(error => console.log(error));
};

export const loadMeats = (context) => {
    axios.get('/admin/api/meats')
        .then(response => context.commit('populateMeatsCollection', response.data))
        .catch(error => console.log(error));
};

export const loadPlans = (context) => {
    axios.get('/admin/api/plans')
        .then(response => context.commit('populatePlansCollection', response.data))
        .catch(error => console.log(error));
};

export const loadPets = (context) => {
    axios.get('/admin/api/pets')
        .then(response => context.commit('populatePetsCollection', response.data))
        .catch(error => console.log(error));
};

export const loadUsers = (context) => {
    axios.get('/admin/api/users')
        .then(response => context.commit('populateUsersCollection', response.data))
        .catch(error => console.log(error));
};