export const populatePlansCollection = (state, data) => {
    state.collection = data.map(plan => {
        let pet_name = plan.pet.name + ' (' + plan.pet_weight + ' lb)';
        let customer_name = plan.customer.name;
        let weeks_of_food = plan.weeks_of_food_per_shipment;
        let weeks_per_shipment = plan.ships_every_x_weeks;
        return {...plan, customer_name, weeks_of_food, weeks_per_shipment, pet_name};
    });
};

export const addToPlansCollection = (state, plan) => {
    let pet_name = plan.pet.name + ' (' + plan.pet_weight + ' lb)';
    let customer_name = plan.customer.name;
    let weeks_of_food = plan.weeks_of_food_per_shipment;
    let weeks_per_shipment = plan.ships_every_x_weeks;
    state.collection.unshift({...plan, customer_name, weeks_of_food, weeks_per_shipment, pet_name});
};

export const showPlanCreatorModal = (state) => {
    state.show.planCreatorModal = true;
};

export const hidePlanCreatorModal = (state) => {
    state.show.planCreatorModal = false;
};