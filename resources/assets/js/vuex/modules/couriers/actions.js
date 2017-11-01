export const loadCouriers = ({commit, state}, force = false) => {
    if (! force && state.collection.length)
        return;

    axios.get('/admin/api/couriers')
        .then(response => commit('populateCouriersCollection', response.data))
        .catch(error => console.log(error));
};
