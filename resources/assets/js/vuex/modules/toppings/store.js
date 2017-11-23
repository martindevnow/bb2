import actions from './actions';
import mutations from './mutations';

const state = {
    collection: [],
    selected: null,
    show: {
        creator: false,
    }
};

const meatsModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default meatsModule;