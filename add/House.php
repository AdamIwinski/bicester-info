<?php
require_once "../connect.php";

include "file-upload.php";

if(isset($_POST['nrOfBedrooms']) && (empty($_POST['fromWhen']))){
  mysqli_report(MYSQLI_REPORT_STRICT);
  
    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);

      $nrOfBedrooms = mysqli_real_escape_string($connection, $_POST['nrOfBedrooms']);
      $description = mysqli_real_escape_string($connection, $_POST['description']);
      $email = mysqli_real_escape_string($connection, $_POST['email']);
      $phone = mysqli_real_escape_string($connection, $_POST['telephone']);

      if($connection -> connect_errno!=0)
        {
          throw new Exception(mysqli_connect_errno());
        }
        else
        {
          if($connection->query(sprintf("INSERT INTO `freehouses` (`id`, `nrOfBedrooms`, `description`, `email`, `phone`) VALUES (NULL, '$nrOfBedrooms','$description','$email','$phone')")))
          {
            $_SESSION['createHouse'] = true;
            header('Location: ../success.php');
            exit();
          }
          else{
            throw new Exception($connection->error);
          }
        
          $connection->close();
        }
    }
    catch(Exception $e)
    {
      echo '<span style="color:red;">error</span>';
      echo'<br> informacja dev:'.$e;
    }  

}
else if(isset($_POST['nrOfBedrooms']) && (!empty($_POST['fromWhen']))){

  if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK)
  {

    // get details of the uploaded file
    $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
    $fileName = $_FILES['fileUpload']['name'];
    $fileSize = $_FILES['fileUpload']['size'];
    $fileType = $_FILES['fileUpload']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
    
    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directory in which the uploaded file will be moved
      $uploadFileDir = 'uploaded_files/';
      $dest_path = $uploadFileDir . $newFileName;
    }

  mysqli_report(MYSQLI_REPORT_STRICT);
      try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);

      $nrOfBedrooms = mysqli_real_escape_string($connection, $_POST['nrOfBedrooms']);
      $houseType = mysqli_real_escape_string($connection, $_POST['houseType']);
      $fromWhen = mysqli_real_escape_string($connection, $_POST['fromWhen']);
      $postcode = mysqli_real_escape_string($connection, $_POST['postcode']);
      $lon = mysqli_real_escape_string($connection, $_POST['lon']);
      $lat = mysqli_real_escape_string($connection, $_POST['lat']);
      $agencyPrivate = mysqli_real_escape_string($connection, $_POST['agencyPrivate']);
      $per = mysqli_real_escape_string($connection, $_POST['per']);
      $price = mysqli_real_escape_string($connection, $_POST['price']);
      $Furnished = mysqli_real_escape_string($connection, $_POST['Furnished']);
      $desc = mysqli_real_escape_string($connection, $_POST['description']);
      // images
      // $dest_path;
      // img
      $email = mysqli_real_escape_string($connection, $_POST['email']);
      $phone = mysqli_real_escape_string($connection, $_POST['telephone']);

      if($connection -> connect_errno!=0)
        {
          throw new Exception(mysqli_connect_errno());
        }
        else
        {
          if($connection->query(sprintf("INSERT INTO `houses` (`id`, `nrOfBedrooms`, `houseType`, `fromWhen`, `postcode`, `lon`, `lat`, `agencyPrivate`, `per`, `price`, `Furnished`, `mainPic`, `description`, `email`, `phone`) VALUES (NULL, '$nrOfBedrooms','$houseType', '$fromWhen', '$postcode', '$lon', '$lat','$agencyPrivate','$per','$price','$Furnished','$dest_path','$desc','$email','$phone')")))
          {
            $_SESSION['createHoom'] = true;
            header('Location: ../success.php');
            exit();
          }
          else{
            throw new Exception($connection->error);
          }
        
          $connection->close();
        }
    }
    catch(Exception $e)
    {
      echo '<span style="color:red;">error</span>';
      echo'<br> informacja dev:'.$e;
    }  
  }}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>title</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="apple-touch-icon" href="../assets/favicon.ico"/>

    <!-- Core theme CSS includes Bootstrap-->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/bootstrap-side-modals.css">
    <link rel="stylesheet" href="../css/style.css">

    <!-- Google Fonts -->

  </head>
  <body>
    <!-- Responsive navbar-->

    <!-- Page content-->
