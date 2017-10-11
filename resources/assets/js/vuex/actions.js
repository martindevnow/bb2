

export const loadMeats = (context) => {
    axios.get('/admin/api/meats')
        .then(response => context.commit('populateMeatsCollection', response.data))
        .catch(error => console.log(error));
};

export const loadPlans = (context) => {
    axios.get('/admin/api/plans')
        .then(response => context.commit('populatePlansCollection', response.data))
        .catch(error => console.log(error));
};

