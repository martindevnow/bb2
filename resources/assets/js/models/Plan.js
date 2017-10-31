import {loadUserFromData} from "./User";
import {loadPetFromData} from "./Pet";

export class Plan {
    customerName() {
        return (!! this.customer) ? this.customer.name : '';
    }
}

export const loadPlanFromData = function (data) {
    let plan = new Plan();

    plan.id = data.id;

    plan.customer_id = data.customer_id;
    plan.customer = data.customer ? loadUserFromData(data.customer) : null;

    plan.pet_id = data.pet_id;
    plan.pet = data.pet ? loadPetFromData(data.pet) : null;
    plan.pet_weight = data.pet_weight;
    plan.pet_activity_level = data.pet_activity_level;

    plan.package_id = data.package_id;
    plan.package = data.package;
    // plan.package = data.package ? loadPackageFromData(data.package) : null;

    plan.shipping_cost = data.shipping_cost;
    plan.internal_cost = data.internal_cost;
    plan.weekly_cost = data.weekly_cost;
    plan.weeks_of_food_per_shipment = data.weeks_of_food_per_shipment;
    plan.ships_every_x_weeks = data.ships_every_x_weeks;
    plan.first_delivery_at = data.first_delivery_at;
    plan.latest_delivery_at = data.latest_delivery_at;
    plan.active = data.active;
    plan.hash = data.hash;
    plan.comment = data.comment;
    plan.payment_method = data.payment_method;

    plan.delivery_address_id = data.delivery_address_id;
    return plan;
};