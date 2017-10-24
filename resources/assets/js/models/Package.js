
export class Pkg {
}

export const loadPkgFromData = function(data) {
    let pkg = new Pkg();

    pkg.id = data.id;
    pkg.code = data.code;
    pkg.label = data.label;
    pkg.active = data.active;
    pkg.public = data.public;
    pkg.customization = data.customization;
    pkg.level = data.level;

    pkg.meals = data.meals ? data.meals.map(meal => loadMealFromData(meal)) : null;
    return pkg;
};