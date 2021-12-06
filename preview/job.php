<?php
session_start();

require_once "../connect.php";

// include "file-upload.php";

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// require 'C:\xampp\composer\vendor\autoload.php';

// $mail = new PHPMailer(TRUE);

// if(isset($_POST['submit'])){  
//   if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK)
//   {

//     // get details of the uploaded file
//     $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
//     $fileName = $_FILES['fileUpload']['name'];
//     $fileSize = $_FILES['fileUpload']['size'];
//     $fileType = $_FILES['fileUpload']['type'];
//     $fileNameCmps = explode(".", $fileName);
//     $fileExtension = strtolower(end($fileNameCmps));

//     // sanitize file-name
//     $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

//     // check if file has one of the following extensions
//     $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
    
//     if (in_array($fileExtension, $allowedfileExtensions))
//     {
//       // directory in which the uploaded file will be moved
//       $uploadFileDir = 'uploaded_files/';
//       $dest_path = $uploadFileDir . $newFileName;
//     }
  
// try {
//     $email = htmlspecialchars($_POST['email']);
//     $employer = htmlspecialchars($_SESSION['employer']);
//     $message = htmlspecialchars($_POST['message']);
//     $name = htmlspecialchars($_POST['name']);
    
    
//     $mail->IsHTML(true); 
//     $mail->CharSet="utf-8";
//     $mail->setFrom('noreply@bicesterinfo.com', 'Bicester Info');
//     $mail->addReplyTo($email);
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
//     unlink($dest_path);
//     echo $mail->ErrorInfo;
//     unset($_SESSION['employer']);
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


