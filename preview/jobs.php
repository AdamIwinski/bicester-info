<?php
session_start();

require_once "../connect.php";

// include "file-upload.php";

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// require 'C:\xampp\composer\vendor\autoload.php';

// $mail = new PHPMailer(TRUE);

// if(isset($_POST['submit'])){
//       if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK)
//   {
//   // get details of the uploaded file
//     $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
//     $fileName = $_FILES['fileUpload']['name'];
//     $fileSize = $_FILES['fileUpload']['size'];
//     $fileType = $_FILES['fileUpload']['type'];
//     $fileNameCmps = explode(".", $fileName);
//     $fileExtension = strtolower(end($fileNameCmps));

//     // sanitize file-name
//     $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    
//     // check if file has one of the following extensions
//     $allowedfileExtensions = array('pdf', 'png','jpg', 'docx', 'doc');
    
//     if (in_array($fileExtension, $allowedfileExtensions))
//     {
//       // directory in which the uploaded file will be moved
//       $uploadFileDir = 'uploaded_files/';
//       $dest_path = $uploadFileDir . $newFileName;

//     }

// try {
//     $employer = htmlspecialchars($_SESSION['employer']);
//     $message = htmlspecialchars($_POST['message']);
//     $name = htmlspecialchars($_POST['name']);


//     $mail->IsHTML(true); 
//     $mail->CharSet="utf-8";
//     $mail->setFrom('noreply@bicesterinfo.com', 'Bicester Info');
//     $mail->addReplyTo($_SESSION['email']);
//     $mail->addAddress($employer);
//     $mail->ClearCCs();
//     $mail->ClearBCCs();
//     $mail->Subject = 'Job aplication';
//     $mail->Body = nl2br('Hi. <br><br>'.$name.' is applying for your job advert on Biceser Info <br><br>'.$message);
//     $mail->isSMTP();
//     $mail->Host = 'smtp.gmail.com';
//     $mail->Port = 587;
//     $mail->SMTPAuth = true;
//     $mail->SMTPSecure = 'tls';
//     $mail->AddAttachment($dest_path);
//     /* Username (email address). */
//     $mail->Username = 'iwinski.uk@gmail.com';

//     /* Google account password. */
//     $mail->Password = 'adamiwi12';
//     /* Enable SMTP debug output. */
//     // $mail->SMTPDebug = 4;
//     $mail->send();
//     // unlink($dest_path);
//     echo $mail->ErrorInfo;
//     unset($_SESSION['email']);
// }
// catch (Exception $e)
// {
//    echo $e->errorMessage();
// }
// catch (\Exception $e)
// {
//    echo $e->getMessage();
// }}}
// end mail




  require_once "../connect.php";
  mysqli_report(MYSQLI_REPORT_STRICT);

    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);
      if($connection -> connect_errno!=0)
        {
          throw new Exception(mysqli_connect_errno());
        }
        else
        {
          $paid = $connection->query("SELECT * FROM jobs ORDER BY id DESC");
          $jobs = $paid-> fetch_all();

          $free = $connection->query("SELECT * FROM freejobs ORDER BY id DESC");
          $freejobs = $free-> fetch_all();
          // print_r($freejobs);

          $connection->close();
        }
    }
    catch(Exception $e)
    {
      echo '<span style="color:red;">error</span>';
      // echo'<br> informacja dev:'.$e;
    } 
    
        // formats money to a whole number or with 2 decimals; includes a dollar sign in front
        function formatMoney($number, $cents = 1) { // cents: 0=never, 1=if needed, 2=always
          if (is_numeric($number)) { // a number
            if (!$number) { // zero
              $money = ($cents == 2 ? '0.00' : '0'); // output zero
            } else { // value
              if (floor($number) == $number) { // whole number
                $money = number_format($number, ($cents == 2 ? 2 : 0)); // format
              } else { // cents
                $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2)); // format
              } // integer or decimal
            } // value
            return '£'.$money;
          } // numeric
        } // formatMoney    
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

  <nav class="navbar sticky-top navbar-light bg-light justify-content-between">
      <a href="javascript:history.back()"><i class="fas fa-arrow-left fa-lg"></i></a>
      <h4>Vacancies</h4>
      <a href="../index.php"><i class="fas fa-home fa-lg"></i></a>
  </nav>

