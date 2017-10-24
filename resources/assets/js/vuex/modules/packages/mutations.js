import {loadPkgFromData} from "../../../models/Package";

export const populatePackagesCollection = (state, data) => {
    state.collection = data.map(pkgData => loadPkgFromData(pkgData));
};

export const addToPackagesCollection = (state, pkg) => {
    state.collection.unshift(pkg);
};

export const showPackageCreatorModal = (state) => {
    state.show.packageCreatorModal = true;
};

export const hidePackageCreatorModal = (state) => {
    state.show.packageCreatorModal = false;
};

export const showMealPlanEditorModal = (state) => {
    state.show.mealPlanEditorModal = true;
};

export const hideMealPlanEditorModal = (state) => {
    state.show.mealPlanEditorModal = false;
};

export const setSelectedPackage = (state, pkg) => {
    state.selected = pkg;
};

export const deselectPackage = (state) => {
    state.selected = null;
};

export const enableEditMode = (state) => {
    state.mode = 'EDIT';
};

export const disableEditMode = (state) => {
    state.mode = null;
};

export const updatePackage = (state, payload) => {
    state.collection = state.collection.filter(model => model.id !== payload.id);
    state.collection.unshift(payload);
};