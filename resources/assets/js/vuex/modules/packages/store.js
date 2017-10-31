import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    collection: [],
    selected: null,
    show: {
        packageCreatorModal: false,
        mealPlanEditorModal: false,
    },
    mode: null,
};

const packagesModule = {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
};

export default packagesModule;