export const openPaymentModal = (context, order) => {
    context.commit('setSelectedOrder', order);
    context.commit('showPaymentModal');
};

export const closePaymentModal = (context) => {
    context.commit('hidePaymentModal');
    context.commit('deselectOrder');
};

export const openPackedModal = (context, order) => {
    context.commit('setSelectedOrder', order);
    context.commit('showPackedModal');
};

export const closePackedModal = (context) => {
    context.commit('hidePackedModal');
    context.commit('deselectOrder');
};

export const openPickedModal = (context, order) => {
    context.commit('setSelectedOrder', order);
    context.commit('showPickedModal');
};

export const closePickedModal = (context) => {
    context.commit('hidePickedModal');
    context.commit('deselectOrder');
};

export const openShippedModal = (context, order) => {
    context.commit('setSelectedOrder', order);
    context.commit('showShippedModal');
};

export const closeShippedModal = (context) => {
    context.commit('hideShippedModal');
    context.commit('deselectOrder');
};

export const openDeliveredModal = (context, order) => {
    context.commit('setSelectedOrder', order);
    context.commit('showDeliveredModal');
};

export const closeDeliveredModal = (context) => {
    context.commit('hideDeliveredModal');
    context.commit('deselectOrder');
};

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

export const loadOrders = (context) => {
    axios.get('/admin/api/orders')
        .then(response => context.commit('populateOrdersCollection', response.data))
        .catch(error => console.log(error));
};

export const loadPackages = (context) => {
    axios.get('/admin/api/packages')
        .then(response => context.commit('populatePackagesCollection', response.data))
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