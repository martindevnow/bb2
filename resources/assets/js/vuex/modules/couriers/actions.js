export const loadCouriers = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (! force && state.collection.length)
            return resolve(state.collection);

        axios.get('/admin/api/couriers')
            .then(response => {
                commit('populateCouriersCollection', response.data);
                resolve(response);
            })
            .catch(error => {
                console.log(error);
                reject(error);
            });
    });
};
