import actions from './actions';
import mutations from './mutations';

const state = {
    collection: [],
    selected: null,
    show: {
        paymentModal: false,
        packedModal: false,
        pickedModal: false,
        shippedModal: false,
        deliveredModal: false,
        cancellationModal: false,
    }
};

const ordersModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default ordersModule;