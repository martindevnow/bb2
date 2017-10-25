export const loadPlans = (context) => {
    axios.get('/admin/api/plans')
        .then(response => context.commit('populatePlansCollection', response.data))
        .catch(error => console.log(error));
};

export const openPlanCreatorModal = (context) => {
    context.commit('showPlanCreatorModal');
};

export const closePlanCreatorModal = (context) => {
    context.commit('hidePlanCreatorModal');
};