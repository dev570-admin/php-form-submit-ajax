<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AJAX Form Submission</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<h2>Submit Form with AJAX and PHP</h2>
 
<form id="myForm" enctype="multipart/form-data">
  <label for="name">Name:</label><br>
  <input type="text" id="name" name="name"><br>
  <label for="email">Email:</label><br>
  <input type="text" id="email" name="email"><br>
  <label for="file">File:</label><br>
  <input type="file" id="file" name="file"><br><br>
  <input type="submit" value="Submit">
</form>

<div id="response"></div>

<script>
$(document).ready(function(){
  $('#myForm').submit(function(e){
    e.preventDefault(); // Prevent default form submission
    var formData = new FormData(this); // Create FormData object to handle file upload
    //var formData = $(this).serialize(); // Serialize form data
    var name = $('#name').val();
    var email = $('#email').val();
    
    // Simple form validation
    if(name == '' || email == '') {
      alert('Name and Email are required!');
      return;
    }

    $.ajax({
      type: 'POST',
      url: 'submit.php', // PHP script to handle form submission
      data: formData,
      contentType: false, // Don't set contentType
      processData: false, // Don't process the data
      success: function(response){
        $('#response').html(response); // Display response from submit.php
      }
    });
  });
});
</script>
</body>
</html>
