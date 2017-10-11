export const populateOrdersCollection = (state, data) => {
    state.collection = data.map(order => {
        let meal_size = (order.plan.pet_weight * order.plan.pet_activity_level / 2 * 454 / 100).toFixed(0);
        let package_label = order.plan.package.label;
        let pet_breed_customer = order.plan.pet.name + ' (' + order.plan.pet.breed + ') - ' + order.customer.name;
        let deliver_by = order.deliver_by.slice(0,10);
        return {...order, package_label, pet_breed_customer, meal_size, deliver_by };
    });
};


/*
 * Selected
 */

export const setSelectedOrder = (state, order) => {
    state.selected = order;
};

export const deselectOrder = (state) => {
    state.selected = null;
};

export const updateSelectedOrder = (state, payload) => {
    state.selected = { ...state.selected, ...payload };
    state.collection = state.collection.filter(order => order.id !== state.selected.id);
    state.collection.unshift(state.selected);
};


/*
 * Modals
 */

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