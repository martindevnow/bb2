import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import state from './state'
import * as mutations from './mutations'
import * as actions from './actions'

import addresses from './modules/addresses/store';
import couriers from './modules/couriers/store';
import meals from './modules/meals/store';
import meats from './modules/meats/store';
import notes from './modules/notes/store';
import orders from './modules/orders/store';
import packages from './modules/packages/store';
import pets from './modules/pets/store';
import plans from './modules/plans/store';
import products from './modules/products/store';
import purchaseOrders from './modules/purchase-orders/store';
import toppings from './modules/toppings/store';
import users from './modules/users/store';

export default new Vuex.Store({
    state,
    mutations,
    actions,
    modules: {
        addresses,
        couriers,
        meals,
        meats,
        notes,
        orders,
        packages,
        pets,
        plans,
        products,
        purchaseOrders,
        toppings,
        users,
    }
})
