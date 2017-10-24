export class Meat {
}

export const loadMeatFromData = function(data) {
    let meat = new Meat();

    meat.id = data.id;
    meat.code = data.code;
    meat.type = data.type;
    meat.variety = data.variety;
    meat.cost_per_lb = data.cost_per_lb;
    meat.has_bone = data.has_bone;

    return meat;
};