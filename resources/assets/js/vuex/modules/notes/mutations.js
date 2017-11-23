import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export const showNoteCreatorModal = (state) => {
    state.show.creator = true;
};

export const hideNoteCreatorModal = (state) => {
    state.show.creator = false;
};

export const setTargetModel = (state, targetModel) => {
    state.targeted = targetModel;
};

export const unsetTargetModel = (state) => {
    state.targeted = {};
};
