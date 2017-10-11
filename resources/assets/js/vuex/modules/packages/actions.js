export const loadPackages = (context) => {
    axios.get('/admin/api/packages')
        .then(response => context.commit('populatePackagesCollection', response.data))
        .catch(error => console.log(error));
};

export const openPackageCreatorModal = (context) => {
    context.commit('showPackageCreatorModal');
};

export const closePackageCreatorModal = (context) => {
    context.commit('hidePackageCreatorModal');
};