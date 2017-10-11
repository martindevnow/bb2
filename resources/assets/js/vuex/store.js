import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import state from './state'
import * as mutations from './mutations'
import * as actions from './actions'

import couriers from './modules/couriers/store';
import orders from './modules/orders/store';
import packages from './modules/packages/store';
import purchaseOrders from './modules/purchase-orders/store';

export default new Vuex.Store({
    state,
    mutations,
    actions,
    modules: {
        couriers,
        orders,
        packages,
        purchaseOrders,
    }
})
