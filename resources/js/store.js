import Vuex from 'vuex'

import Vue from 'vue'

Vue.use(Vuex)

import axios from "axios";

export default new Vuex.Store({
    state: {
        posts: []
    },

    getters: {
        posts(state) {
            return state.posts
        }
    },

    mutations: {
        SET_POSTS(state, posts) {
            state.posts = posts
        }
    },
    actions: {
        async getPosts({ commit }) {
            let posts = await axios.get("api/posts");

            commit('SET_POSTS', posts.data.data)
        }
    }

})


