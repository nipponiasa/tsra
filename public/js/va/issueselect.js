// multiple selects
         function updateissue2()
         {
            $("#issue2").empty();
            $("#issue2").append(new Option("Select Issue",""));
            $("#issue2").prop('disabled', true);
            $("#issue3").empty();
            $("#issue3").append(new Option("Specify More",""));
            $("#issue3").prop('disabled', true);
            var issue1timi=$("#issue1").val()
            
            if(issue1timi!=0){
                                   $.get('/technical_reports/fetch_select_children', {parent: issue1timi}, function (data, textStatus, jqXHR) {
                                        //alert($("#issue1 option:selected" ).text());
                                        if($("#issue1 option:selected" ).text()!="")
                                            {
                                                        $("#issue2").prop('disabled', false);
                                                        //console.log(JSON.stringify(data.data));
                                                        $.each( data.data, function( id, value )
                                                                {
                                                                $("#issue2").append(new Option(value.issuename,value.id));
                                                                }
                                                            );
                                            }
                                }
                                            

                            );

                        }
            }


		



            function updateissue3()
         {
            $("#issue3").empty();
            $("#issue3").append(new Option("Specify More",""));
            $("#issue3").prop('disabled', true);
            var issue2timi=$("#issue2").val()
            
            if(issue2timi!=0){
                                   $.get('/technical_reports/fetch_select_children', {parent: issue2timi}, function (data, textStatus, jqXHR) {
                                        //alert($("#issue1 option:selected" ).text());
                                        if($("#issue2 option:selected" ).text()!="")
                                            {
                                                        $("#issue3").prop('disabled', false);
                                                        //console.log(JSON.stringify(data.data));
                                                        $.each( data.data, function( id, value )
                                                                {
                                                                $("#issue3").append(new Option(value.issuename,value.id));
                                                                }
                                                            );
                                            }
                                }
                                            

                            );

                        }
            }



            function check() {
               if($("#claim_approved2").prop( "checked", true )){
   $("#claim_approved2").val()="1";
                 }else{$("#claim_approved").val()="0";}

}












//multiple selects-->