export const populateCouriersCollection = (state, data) => {
    state.couriers = data;
};

export const populateMeatsCollection = (state, data) => {
    state.meats = data;
};

export const populateOrdersCollection = (state, data) => {
    state.orders = data.map(order => {
        let meal_size = (order.plan.pet_weight * order.plan.pet_activity_level / 2 * 454 / 100).toFixed(0);
        let package_label = order.plan.package.label;
        let pet_breed_customer = order.plan.pet.name + ' (' + order.plan.pet.breed + ') - ' + order.customer.name;
        return {...order, package_label, pet_breed_customer, meal_size };
    });
};

export const populatePackagesCollection = (state, data) => {
    state.packages = data;
};

export const populatePlansCollection = (state, data) => {
    state.plans = data;
};

export const populatePetsCollection = (state, data) => {
    state.pets = data.map(pet => {
        let owner_name = pet.owner.name;
        return {...pet, owner_name };
    });
};

export const addToPetsCollection = (state, pet) => {
    state.pets.unshift(pet);
};

export const populateUsersCollection = (state, data) => {
    state.users = data;
};

export const setSelectedOrder = (state, order) => {
    state.selected.order = order;
};

export const deselectOrder = (state) => {
    state.selected.order = null;
};

export const showPaymentModal = (state) => {
    state.show.paymentModal = true;
};

export const hidePaymentModal = (state) => {
    state.show.paymentModal = false;
};

export const showPackedModal = (state) => {
    state.show.packedModal = true;
};

export const hidePackedModal = (state) => {
    state.show.packedModal = false;
};

export const showPickedModal = (state) => {
    state.show.pickedModal = true;
};

export const hidePickedModal = (state) => {
    state.show.pickedModal = false;
};

export const showShippedModal = (state) => {
    state.show.shippedModal = true;
};

export const hideShippedModal = (state) => {
    state.show.shippedModal = false;
};

export const showDeliveredModal = (state) => {
    state.show.deliveredModal = true;
};

export const hideDeliveredModal = (state) => {
    state.show.deliveredModal = false;
};

export const showPetCreatorModal = (state) => {
    state.show.petCreatorModal = true;
};

export const hidePetCreatorModal = (state) => {
    state.show.petCreatorModal = false;
};

export const updateSelectedOrder = (state, payload) => {
    state.selected.order = { ...state.selected.order, ...payload };
    state.orders = state.orders.filter(order => order.id !== state.selected.order.id);
    state.orders.unshift(state.selected.order);
};