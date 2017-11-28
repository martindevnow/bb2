import * as mutations from './mutationTypes';
import {loadOrderFromData} from "../../../models/Order";

export default {
    [mutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data.map(order => loadOrderFromData(order));
    },

    [mutations.SELECT] (state, model) {
        state.selected = model;
    },

    [mutations.DESELECT] (state) {
        state.selected = null;
    },

    [mutations.UPDATE_IN_COLLECTION] (state, payload) {
        state.selected = loadOrderFromData({ ...state.selected, ...payload });
        state.collection = state.collection.map(model => {
            if (model.id == state.selected.id)
                return { ...state.selected };
            return model;
        });
    },

    [mutations.UPDATE_MODEL_IN_COLLECTION] (state, {model, payload}) {
        let updatedOrder = loadOrderFromData({ ...model, ...payload});
        state.collection = state.collection.map(coll => {
            if (coll.id === updatedOrder.id)
                return updatedOrder;
            return coll;
        })
    },

    [mutations.SHOW_PAYMENT_LOGGER] (state) {
        state.show.paymentModal = true;
    },

    [mutations.HIDE_PAYMENT_LOGGER] (state) {
        state.show.paymentModal = false;
    },

    [mutations.SHOW_PACKED_LOGGER] (state) {
        state.show.packedModal = true;
    },

    [mutations.HIDE_PACKED_LOGGER] (state) {
        state.show.packedModal = false;
    },

    [mutations.SHOW_PICKED_LOGGER] (state) {
        state.show.pickedModal = true;
    },

    [mutations.HIDE_PICKED_LOGGER] (state) {
        state.show.pickedModal = false;
    },

    [mutations.SHOW_SHIPPED_LOGGER] (state) {
        state.show.shippedModal = true;
    },

    [mutations.HIDE_SHIPPED_LOGGER] (state) {
        state.show.shippedModal = false;
    },

    [mutations.HIDE_DELIVERED_LOGGER] (state) {
        state.show.deliveredModal = true;
    },

    [mutations.HIDE_DELIVERED_LOGGER] (state) {
        state.show.deliveredModal = false;
    },

    [mutations.HIDE_CANCELLED_LOGGER] (state) {
        state.show.cancellationModal = true;
    },

    [mutations.HIDE_CANCELLED_LOGGER] (state) {
        state.show.cancellationModal = false;
    },

};
