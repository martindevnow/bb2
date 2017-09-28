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
            packedModal: false,
            pickedModal: false,
            shippedModal: false,
            deliveredModal: false,
            noteModal: false,
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
            context.commit('hidePaymentModal');
            context.commit('deselectOrder');
        },
        openPackedModal(context, order) {
            context.commit('setSelectedOrder', order);
            context.commit('showPackedModal');
        },
        closePackedModal(context) {
            context.commit('hidePackedModal');
            context.commit('deselectOrder');
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
        showPackedModal(state) {
            state.show.packedModal = true;
        },
        hidePackedModal(state) {
            state.show.packedModal = false;
        },
        updateSelectedOrder(state, payload) {
            console.log('payload', payload);
            // TODO: apply the changed fields (in the payload) on the state object;
            state.selected.order = { ...state.selected.order, ...payload };
            state.orders = state.orders.filter(order => order.id !== state.selected.order.id);
            state.orders.unshift(state.selected.order);
        }
    }
});