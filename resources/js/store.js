
//import/require modules
import Vuex from 'vuex'
import Vue from 'vue'
import axios from "axios";

//attach vuex to Vue
Vue.use(Vuex)

//export data store
export default new Vuex.Store({
    //initialize state
    state: {
        posts: []
    },
    getters: {
        //get all posts
        posts(state) {
            return state.posts
        }
    },
    mutations: {
        //add post to posts array store
        SET_POSTS(state, posts) {
            state.posts = posts
        },
        //add new post to the posts array in the store
        PREPEND_POST(state, post) {
            let posts = state.posts.slice()
            posts.unshift(post)
            state.posts = posts

            //add notification to new post
            var audio = new Audio('audio/newpost.mp3');
            audio.play();
        },
        //update single post in posts array in the store
        UPDATE_POST(state, post) {
            state.posts = state.posts.map((p) => {
                if (p.id === post.id) {
                    return post
                }
                return p
            })
        }
    },
    actions: {
        //fetch all post from the server
        async getPosts({ commit }) {
            let posts = await axios.get("api/posts");

            commit('SET_POSTS', posts.data.data)
        },
        //fetch single post from the server
        async getPost({ commit }, id) {
            let post = await axios.get(`api/posts/${id}`)

            commit('PREPEND_POST', post.data.data)
        },
        //fetch single post fron the server and update fetched post in the store
        async refreshPost({ commit }, id) {
            let post = await axios.get(`api/posts/${id}`)

            commit('UPDATE_POST', post.data.data)
        },
        //send post request to create a single post then add to the posts array in the store
        async createPost({ commit }, data) {
            let post = await axios.post("api/posts", data);

            commit('PREPEND_POST', post.data.data)
        },
        //send post request to create a like record then update that post in the store
        async likePost({ commit }, id) {
            let post = await axios.post(`api/posts/${id}/likes`);

            commit('UPDATE_POST', post.data.data)
        }
    }

})


