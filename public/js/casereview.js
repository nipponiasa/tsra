document.getElementById("messageToOutlook").addEventListener("click", function() {
    var emailLink = "mailto:";
    emailLink += "?subject=" + encodeURIComponent(document.getElementById("emailsubject").value);
    emailLink += "&body=" + encodeURIComponent(document.getElementById("emailbody").value);

    // emailLink += "&attachment=" + encodeURIComponent("https://lh3.googleusercontent.com/a-/AOh14GgNSEq1Zp7vNLUscaEcvEXWOEWQpLybI5YU1dBCMA");
  
    window.location.href = emailLink;
  });


document.getElementById('status').addEventListener('change', function() { 
    document.getElementById('donotmail').checked = false;
});


document.getElementById('pills-messaging-tab').addEventListener('click', function() {
    if (!document.getElementById("emailbody").value) {
        document.getElementById("emailbody").value = document.getElementById("description").value + '\n' + '\n' + document.getElementById("notes").value;
    }
});