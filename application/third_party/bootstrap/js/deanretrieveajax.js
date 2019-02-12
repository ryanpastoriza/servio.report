function countMsg(type, msg, id1, id2) {
	$('.'+id1).html(0);
	$('.'+id2).html(0);
	$('.'+id1).html(msg);
	$('.'+id2).html(msg);

}

function addMsg(displayid, data, type) {
	$('#'+displayid).html("<ul class='menu'>"+data+"</ul>"); 
}


function waitForMsg() {
	$.ajax({
		type: "GET",
		url: 'deancountnotif.php',
		async: true,
		cache: false,
		success: function(data) {
			var count = 0;
			data = JSON.parse(data);
			$.each(data, function(k, v){
				var element =  "";
				$('ul#'+k+" li ul.menu").html(""); 	
				
				if(v.message.length >= 1){
					$.each(v.message, function(key, value){
						element = "";
						element += "<li>\
										<a href='#'>\
											<h4>\
												"+value.username+"\
											</h4> \
											<p> "+value.content+" </p>\
										</a>\
									</li>";
						
					// addMsg(k, element, k);
						$('ul#'+k+" li ul.menu").append(element); 
					})
				}
				countMsg("new", v.count, k, k+'-span');
			})
			setTimeout(function(){ 
				waitForMsg('deancountnotif.php'); 
			}, 10000);
		}
	});
}
   




	waitForMsg();
