export const loadPlans = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (!force && state.collection.length)
            return resolve(state.collection);

        axios.get('/admin/api/plans')
            .then(response => {
                commit('populatePlansCollection', response.data);
                resolve(response);
            })
            .catch(error => {
                console.log(error);
                reject(error);
            });
    });
};

export const openPlanCreatorModal = (context) => {
    context.commit('showPlanCreatorModal');
};

export const closePlanCreatorModal = (context) => {
    context.commit('hidePlanCreatorModal');
    context.commit('disableEditMode');
    context.commit('deselectPlan');
};

export const editPlan = (context, plan) => {
    context.commit('setSelectedPlan', plan);
    context.commit('showPlanCreatorModal');
    context.commit('enableEditMode');
};
