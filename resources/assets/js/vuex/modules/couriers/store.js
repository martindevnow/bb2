import actions from './actions';
import mutations from './mutations';

const state = {
    collection: [],
    selected: null,
    show: {
    }
};

const couriersModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default couriersModule;