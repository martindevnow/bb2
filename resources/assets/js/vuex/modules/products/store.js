import * as actions from './actions';
import * as mutations from './mutations';

const state = {
    collection: [],
    selected: null,
    show: {
        productCreatorModal: false,
    }
};

const productsModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default productsModule;