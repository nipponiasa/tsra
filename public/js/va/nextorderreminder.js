$("#nextorderreminder").change(function() {
  if(this.checked) {
      $("#nextorderremindert").prop('disabled', false);
  }else
  {
      $("#nextorderremindert").prop('disabled', true);
  }
});