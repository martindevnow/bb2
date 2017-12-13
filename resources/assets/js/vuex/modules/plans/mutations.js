export const populatePlansCollection = (state, data) => {
    state.collection = data.map(plan => {
        let pet_name = plan.pet.name + ' (' + plan.pet_weight + ' lb)';
        let customer_name = plan.customer.name;
        let weeks_of_food = plan.weeks_of_food_per_shipment;
        let weeks_per_shipment = plan.ships_every_x_weeks;
        let package_label = plan.package.label;
        let meals = plan.meals;
        return {...plan, customer_name, weeks_of_food, weeks_per_shipment, pet_name, package_label, meals};
    });
};

export const addToPlansCollection = (state, plan) => {
    let pet_name = plan.pet.name + ' (' + plan.pet_weight + ' lb)';
    let customer_name = plan.customer.name;
    let weeks_of_food = plan.weeks_of_food_per_shipment;
    let weeks_per_shipment = plan.ships_every_x_weeks;
    let package_label = plan.package.label;
    let meals = plan.meals;
    state.collection.unshift({...plan, customer_name, weeks_of_food, weeks_per_shipment, pet_name, package_label, meals});
};

export const showPlanCreatorModal = (state) => {
    state.show.planCreatorModal = true;
};

export const hidePlanCreatorModal = (state) => {
    state.show.planCreatorModal = false;
};

export const showMealReplacementModal = (state) => {
    state.show.mealReplacementModal = true;
};

export const hideMealReplacementModal = (state) => {
    state.show.mealReplacementModal = false;
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const setSelectedPlan = (state, Plan) => {
    state.selected = Plan;
};

export const deselectPlan = (state) => {
    state.selected = {};
};

export const updatePlan = (state, payload) => {
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
};