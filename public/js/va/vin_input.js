$(document).ready(function(){
    var maxField = 21; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var x = 1; //Initial field counter is 1

  
  
   
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 

      
          // alert("#vin"+x-1 );
   //ajax
        var vintimi=$("#vin" + x).val()
        //alert(vintimi); 
        if(vintimi!=''){
                               $.get('/technical_reports/fetch_model_for_vin', {vin: vintimi}, function (model_ajax, textStatus, jqXHR) {

                 
                                $.each(model_ajax, function (index, value) {
                                    // alert(value[0].model_desc); 
                                    $("#model_desc" + (x-1)).text(value[0].model_desc);
                                  // alert(value[0].model_desc );
                                });
                                //alert(JSON.stringify(model_ajax['model_desc']));
                                 //console.log(model_ajax.data) 

                            }
                                        

                        );

                    }



                    x++; //Increment field counter
                    var fieldHTML = '<div><input type="text" placeholder="VIN" name="vin_table[]" id="vin' + x + '" value=""/><input type="text"  placeholder="Distance(km)" name="distance_table[]" id="distance' + x + '" value=""/><a href="javascript:void(0);" class="remove_button"><img src="/img/remove-icon.png"/></a><p id="model_desc' + x + '"></p></div>'; //New input field html 
                    $(wrapper).append(fieldHTML); //Add field html
                }
    //ajax
   
   
   
   
   
   
   
   
   
   
   
   
   
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