<div class="container">
<?php
foreach ($jobs as $job){

        // salary from formating
        $number = $job[8];
        $SalaryMin = formatMoney($number);

        if((strlen($job[1])) <= 18){
          // display card bootstrap style
          echo 
          '<div class="jobcard">
          <a href="job.php?id='.$job[0].'">
            <div class="tile card m-3">
              <div class="card-body">
                <h3 class="card-title">'.htmlspecialchars($job[1]).'<br> <br></h3>
                <h4 class="mb-2">'.htmlspecialchars($job[2]).'</h4>
                <p class="location text-muted"> Location: '.htmlspecialchars($job[4]).'</p>
                <p class="card-text"> <span class="price">'.htmlspecialchars($SalaryMin).'</span> <span class="per">/'.htmlspecialchars($job[7]).'</span></p>
                <p> <span class="text-muted left">'.htmlspecialchars($job[11]).'</span> <span class="right"><time class=" text-muted timeago" datetime="'.htmlspecialchars($job[15]).'"></time></span></p>
              </div>            
            </div>
          </a>
          </div>';
        }else{
        echo 
          '<div class="jobcard">
          <a href="job.php?id='.$job[0].'">
            <div class=" tile card m-3">
              <div class=" card-body">
                <h3 class="card-title">'.htmlspecialchars($job[1]).'</h3>
                <h4 class="mb-2">'.htmlspecialchars($job[2]).'</h4>
                <p class="location text-muted"> Location: '.htmlspecialchars($job[4]).'</p>
                <p class="card-text"> <span class="price">'.htmlspecialchars($SalaryMin).'</span> <span class="per">/'.htmlspecialchars($job[7]).'</span></p>
                <p> <span class="text-muted left">'.htmlspecialchars($job[11]).'</span> <span class="right"><time class=" text-muted timeago" datetime="'.htmlspecialchars($job[15]).'"></time></span></p>
              </div>            
            </div>
          </a>
          </div>';
        }
        
      };
      ?>
      <br><br>
      <?php


foreach ($freejobs as $freejob){

    echo '<div class="container free"><h5 class="card-title"><b>'.htmlspecialchars($freejob[1]).'</b></h5>
              <h6 class="card-subtitle mb-2 text-muted">'.htmlspecialchars(substr($freejob[2], 0, 80)).'</h6>

            <p> 
              <span class="left">
                  <button type="button" class="btn btn-success my-3 mx-2 w-100" data-bs-toggle="modal" data-bs-target="#apply">
    Apply now
  </button>

              <a class="telephone" href="tel:'.htmlspecialchars($freejob[4]).'"><i class="fas fa-phone-alt fa-lg"></i></a></span> 
              <span class="right"><time class=" timeago" datetime="'.htmlspecialchars($freejob[5]).'"></time></span>
            </p>
              <div style="clear:both"></div>
              <hr>
        </div>
        
<div class="modal fade" id="apply" tabindex="-1" aria-labelledby="applyLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="applyLabel">Apply for job</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                  <form id="contact-form" method="post" action="" role="form" enctype="multipart/form-data">
                    <div class="controls">
                        <div class="row">
                            <div class="col">
                                <div class="form-group m-2">
                                    <label for="form_name" class="mb-1">Name</label>
                                    <input id="form_name" type="text" name="name" class="form-control" required="required"
                                    data-error="Required">
                                </div>
                            </div>
                          </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group m-2">
                                    <label for="form_email"class="mb-1">E-mail</label>
                                    <input id="form_email" type="email" name="email" class="form-control" required="required"
                                        data-error="Required">
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                                <div class="form-group m-2">
                                  <label for="form_message"class="mb-1">Message</label>
                                  <textarea id="form_message" name="message" class="form-control" rows="4" required="required"
                                  data-error="Required"></textarea>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                                <div class="form-group m-2">
                                  <label for="formFile" class="form-label">Attach CV</label>
                                  <input class="form-control" type="file" id="formFile" name="fileUpload">
                                </div>
                            </div>
                          </div>
                    </div>
                  </div>
                <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" name="submit" value="email" class="btn btn-success"></input>
        </form>
      </div>
    </div>
  </div>
</div>';
}
$_SESSION['email'] = $freejob[3];
?>
</div>


    <!-- End Page content -->

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

  	<!-- jQuery -->
	  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <!-- Time stamp format -->
    <script src="../js/jquery.timego.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/dd12015ad5.js" crossorigin="anonymous"></script>

    <script>
      jQuery(document).ready(function() {
      jQuery("time.timeago").timeago();
      });
    </script>

  </body>
</html>