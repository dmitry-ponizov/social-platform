import axios from 'axios'

export default {
    addRoles({commit}, note) {
        commit('add_roles', note)
    },
    createImage: (state, formData) => {
        if (!state.state.loadData['createEventImage'] || state.state.loadData['createEventImage'] === undefined) {
            Vue.set(state.state.loadData, 'createEventImage', true);
            axios.post('/admin/organizations/events/image/create', formData, {headers: {'Content-Type': 'multipart/form-data'}})
                .then(response => {
                    if (response.status === 200) {
                        state.commit('set_event', response.data.data);
                        Vue.set(state.state.loadData, 'createEventImage', false);
                    }
                }).catch(error => {
                if (error.response.status === 422) {
                    reject(error);
                    Vue.set(state.state.loadData, 'createEventImage', false);
                }
            });
        }
    },
    updateImage: (state, formData) => {
        if (!state.state.loadData['updateEventImage'] || state.state.loadData['updateEventImage'] === undefined) {
            Vue.set(state.state.loadData, 'updateEventImage', true);
            axios.post('/admin/organizations/events/image/update', formData, {headers: {'Content-Type': 'multipart/form-data'}})
                .then(response => {
                    if (response.status === 200) {
                        Vue.set(state.state.loadData, 'updateEventImage', false);
                        state.commit('set_event', response.data.data);
                    }
                }).catch(error => {
                if (error.response.status === 422) {
                    Vue.set(state.state.loadData, 'updateEventImage', false);
                }
            })
        }
    },
    updateBody: (state, data) => {
        if (!state.state.loadData['updateBodyEvent'] || state.state.loadData['updateBodyEvent'] === undefined) {
            Vue.set(state.state.loadData, 'updateBodyEvent', true);
            axios.patch('/admin/organizations/events/update', {
                body: data['body'],
                id: data['id']
            })
                .then(response => {
                    if (response.status === 200) {
                        Vue.set(state.state.loadData, 'updateBodyEvent', false);
                        state.commit('set_event', response.data.data);
                    }
                }).catch(error => {
                if (error.response.status === 422) {
                    Vue.set(state.state.loadData, 'updateBodyEvent', false);
                }
            })

        }
    },
    getAllCategories: (state, data) => {
        if (!state.state.loadData['getAllCategories'] || state.state.loadData['getAllCategories'] === undefined) {
            Vue.set(state.state.loadData, 'getAllCategories', true);
            axios.post('/get-categories')
                .then(response => {
                    if (response.status === 200) {
                        Vue.set(state.state.loadData, 'getAllCategories', false);
                        state.commit('setAllCategories', response.data);
                    }
                }).catch(error => {
                if (error.response.status === 422) {
                    Vue.set(state.state.loadData, 'getAllCategories', false);
                }
            })

        }
    }
}