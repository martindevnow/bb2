import * as actions from './actions';
import * as mutations from './mutations';

const state = {
    collection: [],
    selected: null,
    show: {
        packageCreatorModal: false,
    },
    mode: null,
};

const packagesModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default packagesModule;