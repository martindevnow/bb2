import * as mutations from './mutationTypes';

export default {
    [mutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data.map(plan => {
            let pet_name = plan.pet.name + ' (' + plan.pet_weight + ' lb)';
            let customer_name = plan.customer.name;
            let weeks_of_food = plan.weeks_of_food_per_shipment;
            let weeks_per_shipment = plan.ships_every_x_weeks;
            let package_label = plan.package.label;
            let meals = plan.meals;
            return {...plan, customer_name, weeks_of_food, weeks_per_shipment, pet_name, package_label, meals};
        });
    },

    [mutations.ADD_TO_COLLECTION] (state, plan) {
        let pet_name = plan.pet.name + ' (' + plan.pet_weight + ' lb)';
        let customer_name = plan.customer.name;
        let weeks_of_food = plan.weeks_of_food_per_shipment;
        let weeks_per_shipment = plan.ships_every_x_weeks;
        let package_label = plan.package.label;
        let meals = plan.meals;
        state.collection.unshift({...plan, customer_name, weeks_of_food, weeks_per_shipment,
            pet_name, package_label, meals});
    },

    [mutations.EDIT_MODE] (state) {
        state.show.creator = true;
        state.mode = 'EDIT';
    },

    [mutations.CLEAR_MODE] (state) {
        state.show.creator = false;
        state.mode = null;
    },

    [mutations.SELECT] (state, model) {
        state.selected = model;
    },

    [mutations.DESELECT] (state) {
        state.selected = null;
    },

    [mutations.UPDATE] (state, payload) {
        state.collection = state.collection.map(model => {
            if (model.id === payload.id) {
                let pet_name = payload.pet.name + ' (' + payload.pet_weight + ' lb)';
                let customer_name = payload.customer.name;
                let weeks_of_food = payload.weeks_of_food_per_shipment;
                let weeks_per_shipment = payload.ships_every_x_weeks;
                let package_label = payload.package.label;

                return {...payload, customer_name, weeks_of_food, weeks_per_shipment, pet_name, package_label};

            }
            return model;
        });
    },

    [mutations.CREATE_MODE] (state) {
        state.show.creator = true;
    },

    [mutations.CLEAR_MODE] (state) {
        state.show.creator = false;
    },

    [mutations.SHOW_MEAL_REPLACEMENT_CREATOR] (state) {
        state.show.mealReplacementModal = true;
    },

    [mutations.HIDE_MEAL_REPLACEMENT_CREATOR] (state) {
        state.show.mealReplacementModal = false;
    },

};
