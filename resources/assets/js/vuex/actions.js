export const loadMeats = (context) => {
    axios.get('/admin/api/meats')
        .then(response => context.commit('populateMeatsCollection', response.data))
        .catch(error => console.log(error));
};