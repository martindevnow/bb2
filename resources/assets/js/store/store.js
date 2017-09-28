import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        orders: [
            {id: 1, customer: 'Ben', pet: 'Halley', plan: 'Basic', paid: 1, weeks_at_a_time: 2},
            {id: 2, customer: 'Vivian', pet: 'Nova', plan: 'Premium', paid: 0, weeks_at_a_time: 2},
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
            // TODO: apply the changed fields (in the payload) on the state object;
            // state.selected.order.paid = { ...state.selected.order, payload };
            state.orders.splice(state.orders.indexOf(state.selected.order), 1);
            state.orders.push(state.selected.order);
        }
    }
});