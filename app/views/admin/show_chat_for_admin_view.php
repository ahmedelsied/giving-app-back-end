<style>
.chat_content_parent{
    position: relative;
    margin-right:225px;
}
.chat_action_parent ul{
    position: absolute;
    width: 250px;
    background-color: #292838;
    font-size: 16px;
    display: none;
}
.chat_action_parent ul li{
    padding: 5px;
    cursor: pointer;
}
.chat_action_parent ul li:hover{
    background-color: #1e1e29;
}
.chat_content .user_one,.chat_content .user_two{
    width: 100%;
}
.chat_content_parent .chat_content{
    height: fit-content;
    width:100%;
    display: inline-block;
}
.chat_content_parent .chat_content .avatar{
    float: inherit;
    color:black;
    width: 50px;
    height: 50px;
    font-size: 18px;
    padding-top: 12px;
    margin:10px
}
.chat_content_parent .chat_content .user_one p{
    background-color: #4c61d5;
    color: white;
}
.chat_content_parent .chat_content .user_two p{
    background-color: white;
    color: #4C61D5;
    -webkit-box-shadow: 1px 1px 10px #dadada;
    -moz-box-shadow: 1px 1px 10px #dadada;
    -o-box-shadow: 1px 1px 10px #dadada;
    -ms-box-shadow: 1px 1px 10px #dadada;
    box-shadow: 1px 1px 10px #dadada;
}
.chat_content_parent .chat_content .msg-content{
    max-width: 50%;
    border-radius: 50px;
    margin-top: 34px;
    padding: 15px;
    float : inherit
}
</style>
<?php $this->fire_component("chat_content") ?>