export const loadPurchaseOrders = (context) => {
    axios.get('/admin/api/purchase-orders')
        .then(response => context.commit('populatePurchaseOrdersCollection', response.data))
        .catch(error => console.log(error));
};

export const openOrderedModal = (context, purchaseOrder) => {
    context.commit('setSelectedPurchaseOrder', purchaseOrder);
    context.commit('showOrderedModal');
};

export const closeOrderedModal = (context) => {
    context.commit('hideOrderedModal');
};

export const openReceivedModal = (context, purchaseOrder) => {
    context.commit('setSelectedPurchaseOrder', purchaseOrder);
    context.commit('showReceivedModal');
};

export const closeReceivedModal = (context) => {
    context.commit('hideReceivedModal');
};