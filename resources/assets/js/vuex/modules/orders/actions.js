export const openPaymentModal = (context, order) => {
    context.commit('setSelectedOrder', order);
    context.commit('showPaymentsModal');
};

export const closePaymentModal = (context) => {
    context.commit('hidePaymentsModal');
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

export const loadOrders = (context) => {
    axios.get('/admin/api/orders')
        .then(response => context.commit('populateOrdersCollection', response.data))
        .catch(error => console.log(error));
};
