        function addmsg(type, msg) {

            $('#count').html(msg);

            $('#count_1').html(msg);

        }

        $(document).ready(function() {

        waitForMsg();

        });

        function waitForMsg() {

            $.ajax({
                type: "GET",
                url: "printqueuenotif.php",

                async: true,
                cache: false,
                timeout: 50000,

                success: function(data) {

                    addmsg("new", data);

                    setTimeout(function(){ 

                        waitForMsg(); 
                    }, 10000);
                }
            });
        };

        