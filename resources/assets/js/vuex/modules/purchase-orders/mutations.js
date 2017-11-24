import * as mutations from './mutationTypes';

export default {
    [mutations.SHOW_ORDERED_MODAL] (state) {
        state.show.orderedModal = true;
    },

    [mutations.HIDE_ORDERED_MODAL] (state) {
        state.show.orderedModal = false;
    },

    [mutations.SHOW_RECEIVED_MODAL] (state) {
        state.show.receivedModal = true;
    },

    [mutations.HIDE_RECEIVED_MODAL] (state) {
        state.show.receivedModal = false;
    },

    [mutations.SELECT] (state, model) {
        state.selected = model;
    },

    [mutations.UPDATE] (state, payload) {
        state.selected = { ...state.selected, ...payload };
        state.collection = state.collection.map(po => {
            if (po.id === state.selected.id)
                return { ...state.selected };
            return po;
        });
    },

    [mutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data;
    },

};
