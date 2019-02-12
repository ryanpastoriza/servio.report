var refreshMessages = setInterval(getMessages, 15000);
function getMessages(){
clearInterval(refreshMessages);
  $.ajax({
        url: 'messageNotif.php',
        async: true,
        cache: false,
		dataType: "JSON",
        success: function(data) {
            $('.messageNotification').html("");
            for(var x = 0; x < data['msg'].length; x++){
                $('.messageNotification').append(data['msg'][x]);
            }
            refreshMessages = setInterval(getMessages, 10000);
        }
    });
}

getMessages();