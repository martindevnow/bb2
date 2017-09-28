import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        orders: [
            {customer: 'Ben', pet: 'Halley', plan: 'Basic', paid: 1, weeks_at_a_time: 2},
            {customer: 'Vivian', pet: 'Nova', plan: 'Premium', paid: 0, weeks_at_a_time: 2},
        ],
    },
    getters: {
        nonPaidOrders: state => {
            return state.orders.filter(order => {
                return order.paid == 0;
            })
        }
    }
});