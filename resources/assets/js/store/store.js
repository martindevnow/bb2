import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        orders: [],
        selected: {
            order: null,
        },
        show: {
            paymentModal: false,
        }
    },
    getters: {

    },
    actions: {
        openPaymentModal(context, order) {
            context.commit('setSelectedOrder', order);
            context.commit('showPaymentModal');
        },
        closePaymentModal(context) {
            context.commit('deselectOrder');
            context.commit('hidePaymentModal')
        },
        loadOrders(context) {
            axios.get('/admin/api/orders')
                .then(response => context.commit('setOrders', response.data))
                .catch(error => console.log(error));
        }
    },
    mutations: {
        setOrders(state, data) {
            state.orders = data;
        },
        setSelectedOrder(state, order) {
            state.selected.order = order;
        },
        deselectOrder(state) {
            state.selected.order = null;
        },
        showPaymentModal(state) {
            state.show.paymentModal = true;
        },
        hidePaymentModal(state) {
            state.show.paymentModal = false;
        },
        updateSelectedOrder(state, payload) {
            console.log('payload', payload);
            // TODO: apply the changed fields (in the payload) on the state object;
            state.selected.order = { ...state.selected.order, ...payload };
            state.orders.splice(state.orders.indexOf(state.selected.order), 1);
            state.orders.unshift(state.selected.order);
        }
    }
});