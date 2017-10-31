import * as actions from './actions';
import * as mutations from './mutations';

const state = {
    collection: [],
    selected: null,
    show: {
        planCreatorModal: false,
    }
};

const plansModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default plansModule;