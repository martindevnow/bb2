export const populatePackagesCollection = (state, data) => {
    state.collection = data;
};

export const addToPackagesCollection = (state, pkg) => {
    console.log(pkg);
    state.collection.unshift(pkg);
};

export const showPackageCreatorModal = (state) => {
    state.show.packageCreatorModal = true;
};

export const hidePackageCreatorModal = (state) => {
    state.show.packageCreatorModal = false;
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
    console.log(payload);
    state.collection = state.collection.filter(model => model.id !== payload.id);
    state.collection.unshift(payload);
};