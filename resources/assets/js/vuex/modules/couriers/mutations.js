import * as mutations from './mutationTypes';
import {loadCourierFromData} from "../../../models/Courier";

export default {
    [mutations.POPULATE_COLLECTION] (state, data) {
        state.collection = data.map(modelData => loadCourierFromData(modelData));
    },
};