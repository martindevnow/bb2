import actions from './actions';
import mutations from './mutations';
const state = {
    collection: [],
    selected: null,
    show: {
        receivedModal: false,
        orderedModal: false,
    }
}

const purchaseOrdersModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default purchaseOrdersModule;