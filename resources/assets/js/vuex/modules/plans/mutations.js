export const populatePlansCollection = (state, data) => {
    state.collection = data.map(plan => {
        let pet_name = plan.pet.name + ' (' + plan.pet_weight + ' lb)';
        let customer_name = plan.customer.name;
        let weeks_of_food = plan.weeks_of_food_per_shipment;
        let weeks_per_shipment = plan.ships_every_x_weeks;
        let package_label = plan.package.label;
        return {...plan, customer_name, weeks_of_food, weeks_per_shipment, pet_name, package_label};
    });
};

export const addToPlansCollection = (state, plan) => {
    let pet_name = plan.pet.name + ' (' + plan.pet_weight + ' lb)';
    let customer_name = plan.customer.name;
    let weeks_of_food = plan.weeks_of_food_per_shipment;
    let weeks_per_shipment = plan.ships_every_x_weeks;
    let package_label = plan.package.label;
    state.collection.unshift({...plan, customer_name, weeks_of_food, weeks_per_shipment, pet_name, package_label});
};

export const showPlanCreatorModal = (state) => {
    state.show.planCreatorModal = true;
};

export const hidePlanCreatorModal = (state) => {
    state.show.planCreatorModal = false;
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
    state.selected = null;
};

export const updatePlan = (state, payload) => {
    state.collection = state.collection.filter(model => model.id !== payload.id);
    state.collection.unshift((payload));
};