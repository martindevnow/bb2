import * as actions from './actions';
import * as mutations from './mutations';

const state = {
    collection: [],
    selected: null,
    show: {
        addressCreatorModal: false,
    },
    mode: null,
};

const addressesModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default addressesModule;