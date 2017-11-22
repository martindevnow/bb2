import * as userActions from './userActions';
import * as userMutations from './userMutations';


export default {
    [userActions.CREATE] (context) {
        context.commit(userMutations.DESELECT);
        context.commit(userMutations.CREATE_MODE);
    },

    [userActions.EDIT] (context, user) {
        context.commit(userMutations.SELECT, user);
        context.commit(userMutations.EDIT_MODE);
    },

    [userActions.FETCH_ALL] ({commit, state}, force = false) {
        return new Promise((resolve, reject) => {
            if (!force && state.collection.length)
                return resolve(state.collection);

            axios.get('/admin/api/users')
                .then(response => {
                    commit(userMutations.POPULATE_COLLECTION, response.data);
                    resolve(response);
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                });
        });
    },

    [userActions.SAVE] (context, formData) {
        return new Promise((resolve, reject) => {
            axios.post('/admin/api/users',
                formData
            ).then(response => {
                context.commit(userMutations.ADD_TO_COLLECTION, response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        })
    },

    [userActions.UPDATE] (context, formData) {
        return new Promise((resolve, reject) => {
            axios.put('/admin/api/users/' + context.state.selected.id,
                formData
            ).then(response => {
                context.commit(userMutations.UPDATE, response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        })
    }

};
