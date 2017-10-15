import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import state from './state'
import * as mutations from './mutations'
import * as actions from './actions'

import couriers from './modules/couriers/store';
import meals from './modules/meals/store';
import orders from './modules/orders/store';
import packages from './modules/packages/store';
import pets from './modules/pets/store';
import plans from './modules/plans/store';
import purchaseOrders from './modules/purchase-orders/store';
import users from './modules/users/store';

export default new Vuex.Store({
    state,
    mutations,
    actions,
    modules: {
        couriers,
        meals,
        orders,
        packages,
        pets,
        plans,
        purchaseOrders,
        users,
    }
})
