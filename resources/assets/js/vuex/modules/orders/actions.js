import * as actions from './actionTypes';
import * as mutations from './mutationTypes';
import * as noteMutations from './../notes/mutationTypes';
import moment from 'moment';

export default {
    [actions.FETCH_ALL] ({commit, state}, force = false) {
        return new Promise((resolve, reject) => {
            if (! force && state.collection.length)
                return resolve(state.collection);

            axios.get('/admin/api/orders')
                .then(response => {
                    commit(mutations.POPULATE_COLLECTION, response.data);
                    resolve(response);
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                });
        });
    },

    [actions.OPEN_PAYMENT_LOGGER] ({commit}, order) {
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_PAYMENT_LOGGER);
    },

    [actions.CLOSE_PAYMENT_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_PAYMENT_LOGGER);
    },

    [actions.SAVE_PAYMENT] ({commit, state}, formData) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/orders/' + state.selected.id + '/paid',
                formData
            ).then(response => {
                commit(mutations.UPDATE_IN_COLLECTION, { paid: true });
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    [actions.OPEN_PACKED_LOGGER] ({commit}, order) {
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_PACKED_LOGGER);
    },

    [actions.CLOSE_PACKED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_PACKED_LOGGER);
    },

    [actions.SAVE_PACKED] ({commit, state}, formData) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/orders/' + state.selected.id + '/packed',
                formData,
            ).then(response => {
                commit(mutations.UPDATE_IN_COLLECTION, {
                    packed: true,
                    weeks_packed: formData.weeks_packed,
                    packed_package_id: formData.packed_package_id,
                });
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    [actions.OPEN_PICKED_LOGGER] ({commit}, order) {
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_PICKED_LOGGER);
    },

    [actions.CLOSE_PICKED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_PICKED_LOGGER);
    },

    [actions.OPEN_SHIPPED_LOGGER] ({commit}, order) {
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_SHIPPED_LOGGER);
    },

    [actions.CLOSE_SHIPPED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_SHIPPED_LOGGER);
    },

    [actions.SAVE_SHIPPED] ({commit, state}, formData) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/orders/' + state.selected.id + '/shipped',
                formData
            ).then(response => {
                commit(mutations.UPDATE_IN_COLLECTION, {
                    shipped: true,
                    shipped_at: formData.shipped_at,
                    weeks_shipped: formData.weeks_shipped,
                    shipped_package_id: formData.shipped_package_id,
                });
                resolve(response);
            }).catch(function(error) {
                reject(error);
            });
        });
    },

    [actions.OPEN_DELIVERED_LOGGER] ({commit}, order) {
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_DELIVERED_LOGGER);
    },

    [actions.CLOSE_DELIVERED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit(mutations.HIDE_DELIVERED_LOGGER);
    },

    [actions.OPEN_CANCELLED_LOGGER] ({commit}, order) {
        commit('notes/' + noteMutations.SET_TARGET_MODEL, {model: order, type: 'order'}, { root: true });
        commit(mutations.SELECT, order);
        commit(mutations.SHOW_CANCELLED_LOGGER);
    },

    [actions.CLOSE_CANCELLED_LOGGER] ({commit}) {
        commit(mutations.DESELECT);
        commit('notes/' + noteMutations.UNSET_TARGET_MODEL, null, { root: true });
        commit(mutations.HIDE_CANCELLED_LOGGER);
    },

    [actions.SAVE_CANCELLED] ({commit, state}, formData) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/orders/' + state.selected.id + '/cancel'
            ).then(response => {
                commit(mutations.UPDATE_IN_COLLECTION, {cancelled: true});
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    [actions.UPDATE_DELIVER_BY] ({commit, state}, {order, formData}) {
        let originalOrder = order;
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/orders/' + originalOrder.id + '/deliverBy',
                formData,
            ).then(response => {
                if (formData.updateFuture) {
                    // Initial Order Date (for comparison sake)
                    let originalOrderDate = new Date(originalOrder.deliver_by);

                    // Get a list of future orders to update
                    let subset = state.collection.filter(subItem => {
                        if (subItem.plan_id !== originalOrder.plan_id)
                            return false;

                        let subItem_date = new Date(subItem.deliver_by);
                        return subItem_date > originalOrderDate;
                    });

                    // Update the order in question to the data selected by the user
                    commit(mutations.UPDATE_MODEL_IN_COLLECTION, {
                        model: originalOrder,
                        payload: formData,
                    });

                    // Calculate the delivery by for the next order
                    let newOrderDate = new Date(formData.deliver_by);
                    newOrderDate.setDate(newOrderDate.getDate() + (
                        originalOrder.weeks_shipped
                        || originalOrder.weeks_packed
                        || originalOrder.ships_every_x_weeks
                        || 1) * 7);

                    // Apply to future order and recalculate deliver_by
                    subset.forEach(eachItem => {
                        commit(mutations.UPDATE_MODEL_IN_COLLECTION, {
                            model: eachItem,
                            payload: {
                                deliver_by: moment(newOrderDate).format('YYYY-MM-DD'),
                            },
                        });
                        newOrderDate.setDate(newOrderDate.getDate() + (
                            eachItem.weeks_shipped
                            || eachItem.weeks_packed
                            || eachItem.ships_every_x_weeks
                            || 1) * 7);
                    });
                }
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },
};


