export class Meat {
    constructor(apiData) {
        this.code = apiData.code;
        this.type = apiData.type;
        this.variety = apiData.variety;
        this.cost_per_lb = apiData.cost_per_lb;
        this.has_bone = apiData.has_bone;
    }
}

export const loadMeatFromData = function(data) {
    let meat = new Meat();

    meat.code = data.code;
    meat.type = data.type;
    meat.variety = data.variety;
    meat.cost_per_lb = data.cost_per_lb;
    meat.has_bone = data.has_bone;

    return meat;
};