//import/require store module
import store from './store'

//listen to chain of events then dispatched vuex events
Echo.channel('posts')
    .listen('PostCreated', (e) => {
        store.dispatch('getPost', e.post.id)
    })
    .listen('PostLiked', (e) => {
        store.dispatch('refreshPost', e.post.id)
    })
