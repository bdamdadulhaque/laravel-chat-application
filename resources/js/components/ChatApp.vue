<template>
  <!-- begin chat container-->
  <div class="container-chat clearfix">
    <!-- begin user list-->
    <div class="user-list border" id="user-list">
      <div class="user-list-header">
        <strong>Users</strong>
      </div>
      <ul class="list">
        <li @click.prevent="userSelect(user.id)" v-for="(user, index) in userList" :key="index" class="clearfix">
          <div class="about">
            <div class="name">{{user.name}}</div>
          </div>
        </li>
      </ul>
    </div><!-- end user list -->
    <!-- begin chat -->
    <div class="chat border">
      <!-- begin chat header-->
      <div class="chat-header clearfix border-bottom">
        <div class="chat-about">
          <div v-if="userMessage.fetched_user" class="chat-with">{{userMessage.fetched_user.name}}</div>
        </div>
        <i class="fa fa-star"></i>
      </div> <!-- end chat-header -->
      <!-- begin chat history-->
      <div class="chat-history">
        <ul>
          <li v-for="message in userMessage.fetched_messages" :key="message.id" class="clearfix">
            <div :class="`message-data ${message.user.id == userMessage.fetched_user.id ? 'align-right':''}`">
              <span class="message-data-time" >{{new Date(message.created_at)}}</span> &nbsp; &nbsp;
              <span class="message-data-name" >{{message.user.name}}</span> <i class="fa fa-circle me"></i>
            </div>
            <div :class="`message ${message.user.id == userMessage.fetched_user.id ? 'other-message':'my-message'}`">
              {{message.message}}
            </div>
          </li>
        </ul>
      </div> <!-- end chat-history -->
      <!-- begin chat type box-->
      <div v-if="clickedUser == true" class="chat-message clearfix border">
        <textarea @keydown.enter="sendMessage" v-model="message" name="message-to-send" id="message-to-send" placeholder ="Type your message" rows="3"></textarea>
        <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
        <i class="fa fa-file-image-o"></i>
        <button @click.prevent="sendMessage">Send</button>
      </div> <!-- end chat type box -->
      <!-- begin button-->
      <div v-if="nonClicked == true" class="chat-message text-center">
        <strong>Click on a user from left to send message</strong>
      </div><!-- end button -->
    </div> <!-- end chat -->
  </div> <!-- end chat container -->
</template>
<script>
// import axios
import Axios from 'axios'
export default {
  // mounted
  mounted() {
    // realtime chat
    Echo.private(`chat.${authUser.id}`) // chat is channel name   // authUser declared in 'views/layouts/app.blade.php file
    .listen('MessageSend', (e) => {
      this.userSelect(e.message.from) // passing realtime message
    })
    // dispatch user list to action
    this.$store.dispatch('userList')
  },
  // data
  data(){
    return {
      message:'',
      clickedUser: false,
      nonClicked: true
    }
  },
  // computed
  computed: {
    // user list
    userList(){
      return this.$store.getters.userList
    },
    // user message
    userMessage(){
      return this.$store.getters.userMessage
    }
  },
  // methods
  methods: {
    // when click on individual user from list
    userSelect(userId){
      this.clickedUser = true
      this.nonClicked = false
      this.$store.dispatch('userMessage', userId)
    },
    // message send to other user
    sendMessage(e){
      e.preventDefault()
      if(this.message != ''){
        Axios.post('message-send', {message:this.message, user_id:this.userMessage.fetched_user.id})
        .then(response => {
          this.userSelect(this.userMessage.fetched_user.id)
        })
        this.message = ''
      }
    }
  }
}
</script>
<style lang="scss" scoped>
  @import url(https://fonts.googleapis.com/css?family=Lato:400,700);

  $green: green;
  $blue: blue;
  $orange: orange;
  $gray: gray;

  *, *:before, *:after {
    box-sizing: border-box;
  }
  // main chat container
  .container-chat {
    margin: 0 auto;
    width: 750px;
    border-radius: 5px;
  }
//  user list
  .user-list {
    width:260px;
    height: 620px;
    float: left;
    background-color:#F2F5F8;

    .user-list-header {
      padding: 20px;
      border-bottom: 2px solid white; 
    }
    
    input {
      border-radius: 3px;
      border: none;
      padding: 14px;
      width: 90%;
      font-size: 14px;
    }
    
    ul {
      padding: 20px;
      height: 505px;
      
      li {
        padding-bottom: 20px;
        list-style: none;
        cursor: pointer;
      }
    }
    
    .about {
      float: left;
      margin-top: 8px;
      padding-left: 8px;
    }
  
  }
  
  // chat
  .chat {
    width: 490px;
    height: 620px;
    float:left;
    background: white;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    color: #434651;

    .chat-header {
      padding: 20px;
      border-bottom: 2px solid white;  
      img {
        float: left;
      }
      .chat-about {
        float: left;
        padding-left: 10px;
        margin-top: 6px;
      }
      .chat-with {
        font-weight: bold;
        font-size: 16px;
      }
      .chat-num-messages {
        color: $gray;
      }
      .fa-star {
        float: right;
        color: #D8DADF;
        font-size: 20px;
        margin-top: 12px;
      }
    }
    
    // chat history
    .chat-history {
      padding: 20px 20px 10px;
      border-bottom: 2px solid white;
      overflow-y: auto;

      .message-data {
        margin-bottom: 15px;
      }
      
      .message-data-time {
        color: lighten($gray, 8%);
        padding-left: 6px;
      }
      
      // message
      .message {      
        color: white;
        padding: 18px 20px;
        line-height: 26px;
        font-size: 16px;
        border-radius: 7px;
        margin-bottom: 30px;
        width: 90%;
        position: relative;
        
        &:after {
          bottom: 100%;
          left: 7%;
          border: solid transparent;
          content: " ";
          height: 0;
          width: 0;
          position: absolute;
          pointer-events: none;
          border-bottom-color: $green;
          border-width: 10px;
          margin-left: -10px;
        }
      }
      // my message
      .my-message {
        background: $green;
      }
      
      // other message
      .other-message {
        background: $blue;
        
        &:after {
          border-bottom-color: $blue;
          left: 93%;
        }
      }
      ul li {
        list-style: none;
      }
      
    }
    
    // chat message
    .chat-message {
      padding: 30px;
      
      textarea {
        width: 100%;
        border: 1px solid gray;
        padding: 10px 20px;
        font: 14px/22px "Lato", Arial, sans-serif;
        margin-bottom: 10px;
        border-radius: 5px;
        resize: none;
      }
      
      .fa-file-o, .fa-file-image-o {
        font-size: 16px;
        color: gray;
        cursor: pointer;
      }
      
      button {
        float: right;
        color: $blue;
        font-size: 16px;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        font-weight: bold;
        background: #F2F5F8;
        
        &:hover {
          color: darken($blue, 7%);
        }
      }
    }
  }

  .me {
    color: $blue;
  }

  .align-left {
    text-align: left;
  }

  .align-right {
    text-align: right;
  }

  .float-right {
    float: right;
  }

  .clearfix:after {
    visibility: hidden;
    display: block;
    font-size: 0;
    content: " ";
    clear: both;
    height: 0;
  }
</style>