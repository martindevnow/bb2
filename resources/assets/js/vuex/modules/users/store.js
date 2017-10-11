import * as actions from './actions';
import * as mutations from './mutations';

const state = {
    collection: [],
    selected: null,
    show: {
        userCreatorModal: false,
    }
};

const usersModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default usersModule;