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

export const loadPackages = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (!force && state.collection.length)
            resolve(state.collection);

        axios.get('/admin/api/packages')
            .then(response => {
                commit('populatePackagesCollection', response.data);
                resolve(response);
            })
            .catch(error => {
                console.log(error);
                reject(error);
            });
    });
};

export const openMealPlanEditorModal = (context, pkg) => {
    context.commit('setSelectedPackage', pkg);
    context.commit('showMealPlanEditorModal');
};

export const openPackageCreatorModal = (context) => {
    context.commit('showPackageCreatorModal');
};
