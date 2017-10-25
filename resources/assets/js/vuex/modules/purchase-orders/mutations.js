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

export const setSelectedPurchaseOrder = (state, purchaseOrder) => {
    state.selected = purchaseOrder;
};

export const updateSelectedPurchaseOrder = (state, payload) => {
    state.selected = { ...state.selected, ...payload };
    state.collection = state.collection.filter(po => po.id !== state.selected.id);
    state.collection.unshift(state.selected.purchaseOrder);
};

export const populatePurchaseOrdersCollection = (state, data) => {
    state.collection = data;
};