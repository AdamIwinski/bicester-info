<?php

if(isset($_POST['reg'])){
      
  $reg = $_POST["reg"];

  $url = "https://driver-vehicle-licensing.api.gov.uk/vehicle-enquiry/v1/vehicles";

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  $headers = array(
    "x-api-key: 3xaMfzMC5E7Nvd72vZPFJ20aMnsYJ1VY9GOGZMlG",
    "Content-Type: application/json",
  );

  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

  $data = '{"registrationNumber" : "'.$reg.'"}';

  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

  $resp = curl_exec($curl);
  curl_close($curl);
  // print_r($resp);
  $resp = json_decode($resp, true);
  $reg = $resp['registrationNumber'];
  $cc = $resp['engineCapacity'];
  $fuelType = $resp['fuelType'];
  $motStatus = $resp['motStatus'];
  $colour = $resp['colour'];
  $make = $resp['make'];
  $yearOfManufacture = $resp['yearOfManufacture'];
  $monthOfFirstRegistration = $resp['monthOfFirstRegistration'];
  $dateOfLastV5CIssued = $resp ['dateOfLastV5CIssued'];
  $motExpiryDate = $resp ['motExpiryDate'];
}
require_once "../connect.php";

include "file-upload.php";

if(isset($_POST['jobTitle']) && (empty($_POST['registration']))){
  mysqli_report(MYSQLI_REPORT_STRICT);

    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);

      $jobTitle = mysqli_real_escape_string($connection, $_POST['jobTitle']);
      $desc = mysqli_real_escape_string($connection, $_POST['description']);
      $email = mysqli_real_escape_string($connection, $_POST['email']);
      $phone = mysqli_real_escape_string($connection, $_POST['telephone']);

      if($connection -> connect_errno!=0)
        {
          throw new Exception(mysqli_connect_errno());
        }
        else
        {
          if($connection->query(sprintf("INSERT INTO `freecars` (`id`, `jobTitle`, `desc`, `email`, `phone`) VALUES (NULL, '$jobTitle','$desc','$email','$phone')")))
          {
            $_SESSION['createJob'] = true;
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
else if(isset($_POST['jobTitle']) && (!empty($_POST['registration']))){
echo "dziala2";
    if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK)
  {
    ;
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

      $jobTitle = mysqli_real_escape_string($connection, $_POST['jobTitle']);
      $registration = mysqli_real_escape_string($connection, $_POST['registration']);
      $desc = mysqli_real_escape_string($connection, $_POST['description']);
      $cc = mysqli_real_escape_string($connection, $_POST['cc']);
      $fuelType = mysqli_real_escape_string($connection, $_POST['fuelType']);
      $yearOfManufacture = mysqli_real_escape_string($connection, $_POST['yearOfManufacture']);
      $motStatus = mysqli_real_escape_string($connection, $_POST['motStatus']);
      $colour = mysqli_real_escape_string($connection, $_POST['colour']);
      $make = mysqli_real_escape_string($connection, $_POST['make']);
      $monthOfFirstRegistration = mysqli_real_escape_string($connection, $_POST['monthOfFirstRegistration']);
      $dateOfLastV5CIssued = mysqli_real_escape_string($connection, $_POST['dateOfLastV5CIssued']);
      $motExpiryDate = mysqli_real_escape_string($connection, $_POST['motExpiryDate']);
      $price = mysqli_real_escape_string($connection, $_POST['price']);
      $email = mysqli_real_escape_string($connection, $_POST['email']);
      $phone = mysqli_real_escape_string($connection, $_POST['telephone']);
      

      if($connection -> connect_errno!=0)
        {
          throw new Exception(mysqli_connect_errno());
        }
        else
        {
          if($connection->query(sprintf("INSERT INTO `cars` (`id`, `jobTitle`, `registration`, `description`, `cc`, `fuelType`, `yearOfManufacture`, `motStatus`, `colour`, `make`, `monthOfFirstRegistration`, `dateOfLastV5CIssued`, `motExpiryDate`,`price`, `email`, `phone`, `mainPic`) VALUES (NULL, '$jobTitle','$registration', '$desc', '$cc', '$fuelType', '$yearOfManufacture','$motStatus','$colour','$make','$monthOfFirstRegistration','$dateOfLastV5CIssued','$motExpiryDate','$price','$email','$phone','$dest_path')")))
          {
            $_SESSION['createJob'] = true;
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
      // echo'<br> informacja dev:'.$e;
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
<div class="container">
  <div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="free">
  <label class="form-check-label" for="free">
    basic
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="paid" checked>
  <label class="form-check-label" for="paid">
    advanced
  </label>
</div>

<!-- <div class="custom-control custom-radio">
  <input type="radio" id="free" name="free" class="free" checked>
  <label class="custom-control-label" for="customRadio1">Free advert</label>
</div>
<div class="custom-control custom-radio">
  <input type="radio" id="paid" name="paid" class="premium">
  <label class="custom-control-label" for="customRadio2">Premum advert</label>
</div> -->


    <h2>Sell vehicle</h2>
    <div class="form-group paid">
        <form action="" method="post">
        <label for="businessName">REG:</label>
        <input type="text" class="form-control" id="businessName" aria-describedby="Business Name" name="reg" class="required" required autocomplete="nope" value="<?php 
        if (isset($reg))
        {
          echo $reg;
        }; ?>">
        <div class="invalid-feedback">Please provide Business Name.</div>
        <button type="submit" class="btn btn-primary">Primary</button>
        </form>
      </div>

    <form id="job" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate autocomplete="off">
    
      <div class="form-group">
        <label for="jobTitle">Title:</label>
        <input type="text" class="form-control" id="jobTitle" aria-describedby="Job Title" name="jobTitle" required autocomplete="nope" pattern="^[^±!@£$%^&*_+§¡€#¢§¶•ªº«\\/<>?:;|=.,]{1,28}$">
        <div class="invalid-feedback">Please provide a Title.</div>
      </div>

      <div class="form-group paid d-none">
        <label for="postcode">Registration</label>
        <input type="text" class="form-control" id="postcode" aria-describedby="postcode" name="registration" required autocomplete="nope" value=<?php 
        if (isset($reg))
        {
          echo $reg;
        }; ?>>
        <div class="invalid-feedback">Please provide a valid Post Code.</div>

      </div>
      <div class="mb-3 paid">
        <label for="formFile" class="form-label">Main Picture</label>
        <input class="form-control" type="file" id="formFile" name="fileUpload" required>
        <div class="imgGallery text-center">
        <!-- image preview -->
        </div> 
      </div>
      
      <div class="form-group paid">
        <label for="cc">CC</label>
        <input type="text" class="form-control" id="cc" aria-describedby="cc" name="cc" required autocomplete="nope" value="<?php 
        if (isset($cc))
        {
          echo $cc;
        }; ?> cc">
      </div>

      <div class="form-group paid">
        <label for="postcode">fuelType</label>
        <input type="text" class="form-control" id="fuelType" aria-describedby="postcode" name="fuelType" required autocomplete="nope" value="<?php 
        if (isset($fuelType))
        {
          echo $fuelType;
        }; ?>">
      </div>

      <div class="form-group paid">
        <label for="yearOfManufacture">yearOfManufacture</label>
        <input type="text" class="form-control" id="yearOfManufacture" aria-describedby="yearOfManufacture" name="yearOfManufacture" required autocomplete="nope" value="<?php 
        if (isset($yearOfManufacture))
        {
          echo $yearOfManufacture;
        }; ?>">
      </div>

      <div class="form-group paid">
        <label for="motStatus">Mot status</label>
        <input type="text" class="form-control" id="motStatus" aria-describedby="motStatus" name="motStatus" required autocomplete="nope" value="<?php 
        if (isset($motStatus))
        {
          echo $motStatus;
        }; ?>">
      </div>
      <div class="form-group paid">
        <label for="colour">Colour</label>
        <input type="text" class="form-control" id="colour" aria-describedby="colour" name="colour" required autocomplete="nope" value="<?php 
        if (isset($colour))
        {
          echo $colour;
        }; ?>">
      </div>
      <div class="form-group paid">
        <label for="make">make</label>
        <input type="text" class="form-control" id="make" aria-describedby="make" name="make" required autocomplete="nope" value="<?php 
        if (isset($make))
        {
          echo $make;
        }; ?>">
      </div>
      <div class="form-group paid">
        <label for="monthOfFirstRegistration">monthOfFirstRegistration</label>
        <input type="text" class="form-control" id="monthOfFirstRegistration" aria-describedby="monthOfFirstRegistration" name="monthOfFirstRegistration" required autocomplete="nope" value="<?php 
        if (isset($monthOfFirstRegistration))
        {
          echo $monthOfFirstRegistration;
        }; ?>">
      </div>
      <div class="form-group paid">
        <label for="dateOfLastV5CIssued">dateOfLastV5CIssued</label>
        <input type="text" class="form-control" id="dateOfLastV5CIssued" aria-describedby="dateOfLastV5CIssued" name="dateOfLastV5CIssued" required autocomplete="nope" value="<?php 
        if (isset($dateOfLastV5CIssued))
        {
          echo $dateOfLastV5CIssued;
        }; ?>">
      </div>
      <div class="form-group paid">
        <label for="motExpiryDate">motExpiryDate</label>
        <input type="text" class="form-control" id="motExpiryDate" aria-describedby="motExpiryDate" name="motExpiryDate" required autocomplete="nope" value="<?php 
        if (isset($motExpiryDate))
        {
          echo $motExpiryDate;
        }; ?>">
      </div>

      <div class="row paid">
          <label for="inputState">price</label>
          <div class="input-group">
            <span class="input-group-text">£</span>
            <input id="min" type="number" id ="min" class="form-control" aria-describedby="Minimum salary" placeholder="Minimum" name="price" class="required" required min="0" step=".01">
              <div class="invalid-feedback">Positive numbers only</div>
          </div>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" rows="3"  name="description" class="required" required maxlength="5000" minlength="10" placeholder="10 - 5000 characters." autocomplete="nope" aria-describedby="Description"></textarea>
        <div id="errordesc" class="invalid-feedback"> 10-5000 characters.</div>
      </div>
      
      
      <h2>How to apply</h2>
      <div class="form-group">
        <label for="E-mail" class="form-label">Email address</label>
        <input type="e-mail" class="form-control" id="e-mail" aria-describedby="e-mail" name="email" required autocomplete="nope" pattern="^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$">
        <div class="invalid-feedback">Please provide correct email address.</div>
      </div>


      <div class="form-group">
        <label for="telephone" class="form-label">Telephone</label>
        <input type="tel" class="form-control" id="telephone" aria-describedby="telephone" name="telephone" autocomplete="nope" pattern="[0-9]{11}">
        <div class="invalid-feedback">Please provide Telephone number.</div>
      </div>


      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="tc" required >
        <label class="form-check-label" for="exampleCheck1" >I have read and agree to the Bicester Info <a href="#" target="_blank">terms and conditions</a>.</label>
        <div class="invalid-feedback">You must agree before submitting.</div>
      </div>


      <button type="submit" class="btn btn-primary" name="submit">Submit</button>


    </form>
    </div>
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
    $('#postcode').val(checkPostCode($('#postcode').val()))});


  // $('#input').on('blur', function(e) {
	// $('#input').val(formatPostcode($('#input').val()));

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
          // document.getElementById(postcode).value = "";
        };
      
      },
      fail: function() {
        alert('ajax fail');
      }
    });
  });
  
  // remove leading 0's from currency input and moving dot for 2 places left

  function Min (){
    let x = document.getElementById('min').value;
    x2 = parseInt(x).toFixed(2);
    document.getElementById('min').value = x2;

  };
  function Max (){
    let y = document.getElementById('max').value;
    y2 = parseFloat(y).toFixed(2);
    document.getElementById('max').value = y2;
  };




