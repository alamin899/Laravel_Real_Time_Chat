<template>
    <div class="container clearfix">
        <div class="people-list" style="min-height: 600px; overflow-y: scroll; height:500px;" >
            <input type="text" placeholder="search" />
            <i class="fa fa-search"></i>
            <ul>
                <li @click.prevent="selectUser(user.id)" class="clearfix" v-for="user in userList">
                    <div class="about">
                        <div class="name">{{user.name}}</div>
                        <div class="status">
                            <i class="fa fa-circle online"></i> online
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="chat">
            <div class="chat-header clearfix">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01_green.jpg" alt="avatar" />

                <div class="chat-about">
                    <div class="chat-with" v-if="userMessage.user">{{userMessage.user.name}}</div>
                </div>
                <ul class="nav nav-tabs">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">...</a>
                    <div class="dropdown-menu">
                        <a @click.prevent="deleteAllMessage" class="dropdown-item" href="#">Delete All Message</a>
                    </div>
                </li>

            </ul>
            </div> <!-- end chat-header -->

            <div class="chat-history" v-chat-scroll style="overflow-y: scroll; height:300px;">
                <ul>
                    <li v-for="message in userMessage.message">
                        <div class="message-data">
                            <span class="message-data-name"><i class="fa fa-circle online"></i></span>
                            <span class="message-data-time">{{dateTimeFormate(message.created_at)}}</span>
                            <ul class="nav nav-tabs">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">...</a>
                                    <div class="dropdown-menu">
                                        <a @click.prevent="deleteSingleMessage(message.id)" class="dropdown-item" href="#">Delete Message</a>
                                    </div>
                                </li>
                            </ul>

                        </div>
                        <div :class="`message ${message.to == userMessage.user.id ? 'other-message' : 'my-message'}`">
                           {{message.message}}
                        </div>
                    </li>
                </ul>
            </div> <!-- end chat-history -->

            <div class="chat-message clearfix">
                <div class="row"><p v-if="typing">{{typing}} Typing......</p></div>
                <div class="row">
                    <textarea v-if="userMessage.user" @keydown.enter="sendMessage" @keyup="typingEvent(userMessage.user.id)" v-model="message" name="chat-message-to-send" placeholder ="Type your message" rows="3"></textarea>
                    <textarea v-else disabled @keydown.enter="sendMessage" v-model="message" name="chat-message-to-send" placeholder ="Type your message" rows="3"></textarea>

                    <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
                    <i class="fa fa-file-image-o"></i>
                    <button @click="sendMessage">Send</button>
                </div>


            </div> <!-- end chat-message -->

        </div> <!-- end chat -->

    </div> <!-- end container -->
</template>

<script>
    export default {
        name: "ChatApp",
        data(){
            return{
                message:'',
                typing:'',
            }
        },
        mounted(){
            Echo.private(`chat.${authuser.id}`)
                .listen('MessageSend', (e) => {
                    this.selectUser(e.message.from);
                });
            this.$store.dispatch('userList')

            Echo.private('typingevent')
                .listenForWhisper('typing', (e) => {
                    if(e.user.id==this.userMessage.user.id && e.userId == authuser.id){
                        this.typing = e.user.name;
                    }
                    setTimeout(() => {
                        this.typing = '';
                    }, 3000);
                });
        },
        computed:{
            userList(){
               return this.$store.getters.userList
            },
            userMessage(){
               return this.$store.getters.userMessage
            }
        },
        created(){

        },
        methods:{
            dateTimeFormate(date){
               return moment(date).calendar();//today at 1:00pm
            },
            selectUser(userId){
                this.$store.dispatch('userMessage',userId)
            },
            sendMessage(e){
                e.preventDefault();
                if(this.message !=''){
                    axios.post('/message/store',{message: this.message,receiver_id:this.userMessage.user.id})
                        .then(response=>{
                            this.selectUser(this.userMessage.user.id)
                        })
                    this.message =''
                }

            },
            typingEvent(userId){
                Echo.private('typingevent')
                    .whisper('typing', {
                        'user': authuser,
                        'typing':this.message,
                        'userId':userId
                    });
            },
            deleteSingleMessage(message_id){
                axios.delete('/message/'+message_id)
                    .then(response=>{
                        this.selectUser(this.userMessage.user.id)
                    })
            },
            deleteAllMessage(){
                axios.delete('/message/'+this.userMessage.user.id+'/all')
                    .then(response=>{
                        this.selectUser(this.userMessage.user.id)
                    })
            }
        },
    }
</script>

<style scoped>

</style>