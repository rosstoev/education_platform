export function countUnreadMessages(urlUnreadMessages)
{
    $.ajax({
        method: "POST",
        url: urlUnreadMessages,
        timeout: 2000,
        success: function (data) {
            $('#unread-messages-badge').html(data.result);
        }
    });
}