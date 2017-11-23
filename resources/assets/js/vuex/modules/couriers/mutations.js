import * as mutations from './mutationTypes';

export default {
    [mutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data.map(modelData => loadMealFromData(modelData));
    },
};