<div class="container">
  <div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="free"checked>
  <label class="form-check-label" for="free">
    free
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="paid">
  <label class="form-check-label" for="paid">
    paid
  </label>
</div>

    <h2>Accommodation to let</h2>
    <form enctype="multipart/form-data" id="house" method="POST" class="needs-validation" novalidate autocomplete="off">
    
      <div class="form-group">
        <label for="noBedrooms">Number of bedrooms</label>
        <input type="number" class="form-control" id="noBedrooms" aria-describedby="noBedrooms" name="nrOfBedrooms" required autocomplete="nope" min="0" step="1" value="1" required>
        <div class="invalid-feedback">Please select the number of rooms.</div>
      </div>


      <div class="form-group paid">
        <label for="noBedrooms">Accommodation Type</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="houseType" id="single" required checked value="House">
        <label class="form-check-label" for="single"> 
          House
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="houseType" id="Single en-suite" required value="Flat">
        <label class="form-check-label" for="Single en-suite">
          Flat
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="houseType" id="double" required value="Bungalow">
        <label class="form-check-label" for="double" >
          Bungalow
        </label>
      </div>
      </div>

      <div class="form-group paid">
        <label for="fromWhen">From When</label>
        <input type="date" class="form-control" id="fromWhen" aria-describedby="fromWhen" name="fromWhen" class="required" required >
        <div class="invalid-feedback">Please choose date.</div>
      </div>

      <div class="form-group paid">
        <label for="postcode">Post Code</label>
        <input type="text" class="form-control" id="postcode" aria-describedby="postcode" name="postcode" required autocomplete="nope" pattern="^([A-Za-z][A-Ha-hJ-Yj-y]?[0-9][A-Za-z0-9]? ?[0-9][A-Za-z]{2}|[Gg][Ii][Rr] ?0[Aa]{2})$">
        <div class="invalid-feedback">Please provide a valid Post Code.</div>
        <!-- long lat from postcode.io -->
        <input id="lon" name="lon" style="visibility:hidden; position:absolute"></input>
        <input id="lat" name="lat" style="visibility:hidden; position:absolute"></input>
      </div>

      <div class="form-group paid">
        <label for="agencyPrivate">Agency/Private</label>
          <select class="form-select" aria-describedby="agencyPrivate"  name="agencyPrivate" required>
            <option value="Agency" >Agency</option>
            <option value="Private" selected>Private</option>
          </select>
      </div>

      <div class="form-group paid">
        <label for="inputState">Per:</label>
          <select class="form-select" aria-describedby="Salary type"  name="per" required>
            <option value="day" selected>day</option>
            <option value="week">week</option>
            <option value="month" selected>month</option>
            <option value="other">other</option>
          </select>
      </div>

      <div class="form-group paid">
          <label for="inputState">Price</label>
          <div class="input-group">
            <span class="input-group-text">£</span>
            <input id="price" type="number" id ="price" class="form-control" aria-describedby="price" placeholder="Price" name="price" class="required" required min="0" step="1">
              <div class="invalid-feedback">Positive numbers only</div>
        </div>
      </div>

      <div class="form-group paid">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="Furnished" id="Furnished" required checked value="Furnished">
        <label class="form-check-label" for="Furnished"> 
          Furnished
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="Furnished" id="Un-furnished" required value="Un-furnished">
        <label class="form-check-label" for="Un-furnished">
          Un-furnished
        </label>
      </div>
      </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea class="form-control" id="description" rows="3"  name="description" class="required" required maxlength="5000" minlength="25" placeholder="25 - 5000 characters." autocomplete="nope" aria-describedby="Description"></textarea>
          <div class="invalid-feedback"> 25-5000 characters.</div>
        </div>
            
        <div class="mb-3 paid">
          <label for="formFile" class="form-label">Main Picture:</label>
          <input class="form-control" type="file" id="formFile" name="fileUpload" required>
          <div class="imgGallery text-center">
          <!-- image preview -->
        </div> 
      </div>


      <h2>How to apply</h2>
      <div class="form-group">
        <label for="E-mail" class="form-label">Email address</label>
        <input type="e-mail" class="form-control" id="e-mail" aria-describedby="e-mail" name="email" required autocomplete="nope" pattern="^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$">
        <div class="invalid-feedback">Please provide correct email address.</div>
      </div>


      <div class="form-group">
        <label for="telephone" class="form-label">Telephone</label>
        <input type="tel" class="form-control" id="telephone" aria-describedby="telephone" name="telephone" required autocomplete="nope" pattern="[0-9]{11}">
        <div class="invalid-feedback">Please provide Telephone number.</div>
      </div>


      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="tc" required >
        <label class="form-check-label" for="exampleCheck1" >I have read and agree to the Bicester Info <a href="#" target="_blank">terms and conditions</a>.</label>
        <div class="invalid-feedback">You must agree before submitting.</div>
      </div>


      <button type="submit" class="btn btn-primary" name="submit" >Submit</button>


    </form>
    </div>

    <!-- End Page content -->

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

  	<!-- jQuery -->
	  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/dd12015ad5.js" crossorigin="anonymous"></script>

    <!-- postcode -->
  <script src="jspostcode.js"></script>

  <script>

  // Bootstrap Validation
  (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
          .forEach(function (form) {
            form.addEventListener('submit', function (event) {
              if ((!form.checkValidity()) || (value!=true)){
                document.getElementById("postcode").classList.remove('was-validated');
                event.preventDefault()
                event.stopPropagation()
              }

              form.classList.add('was-validated')
            }, false)
          })
      })();
  </script>

  <script>
  // formating post code
  $('#postcode').on('blur', function(e) {
      // e.preventDefault();
    $('#postcode').val(checkPostCode($('#postcode').val()));
    });

  $('#input').on('blur', function(e) {
	$('#input').val(formatPostcode($('#input').val()));
});

  // Checking if post code is valid and getting longitude and latitude from postcode.io API
  $('#postcode').blur(function(e) {
    e.preventDefault();
    var postCode = $("#postcode").val();

    $.ajax({
      url: 'https://api.postcodes.io/postcodes/'+postCode,
      dataType: 'jsonp',
      success: function(json) {
      // console.log(json.status);
        if (json.status = 200){
          var valid = true;
          var lon = json.result.longitude;
          var lat = json.result.latitude;
          // console.log("post code OK");
          // console.log(lon);
          // console.log(lat);
          $('#lon').val(lon);
          $('#lat').val(lat);
        }else {
          // console.log("post code NOK");
        };
      
      },
      fail: function() {
        alert('ajax fail');
      }
    });
  });
  
  // remove leading 0's from currency input and moving dot for 2 places left

