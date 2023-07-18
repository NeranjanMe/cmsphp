<!DOCTYPE html>
<html>
<body>

<h2>Create Content</h2>

<form id="generate-content-form">
  <label for="keyword">Keyword:</label><br>
  <input type="text" id="keyword" name="keyword"><br>
  <input type="submit" value="Generate">
</form>

<h2>Generated Content</h2>

<textarea id="generated-content" rows="4" cols="50"></textarea>
<button id="copy-button">Copy to Clipboard</button>

<!-- Spinner -->
<div id="spinner" style="display: none;">
  <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
  $("#generate-content-form").submit(function(e){
    e.preventDefault();

    $('#spinner').show();

    $.ajax({
      url: '../generate/generate_content.php',
      type: 'post',
      data: {keyword: $('#keyword').val()},
      success: function(data) {
        var response = JSON.parse(data);
        $('#generated-content').val(response.content);
        $('#spinner').hide();
      },
      error: function() {
        alert('Failed to generate content');
        $('#spinner').hide();
      }
    });
  });

  $("#copy-button").click(function(){
    /* Get the text field */
    var copyText = document.getElementById("generated-content");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */
    alert("Copied the text: " + copyText.value);
  });
});
</script>

<style>
.lds-ring {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 64px;
  height: 64px;
  margin: 8px;
  border: 8px solid #000;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #000 transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>

</body>
</html>
