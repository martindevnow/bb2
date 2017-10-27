export const getPackageById = (state, getters) => (id) => {
    return state.collection.find(pkg => pkg.id === id)
};