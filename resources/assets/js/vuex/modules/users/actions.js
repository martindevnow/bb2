export const closeUserCreatorModal = (context) => {
    context.commit('hideUserCreatorModal');
    context.commit('deselectUser');
    context.commit('disableEditMode');
};

export const editUser = (context, user) => {
    context.commit('setSelectedUser', user);
    context.commit('showUserCreatorModal');
    context.commit('enableEditMode');
};

export const loadUsers = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (! force && state.collection.length)
            return resolve(state.collection);

        axios.get('/admin/api/users')
            .then(response => {
                commit('populateUsersCollection', response.data);
                resolve(response);
            })
            .catch(error => {
                console.log(error);
                reject(error);
            });
    });
};

export const openUserCreatorModal = (context) => {
    context.commit('showUserCreatorModal');
};
