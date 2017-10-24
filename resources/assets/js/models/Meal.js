import {loadMeatFromData} from "./Meat";
import {loadToppingFromData} from "./Topping";

export class Meal {

    costPerLb() {
        if (! this.meats) {
            return 0;
        }
        return this.meats.reduce((carry, meat) => {
            return carry + meat.cost_per_lb;
        }, 0) / this.meats.length;
    }

}

export const loadMealFromData = function(data) {
    let meal = new Meal();

    meal.id = data.id;
    meal.code = data.code;
    meal.label = data.label;
    meal.variety = data.variety;
    meal.meal_value = data.meal_value;
    meal.has_bone = data.has_bone;

    meal.meats = data.meats ? data.meats.map(meat => loadMeatFromData(meat)) : null;
    meal.toppings = data.toppings ? data.toppings.map(topping => loadToppingFromData(topping)) : null;
    return meal;
};