<?php
session_start();
require_once "../connect.php";
if(isset($_POST['jobTitle']) && (empty($_POST['businessName']))){
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
          if($connection->query(sprintf("INSERT INTO `freejobs` (`id`, `jobTitle`, `desc`, `email`, `phone`) VALUES (NULL, '$jobTitle','$desc','$email','$phone')")))
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
else if(isset($_POST['jobTitle']) && (!empty($_POST['businessName'])))
{

  mysqli_report(MYSQLI_REPORT_STRICT);

    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);

      $jobTitle = mysqli_real_escape_string($connection, $_POST['jobTitle']);
      $businessName = mysqli_real_escape_string($connection, $_POST['businessName']);
      $desc = mysqli_real_escape_string($connection, $_POST['description']);
      $postcode = mysqli_real_escape_string($connection, $_POST['postcode']);
      $lon = mysqli_real_escape_string($connection, $_POST['lon']);
      $lat = mysqli_real_escape_string($connection, $_POST['lat']);
      $salaryType = mysqli_real_escape_string($connection, $_POST['salaryType']);
      $minSalary = mysqli_real_escape_string($connection, $_POST['minimum']);
      $maxSalary = mysqli_real_escape_string($connection, $_POST['maximum']);
      $employmentType = mysqli_real_escape_string($connection, $_POST['employmentType']);
      $jobType = mysqli_real_escape_string($connection, $_POST['jobType']);
      $noVacancies = mysqli_real_escape_string($connection, $_POST['vacancies']);
      $email = mysqli_real_escape_string($connection, $_POST['email']);
      $phone = mysqli_real_escape_string($connection, $_POST['telephone']);
      

      if($connection -> connect_errno!=0)
        {
          throw new Exception(mysqli_connect_errno());
        }
        else
        {
          if($connection->query(sprintf("INSERT INTO `jobs` (`id`, `jobTitle`, `businessName`, `desc`, `postcode`, `lon`, `lat`, `salaryType`, `minSalary`, `maxSalary`, `employmentType`, `jobType`, `noVacancies`, `email`, `phone`) VALUES (NULL, '$jobTitle','$businessName', '$desc', '$postcode', '$lon', '$lat','$salaryType','$minSalary','$maxSalary','$employmentType','$jobType','$noVacancies','$email','$phone')")))
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
}

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


    <h2>Create Job</h2>
    <form id="job" method="POST" class="needs-validation" novalidate autocomplete="off">
    
      <div class="form-group">
        <label for="jobTitle">Job Title:</label>
        <input type="text" class="form-control" id="jobTitle" aria-describedby="Job Title" name="jobTitle" required autocomplete="nope" pattern="^[^±!@£$%^&*_+§¡€#¢§¶•ªº«\\/<>?:;|=.,]{1,28}$">
        <div class="invalid-feedback">Please provide Job Title.</div>
      </div>

      <div class="form-group paid">
        <label for="businessName">Business name:</label>
        <input type="text" class="form-control" id="businessName" aria-describedby="Business Name" name="businessName" class="required" required autocomplete="nope" pattern="^[^±!@£$%^*_+§¡€#¢§¶•ªº«\\/<>?:;|=.,]{1,28}$">
        <div class="invalid-feedback">Please provide Business Name.</div>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" rows="3"  name="description" class="required" required maxlength="5000" minlength="10" placeholder="10 - 5000 characters." autocomplete="nope" aria-describedby="Description"></textarea>
        <div id="errordesc" class="invalid-feedback"> 10-5000 characters.</div>
      </div>
      
      <div class="form-group paid">
        <label for="postcode">Workplace Post Code:</label>
        <input type="text" class="form-control" id="postcode" aria-describedby="postcode" name="postcode" required autocomplete="nope" pattern="^([A-Za-z][A-Ha-hJ-Yj-y]?[0-9][A-Za-z0-9]? ?[0-9][A-Za-z]{2}|[Gg][Ii][Rr] ?0[Aa]{2})$">
        <div class="invalid-feedback">Please provide a valid Post Code.</div>
        <!-- long lat from postcode.io -->
        <input id="lon" name="lon" style="visibility:hidden; position:absolute"></input>
        <input id="lat" name="lat" style="visibility:hidden; position:absolute"></input>
      </div>

      <div class="form-group paid">
        <label for="inputState">Salary type:</label>
          <select class="form-select" aria-describedby="Salary type"  name="salaryType" required>
            <option value="hour" selected>per hour</option>
            <option value="day">per day</option>
            <option value="week">per week</option>
            <option value="month">per month</option>
            <option value="year">per year</option>
            <option value="one-off">one-off</option>
          </select>
      </div>


      <div class="row paid">
        <div class="col-6">
          <label for="inputState">Minimum salary:</label>
          <div class="input-group">
            <span class="input-group-text">£</span>
            <input id="min" type="number" id ="min" class="form-control" aria-describedby="Minimum salary" placeholder="Minimum" name="minimum" class="required" required min="0" step=".01">
              <div class="invalid-feedback">Positive numbers only</div>
          </div>
        </div>
        <div class="col-6">
          <label for="inputState">Maximum salary:</label>
            <div class="input-group">
            <span class="input-group-text" >£</span>
            <input id="max" type="number" id="max"class="form-control" aria-describedby="Maximum Salary" placeholder="Maximum" name="maximum" class="required" required min="0" step=".01">
            <div class="invalid-feedback">Positive numbers only</div>
          </div>
        </div>
      </div>


      <div class="form-group paid">
        <label for="inputState">Employment type:</label>
          <select class="form-select" aria-label="Employment type" name="employmentType" required>
            <option value="Permanent" selected>Permanent</option>
            <option value="Casual">Casual</option>
          </select>
      </div>

      <div class="form-group paid">
        <label for="inputState">Job type:</label>
          <select class="form-select" aria-describedby="Job type" name="jobType" required>
            <option value="Full-time" selected>Full-time</option>
            <option value="Part-time">Part-time</option>
            <option value="Internship">Internship</option>
            <option value="Volunteer">Volunteer</option>
            <option value="Contractor">Contractor</option>
          </select>
      </div>


      <div class="form-group paid">
        <label for="inputState">No Vacancies:</label>
          <select class="form-select" aria-describedby="Number of Vacancies" name="vacancies" required>
            <option selected value="1">1 Vacancy</option>
            <option value="2">2 Vacancies</option>
            <option value="3">3 Vacancies</option>
            <option value="4">Many Vacancies</option>
          </select>
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


      <button type="submit" class="btn btn-primary">Submit</button>


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