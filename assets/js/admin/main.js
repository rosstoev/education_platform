import {countUnreadMessages} from "./functions";

$(document).ready(function (){
    const urlUnreadMessages = '/teacher/messenger/ajax/unread-messages';
    countUnreadMessages(urlUnreadMessages);
})