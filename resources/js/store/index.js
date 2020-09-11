export default {
    state:{
        userList:[],
        userMessage:[],
    },
    actions: {
        userList(contex){
            axios.get('/users')
                .then(response =>{
                    contex.commit("userList",response.data)
            });
        },
        userMessage(contex,payload){
            axios.get('/message/'+payload)
                .then(response =>{
                    contex.commit("userMessage",response.data)
            });
        }
    },
    mutations: {
        userList(state,payload){
           return state.userList = payload
        },
        userMessage(state,payload){
           return state.userMessage = payload
        }
    },
    getters: {
        userList(state){
            return state.userList
        },
        userMessage(state){
            return state.userMessage
        },
    }
}