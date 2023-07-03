$("#reminder").change(function() {
  if(this.checked) {
      $("#reminder_desc").prop('disabled', false);
  }else
  {
      $("#reminder_desc").prop('disabled', true);
  }
});