window.addEventListener('load', (event) => {
        $('.paid').show();
        document.getElementById("businessName").removeAttribute("required");
        document.getElementById("postcode").removeAttribute("required");
        document.getElementById("min").removeAttribute("required");
        document.getElementById("max").removeAttribute("required");
        document.getElementById("description").setAttribute("maxlength","80");
        document.getElementById("description").setAttribute("placeholder","min 10 max 80 characters.");
        document.getElementById("errordesc").innerHTML="10-80 characters.";
});
    
    $('#paid').on('click', function(){
        $('.paid').show();
        document.getElementById("businessName").setAttribute("required", true);
        document.getElementById("postcode").setAttribute("required",true);
        document.getElementById("min").setAttribute("required",true);
        document.getElementById("max").setAttribute("required",true);
        document.getElementById("description").setAttribute("maxlength","5000");
        document.getElementById("description").setAttribute("placeholder","min 10 max 5000 characters.");
        document.getElementById("errordesc").innerHTML="10-5000 characters.";
    });
    $('#free').on('click', function(){
        $('.paid').hide();
        document.getElementById("businessName").removeAttribute("required");
        document.getElementById("postcode").removeAttribute("required");
        document.getElementById("min").removeAttribute("required");
        document.getElementById("max").removeAttribute("required");
        document.getElementById("description").setAttribute("maxlength","80");
        document.getElementById("description").setAttribute("placeholder","min 10 max 80 characters.");
        document.getElementById("errordesc").innerHTML="10-80 characters.";
    });
  </script>
  </body>
</html>