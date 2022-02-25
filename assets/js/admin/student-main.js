import {countUnreadMessages} from "./functions";

$(document).ready(function (){
    const urlUnreadMessages = '/student/messenger/ajax/unread-messages';
    countUnreadMessages(urlUnreadMessages);
})