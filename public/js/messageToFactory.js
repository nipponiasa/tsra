document.getElementById("messageToFactory").addEventListener("click", function() {
    var emailLink = "mailto:development@computerstudio.gr";
    emailLink += "?subject=" + encodeURIComponent("New Case");
    emailLink += "&body=" + encodeURIComponent('This is the body of the email');
    emailLink += "&attachment=" + encodeURIComponent("https://lh3.googleusercontent.com/a-/AOh14GgNSEq1Zp7vNLUscaEcvEXWOEWQpLybI5YU1dBCMA");
  
    window.location.href = emailLink;
  });