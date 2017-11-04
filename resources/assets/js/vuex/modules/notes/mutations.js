export const showNoteCreatorModal = (state) => {
    state.show.noteCreatorModal = true;
};

export const hideNoteCreatorModal = (state) => {
    state.show.noteCreatorModal = false;
};

export const setTargetModel = (state, targetModel) => {
    state.targeted = targetModel;
};

export const unsetTargetModel = (state) => {
    state.targeted = {};
};
