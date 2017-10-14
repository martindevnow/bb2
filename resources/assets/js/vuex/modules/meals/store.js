import * as actions from './actions';
import * as mutations from './mutations';

const state = {
    collection: [],
    selected: null,
    show: {
        petCreatorModal: false,
    }
};

const mealsModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default mealsModule;