export const closeAddressCreatorModal = (context) => {
    context.commit('hideAddressCreatorModal');
    context.commit('deselectAddress');
    context.commit('disableEditMode');
};

export const editAddress = (context, user) => {
    context.commit('setSelectedAddress', user);
    context.commit('showAddressCreatorModal');
    context.commit('enableEditMode');
};

export const deleteAddress = (context, address) => {
    let vm = this;
    axios.delete('/admin/api/addresses/' + address.id).then(response => {
        context.commit('users/removeAddress', address, {root: true});
    }).catch(error => {
        alert('Error');
    });
};

export const loadAddresses = ({commit, state}, force = false) => {
    return new Promise((resolve, reject) => {
        if (! force && state.collection.length)
            return resolve(state.collection);

        axios.get('/admin/api/addresses')
            .then(response => {
                commit('populateAddressesCollection', response.data);
                resolve(response);
            })
            .catch(error => {
                console.log(error);
                reject(error);
            });
    });
};

export const openAddressCreatorModal = (context) => {
    context.commit('showAddressCreatorModal');
};
