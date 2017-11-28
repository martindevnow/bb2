
export class Order {}

export const loadOrderFromData = function(data) {
    let order = new Order();

    order.id                  = data.id;

    // Relationships
    order.plan_id               = data.plan_id;
    order.customer_id           = data.customer_id;
    order.delivery_address_id   = data.delivery_address_id;
    order.packed_package_id     = data.packed_package_id;
    order.shipped_package_id    = data.shipped_package_id;

    // Due Date
    order.deliver_by             = data.deliver_by;

    // $
    order.subtotal      = data.subtotal;
    order.tax           = data.tax;
    order.total_cost    = data.total_cost;

    // Status (bool)
    order.plan_order    = data.plan_order;

    order.paid          = data.paid;
    order.packed        = data.packed;
    order.picked        = data.picked;
    order.shipped       = data.shipped;
    order.delivered     = data.delivered;

    // Status (int)
    order.weeks_packed      = data.weeks_packed;
    order.weeks_shipped     = data.weeks_shipped;

    // Status (date)
    order.shipped_at        = data.shipped_at;
    order.delivered_at      = data.delivered_at;

    // Calculated
    order.meal_size             = (data.plan.pet_weight * data.plan.pet_activity_level / data.plan.pet.daily_meals * 454 / 100).toFixed(0);
    order.daily_meals           = data.plan.pet.daily_meals;
    order.package_label         = data.plan.package.label;
    order.pet_breed_customer    = data.plan.pet.name + ' (' + data.plan.pet.breed + ') - ' + data.customer.name;
    order.deliver_by            = data.deliver_by.slice(0,10);

    return order;
};