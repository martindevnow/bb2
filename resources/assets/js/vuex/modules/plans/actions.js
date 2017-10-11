export const loadPlans = (context) => {
    axios.get('/admin/api/plans')
        .then(response => context.commit('populatePlansCollection', response.data))
        .catch(error => console.log(error));
};