export const populatePackagesCollection = (state, data) => {
    state.packages = data;
};

export const showPackageCreatorModal = (state) => {
    state.show.packageCreatorModal = true;
};

export const hidePackageCreatorModal = (state) => {
    state.show.packageCreatorModal = false;
};