// import Axios
import Axios from "axios"

export default {
    // state
    state: {
        userList: [],
        userMessage: []
    },
    // mutations
    mutations: {
        userList(state, payload) {
            return state.userList = payload
        },
        userMessage(state, payload) {
            return state.userMessage = payload
        }
    },
    // actions
    actions: {
        userList(context){
            Axios.get('user-list')
                .then(response=> {  
                    context.commit('userList', response.data)
                })
        },
        userMessage(context, payload) {
            Axios.get('user-message/' + payload)
                .then(response=> {
                    context.commit('userMessage', response.data)
                })
        }
    },
    // getters
    getters: {
        userList(state) {
            return state.userList
        },
        userMessage(state) {
            return state.userMessage
        }
    }
}