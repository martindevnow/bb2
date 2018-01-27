import actions from './actions';
import mutations from './mutations';

const state = {
    collection: [],
    selected: null,
    show: {
        creator: false,
    },
    mode: null,
};

const usersModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default usersModule;