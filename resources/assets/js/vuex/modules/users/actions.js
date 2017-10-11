export const openUserCreatorModal = (context) => {
    context.commit('showUserCreatorModal');
};

export const closeUserCreatorModal = (context) => {
    context.commit('hideUserCreatorModal');
};

export const loadUsers = (context) => {
    axios.get('/admin/api/users')
        .then(response => context.commit('populateUsersCollection', response.data))
        .catch(error => console.log(error));
};