import * as actions from './actionTypes';
import * as mutations from './mutationTypes';

export default {
  [actions.FETCH_ALL] ({commit, state}, force = false) {
      return new Promise((resolve, reject) => {
          if (! force && state.collection.length)
              return resolve(state.collection);

          axios.get('/admin/api/couriers')
              .then(response => {
                  commit(mutations.ADD_TO_COLLECTION, response.data);
                  resolve(response);
              })
              .catch(error => {
                  console.log(error);
                  reject(error);
              });
      });
  },
};

