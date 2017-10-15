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

export const loadUsers = (context) => {
    axios.get('/admin/api/users')
        .then(response => context.commit('populateUsersCollection', response.data))
        .catch(error => console.log(error));
};

export const openUserCreatorModal = (context) => {
    context.commit('showUserCreatorModal');
};
