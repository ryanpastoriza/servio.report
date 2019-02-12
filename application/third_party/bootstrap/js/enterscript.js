$(document).ready(function() {
$('#message').keydown(function() {
var message = $("#message").val();
var key = e.which;
if (key == 13) {
if (message == "") {
alert("Message is missing");
} else {
$('#message').submit();
}
return false;
}
});
});