export class Topping {
}

export const loadToppingFromData = function(data) {
    let topping = new Topping();

    topping.id = data.id;
    topping.code = data.code;
    topping.label = data.label;
    topping.cost_per_kg = data.cost_per_kg;

    return topping;
};