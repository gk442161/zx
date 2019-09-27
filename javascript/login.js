
    // AJAX code to check input field values when onblur event triggerd.
     
        const login_button=document.getElementById('sbt');
        login_button.addEventListener('click',function(e){
            
            e.preventDefault();
            
            alert('you are in eventlistner');

                var xmlhttp;
                if (window.XMLHttpRequest) { // for IE7+, Firefox, Chrome, Opera, Safari
                    
                xmlhttp = new XMLHttpRequest();
                } else { // for IE6, IE5
                    alert('now you are in else');
                     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState != 4 && xmlhttp.status == 200) {
                        alert('now you are in if');
                            $('#sbt').hide();
                            $('#sbt').after("<p id='validating'>Validating..</p>");
                                    }
                     else if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        alert('now you are in elseif');
                                                        switch(parseInt(xmlhttp.responsetext)){
                                                            case 11: window.open('doctor','_self');
                                                                        break;
                                                            case 10:  window.open('patient','_self');
                                                                        break ;
                                                            default:    $('#validating').hide();
                                                                        $('#sbt').show();               
                                                            
                                                                    }
                                                         } 
                        else {
                                 alert("Error Occurred. <a href='index.php'>Reload Or Try Again</a> the page.");
                                 }
                                 alert('now you are in open');            
                 xmlhttp.open("POST", "login.php", false);
                 alert('now you are in data');
                 xmlhttp.setRequestHeader('Constent-type',)
                 var data={ "username": $('#username').val(), "password": $('#password').val() }
                 alert('now you are in send');
                 xmlhttp.send(data);
             }
            

        });
          
        //  $.ajax({
        //     url: 'users.php',
        //     dataType: 'json',
        //     type: 'post',
        //     contentType: 'application/json',
        //     data:{ "username": $('#username').val(), "password": $('#password').val() } ,
        //     processData: false,
        //     success: function( data, textStatus, jQxhr ){
        //         alert(data);
        //         switch(parseInt(data)){
        //         case 11: window.open('doctor','_self');
        //                     break;
        //         case 10:  window.open('patient','_self');
        //                     break ;
        //         default:    $('#validating').hide();
        //                     $('.submit').show();               
        //                     }
        //                 },
        //     error: function( jqXhr, textStatus, errorThrown ){
        //         console.log( errorThrown );
        //     }
        // });