export default {
    state:{
        userList:[]
    },
    actions: {
        userList(contex){
            axios.get('/users')
                .then(response =>{
                    contex.commit("userList",response.data)
            });
        }
    },
    mutations: {
        userList(state,payload){
           return state.userList = payload
        }
    },
    getters: {
        userList(state){
            return state.userList
        }
    }
}