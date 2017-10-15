export const closeMealPlanEditorModal = (context) => {
    context.commit('hideMealPlanEditorModal');
    context.commit('deselectPackage');
};

export const closePackageCreatorModal = (context) => {
    context.commit('hidePackageCreatorModal');
    context.commit('deselectPackage');
    context.commit('disableEditMode');
};

export const editPackage = (context, pkg) => {
    context.commit('setSelectedPackage', pkg);
    context.commit('showPackageCreatorModal');
    context.commit('enableEditMode');
};

export const loadPackages = (context, force = false) => {
    if (force || ! context.store.collection.length() )
    axios.get('/admin/api/packages')
        .then(response => context.commit('populatePackagesCollection', response.data))
        .catch(error => console.log(error));
};

export const openMealPlanEditorModal = (context, pkg) => {
    context.commit('setSelectedPackage', pkg);
    context.commit('showMealPlanEditorModal');
};

export const openPackageCreatorModal = (context) => {
    context.commit('showPackageCreatorModal');
};
