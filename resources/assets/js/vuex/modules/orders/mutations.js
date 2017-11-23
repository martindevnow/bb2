import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
    [mutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data.map(order => {
            let meal_size = (order.plan.pet_weight * order.plan.pet_activity_level / order.plan.pet.daily_meals * 454 / 100).toFixed(0);
            let daily_meals = order.plan.pet.daily_meals;
            let package_label = order.plan.package.label;
            let pet_breed_customer = order.plan.pet.name + ' (' + order.plan.pet.breed + ') - ' + order.customer.name;
            let deliver_by = order.deliver_by.slice(0,10);
            return {...order, package_label, pet_breed_customer, meal_size, deliver_by, daily_meals };
        });
    },

    [mutations.SELECT] (state, model) {
        state.selected = model;
    },

    [mutations.DESELECT] (state) {
        state.selected = null;
    },

    [mutations.UPDATE] (state, payload) {
        state.selected = { ...state.selected, ...payload };
        state.collection = state.collection.map(model => {
            if (model.id == state.selected.id)
                return { ...state.selected };
            return model;
        });
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
