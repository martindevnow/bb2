import actions from './actions';
import mutations from './mutations';

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