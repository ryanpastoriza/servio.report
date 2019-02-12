var refreshMessagesCount = setInterval(getMessagesCount, 15000);
function getMessagesCount(){
clearInterval(refreshMessagesCount);
  $.ajax({
        url: 'messageCountNotif.php',
        async: true,
        cache: false,
        success: function(data) {
           $('#count').html(data);
		        $('#count_1').html(data);
			refreshMessagesCount = setInterval(getMessagesCount, 1000);
        }
    });
}

getMessagesCount();