if(isset($_GET['id'])){
  $id = $_GET['id'];
  
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
          $sql = $connection->query("SELECT * FROM jobs WHERE id = $id");
          $job = $sql-> fetch_assoc();
          // print_r($job);
            
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

  <nav class="navbar sticky-top navbar-light bg-light justify-content-between">
  
      <a href="javascript:history.back()"><i class="fas fa-arrow-left fa-lg"></i></a>
    
  
      <a href="../index.php"><i class="fas fa-home fa-lg"></i></a>
    
  </nav>


    <!-- Page content-->
              <div class="container">
            <div class="row my-3">
              <div class="col-6">
                <?php
                // Previous button 
                mysqli_report(MYSQLI_REPORT_STRICT);
                try{
                    $connection = new mysqli($host, $db_user, $db_password, $db_name);
                    if($connection -> connect_errno!=0)
                      {
                        throw new Exception(mysqli_connect_errno());
                      }
                      else
                      {
                        $previous = mysqli_query($connection, "SELECT * FROM jobs WHERE id<$id order by id DESC");
                          if($row = mysqli_fetch_array($previous))
                          // print_r($previous);

                        $connection->close();
                      }
                  }    catch(Exception $e)
                  {
                    echo '<span style="color:red;">error</span>';
                    // echo'<br> informacja dev:'.$e;
                  }
                ?>
              </div>
              <div class="col-6 d-block">
                <?php
                // Next button 
                mysqli_report(MYSQLI_REPORT_STRICT);
                try{
                    $connection = new mysqli($host, $db_user, $db_password, $db_name);
                    if($connection -> connect_errno!=0)
                      {
                        throw new Exception(mysqli_connect_errno());
                      }
                      else
                      {
                        $next = mysqli_query($connection, "SELECT * FROM jobs WHERE id>$id order by id ASC");
                          if($row = mysqli_fetch_array($next))
                          // print_r($next);

                        $connection->close();
                      }
                  }    catch(Exception $e)
                  {
                    echo '<span style="color:red;">error</span>';
                    // echo'<br> informacja dev:'.$e;
                  } 
            if (empty($job['jobTitle'])) {
            echo 'something went wrong';

            exit();
          }
                ?>
              </div>
              
            </div>
          </div>
          
    <div class="container job">
      <div class="row justify-content-center">
        <div class="col-10">
          <div class="row">
          <div class="col-12 col-md-5 col-lg-4 py-5">
          <!-- <h2>job preview <?php echo htmlspecialchars($job['id']) ?></h2>  -->
          <h2><?php echo htmlspecialchars($job['jobTitle'])?></h2> <br>
          <h3><?php echo htmlspecialchars($job['businessName']) ?></h3>
          <h4>Location: <?php echo htmlspecialchars($job['postcode']) ?></h4>
          <!-- <h3>lon:<?php echo htmlspecialchars($job['lon']) ?></h3>
          <h3>lat:<?php echo htmlspecialchars($job['lat']) ?></h3> -->
          <h4 class="price">£<?php echo htmlspecialchars($job['minSalary']) ?> - £<?php echo htmlspecialchars($job['maxSalary']) ?>/<?php echo htmlspecialchars($job['salaryType']) ?> 
          <h4><?php echo htmlspecialchars($job['jobType']) ?> / <?php echo htmlspecialchars($job['employmentType']) ?></h4>
          <h4>No Vacancies: <?php echo htmlspecialchars($job['noVacancies']) ?></h4>       
          </div>
          <div class="col-12 col-md-7 col-lg-8 my-3">
            <iframe 
              width="100%" 
              height="100%" 
              frameborder="0" 
              scrolling="no" 
              marginheight="0" 
              marginwidth="0" 
              src="https://maps.google.com/maps?q=<?php echo $job['lat']?>,<?php echo $job['lon']?>&hl=en&z=12&amp;output=embed">
            </iframe>   
          </div>
          </div>
          
          <p><?php echo htmlspecialchars($job['desc']) ?></p>

          <time class=" timeago" datetime="<?php echo htmlspecialchars($job['timeStamp']) ?>"></time>
          <br>
      </div>


<!-- Button trigger modal -->
<div class="row my-4 justify-content-center">
  <div class="col-6 col-md-4 col-lg-3 d-block">
    <button type="button" class="btn btn-success my-3 mx-2 w-100" data-bs-toggle="modal" data-bs-target="#apply">
    Apply now
  </button>
  </div>
  
  <?php
  if(isset($job['phone']) && !empty($job['phone'])){
  echo '<div class="col-6 col-md-4 col-lg-3 d-block">
          <a class="telephone" href="tel:'.htmlspecialchars($job['phone']).'"><button type="button" class="btn btn-outline-success my-3 mx-2 w-100">
          Call now
          </button></a>
        </div>';
  }
  ?>
</div>


<!-- Modal -->
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
        <input type="submit" name="submit" class="btn btn-success" value="Apply"></input>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $_SESSION["employer"] = $job['email'] ?>


          <hr>
          <div class="container">
            <div class="row my-5">
              <div class="col-6">
                <?php
                // Previous button 
                mysqli_report(MYSQLI_REPORT_STRICT);
                try{
                    $connection = new mysqli($host, $db_user, $db_password, $db_name);
                    if($connection -> connect_errno!=0)
                      {
                        throw new Exception(mysqli_connect_errno());
                      }
                      else
                      {
                        $previous = mysqli_query($connection, "SELECT * FROM jobs WHERE id<$id order by id DESC");
                          if($row = mysqli_fetch_array($previous))
                          // print_r($previous);
                          {
                            echo '<a href="job.php?id='.$row['id'].'"><button class="btn btn-outline-primary" type="button">Previous</button></a>';  
                          } 

                        $connection->close();
                      }
                  }    catch(Exception $e)
                  {
                    echo '<span style="color:red;">error</span>';
                    // echo'<br> informacja dev:'.$e;
                  }
                ?>
              </div>
              <div class="col-6 d-block">
                <?php
                // Next button 
                mysqli_report(MYSQLI_REPORT_STRICT);
                try{
                    $connection = new mysqli($host, $db_user, $db_password, $db_name);
                    if($connection -> connect_errno!=0)
                      {
                        throw new Exception(mysqli_connect_errno());
                      }
                      else
                      {
                        $next = mysqli_query($connection, "SELECT * FROM jobs WHERE id>$id order by id ASC");
                          if($row = mysqli_fetch_array($next))
                          // print_r($next);
                          {
                            
                            echo '<a href="job.php?id='.$row['id'].'"><button class="btn btn-outline-primary" type="button">Next</button></a>';  
                          } 

                        $connection->close();
                      }
                  }    catch(Exception $e)
                  {
                    echo '<span style="color:red;">error</span>';
                    // echo'<br> informacja dev:'.$e;
                  } 
                ?>
              </div>
              
            </div>
          </div>
          <br>          
        </div>
      </div>
    </div>



    <!-- End Page content -->

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

  	<!-- jQuery -->
	  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <!-- Time stamp format -->
    <script src="../js/jquery.timego.js"></script>

      <script>
      jQuery(document).ready(function() {
      jQuery("time.timeago").timeago();
      });
    </script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/dd12015ad5.js" crossorigin="anonymous"></script>

  <script>


  </script>
  

<!-- Go to www.addthis.com/dashboard to customize your tools --> 
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-616fc54381d636ee"></script>
  </body>
</html>