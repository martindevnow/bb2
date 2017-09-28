import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        orders: [
            {customer: 'Ben', pet: 'Halley', plan: 'Basic', paid: 1, weeks_at_a_time: 2},
            {customer: 'Vivian', pet: 'Nova', plan: 'Premium', paid: 0, weeks_at_a_time: 2},
        ],
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
        openPaymentModal(context, payload) {
            context.commit('setSelectedOrder', payload);
            context.commit('showPaymentModal');
        },
        closePaymentModal(context) {
            context.commit('deselectOrder');
            context.commit('hidePaymentModal')
        }
    },
    mutations: {
        setSelectedOrder(state, payload) {
            state.selected.order = payload.order;
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
            state.selected.order = { ...state.selected.order, payload };
            state.orders.splice(state.orders.indexOf(state.selected.order), 1);
            state.orders.push(state.selected.order);
        }
    }
});