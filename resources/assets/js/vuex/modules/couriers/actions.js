export const loadCouriers = (context) => {
    axios.get('/admin/api/couriers')
        .then(response => context.commit('populateCouriersCollection', response.data))
        .catch(error => console.log(error));
};
