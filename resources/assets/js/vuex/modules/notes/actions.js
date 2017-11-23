import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export const openNoteCreatorModal = (context) => {
    context.commit('showNoteCreatorModal');
};

export const closeNoteCreatorModal = (context) => {
    context.commit('hideNoteCreatorModal');
};

export const createNote = (context, targetModel) => {
    context.commit('setTargetModel', targetModel);
    context.commit('showNoteCreatorModal');
};
