export const loadPlans = ({commit, state}, force = false) => {
    if (! force && state.collection.length)
        return;

    axios.get('/admin/api/plans')
        .then(response => commit('populatePlansCollection', response.data))
        .catch(error => console.log(error));
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
