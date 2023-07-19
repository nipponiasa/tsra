$("#reminder").on('change', function() {
    if(this.checked) {
        $("#reminder_desc").prop('disabled', false);
    }else
    {
        $("#reminder_desc").prop('disabled', true);
    }
});

function placeCategorization(){
    $("#category").val(storedCategory);
    $("#issue").val(storedIssue);
    $("part").val(storedPart);
}




document.getElementById('pills-messaging-tab').addEventListener('click', function() {
    if (!document.getElementById("emailbody").value) {
        document.getElementById("emailbody").value = document.getElementById("description").value + '\n' + '\n' + document.getElementById("notes").value;
    }
});

document.getElementById('status').addEventListener('change', function() { 
    document.getElementById('donotmail').checked = false;
});


$('form').on('submit', function() {     //after correct validation, before submit
    $('.spinner').removeClass('d-none');
});






document.getElementById("messageToOutlook").addEventListener("click", function() {
    let emailLink = "mailto:";
    emailLink += "?subject=" + encodeURIComponent(document.getElementById("emailsubject").value);
 
    // let attachmentsString = '<br><br>'; 
    // [...document.querySelectorAll('#attachmentsDiv input:checked')].forEach(photo=>{
    //     attachmentsString += `<a href="${photo.dataset.url}">${photo.value}</a>`;
    // });
    // console.log(attachmentsString);

    emailLink += "&body=" + encodeURIComponent(document.getElementById("emailbody").value);

    // emailLink += "&attachment=" + encodeURIComponent("https://lh3.googleusercontent.com/a-/AOh14GgNSEq1Zp7vNLUscaEcvEXWOEWQpLybI5YU1dBCMA");
  
    window.location.href = emailLink;
  });