window.addEventListener('load', (event) => {
        $('.paid').hide();
        document.getElementById("fromWhen").removeAttribute("required");
        document.getElementById("postcode").removeAttribute("required");
        document.getElementById("price").removeAttribute("required");
        document.getElementById("pictures").removeAttribute("required");
});
    $('#paid').on('click', function(){
        $('.paid').show();
        document.getElementById("fromWhen").setAttribute("required", true);
        document.getElementById("postcode").setAttribute("required",true);
        document.getElementById("price").setAttribute("required",true);
        document.getElementById("pictures").setAttribute("required",true);
    });
    $('#free').on('click', function(){
        $('.paid').hide();
        document.getElementById("fromWhen").removeAttribute("required");
        document.getElementById("postcode").removeAttribute("required");
        document.getElementById("price").removeAttribute("required");
        document.getElementById("pictures").removeAttribute("required");
    });

    $('#pictures').on('click', function(){
            var list = document.getElementsByClassName("img");
            for(var i = list.length - 1; 0 <= i; i--)
            if(list[i] && list[i].parentElement)
            list[i].parentElement.removeChild(list[i]);
    });

    
    $(function () {
    // Multiple images preview with JavaScript
    var multiImgPreview = function (input, imgPreviewPlaceholder) {

      if (input.files) {
        var filesAmount = input.files.length;

        for (i = 0; i < filesAmount; i++) {
          var reader = new FileReader();

          reader.onload = function (event) {
            $($.parseHTML('<img class="img">')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
          }

          reader.readAsDataURL(input.files[i]);
        }
      }

    };

    $('#chooseFile').on('change', function () {
      multiImgPreview(this, 'div.imgGallery');
    });
  });
  </script>
  </body>
</html>