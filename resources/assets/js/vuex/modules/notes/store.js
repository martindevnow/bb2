import * as actions from './actions';
import * as mutations from './mutations';

const state = {
    collection: [],
    targeted: null,
    show: {
        noteCreatorModal: false,
    }
};

const notesModule = {
    namespaced: true,
    state,
    mutations,
    actions,
};

export default notesModule;