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
        let deliver_by = order.deliver_by.slice(0,10);
        return {...order, package_label, pet_breed_customer, meal_size, deliver_by };
    });
};

export const populatePackagesCollection = (state, data) => {
    state.packages = data;
};

export const populatePlansCollection = (state, data) => {
    state.plans = data;
};

export const populatePetsCollection = (state, data) => {
    state.pets = data;
};

export const populatePurchaseOrdersCollection = (state, data) => {
    state.purchaseOrders = data;
};

export const addToPetsCollection = (state, pet) => {
    state.pets.unshift(pet);
};

export const addToUsersCollection = (state, user) => {
    state.users.unshift(user);
};

export const populateUsersCollection = (state, data) => {
    state.users = data.map(user => {
        if (! user.pets) {
            return user;
        }
        let pets = user.pets.reduce(function(carry, pet) {
            if (carry == '')
                return pet.name;
            return carry + ", " + pet.name
        }, '');
        return {...user, pets};
    });
};

export const setSelectedOrder = (state, order) => {
    state.selected.order = order;
};

export const setSelectedPurchaseOrder = (state, purchaseOrder) => {
    state.selected.purchaseOrder = purchaseOrder;
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

export const showUserCreatorModal = (state) => {
    state.show.userCreatorModal = true;
};

export const hideUserCreatorModal = (state) => {
    state.show.userCreatorModal = false;
};

export const showOrderedModal = (state) => {
    state.show.orderedModal = true;
};

export const hideOrderedModal = (state) => {
    state.show.orderedModal = false;
};

export const showReceivedModal = (state) => {
    state.show.receivedModal = true;
};

export const hideReceivedModal = (state) => {
    state.show.receivedModal = false;
};

export const updateSelectedOrder = (state, payload) => {
    state.selected.order = { ...state.selected.order, ...payload };
    state.orders = state.orders.filter(order => order.id !== state.selected.order.id);
    state.orders.unshift(state.selected.order);
};

export const updateSelectedPurchaseOrder = (state, payload) => {
    state.selected.purchaseOrder = { ...state.selected.purchaseOrder, ...payload };
    state.purchaseOrders = state.purchaseOrders.filter(purchaseOrder => purchaseOrder.id !== state.selected.purchaseOrder.id);
    state.purchaseOrders.unshift(state.selected.purchaseOrder);
};