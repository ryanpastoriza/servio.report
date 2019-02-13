$(document).ready(function(){

   $.ajax({
      url : "print_queue_func.php",
      type : 'POST',
      dataType : 'JSON',
      data : {action : 'view'},

    success: function(result){
    $("#dive").html(result);
    }});

 // })

   // console.log(url)
   //    $.getJSON('print_queue.php', function(data) {
   //          console.log(data)

   //        $.each(data, function(index, data) {
   //          // console.log(data)
   //         // $('#tablebody').append('<tr>');
   //         // $('#tablebody').append('<td>'+data.employee_fname+'</td>');
   //         // $('#tablebody').append('<td>'+data.subject_name+'</td>');
   //         // $('#tablebody').append('<td>'+data.psubject_name+'</td>');
   //         // $('#tablebody').append('</tr>');
   //        });
 
   // });
});
                  

// alert("Ss")