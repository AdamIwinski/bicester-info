<?php
session_start();

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
          $paid = $connection->query("SELECT * FROM rooms ORDER BY id DESC");
          $rooms = $paid-> fetch_all();

          $free = $connection->query("SELECT * FROM freerooms ORDER BY id DESC");
          $freerooms = $free-> fetch_all();
          // print_r($freerooms);

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
      <h4>Rooms</h4>
      <a href="../index.php"><i class="fas fa-home fa-lg"></i></a>
  </nav>

<?php
foreach ($rooms as $room){

        $number = $room[8];
        $SalaryMin = formatMoney($number);
        // 1,235.00

        
        echo '<div class="container"><a href="room.php?id='.$room[0].'">
          <div class="card m-3">
            <div class="card-body">
              <h5 class="card-title">'.htmlspecialchars($room[1]).'</h5>
              <h6 class="card-subtitle mb-2 text-muted">'.htmlspecialchars($room[2]).'</h6>
              <p> Location: '.htmlspecialchars($room[4]).'</p>
              <p class="card-text">From: '.htmlspecialchars($SalaryMin).' /'.htmlspecialchars($room[7]).'</p>
              <p>'.htmlspecialchars($room[4]).'</p>
            </div>
            <time class="timeago" datetime="'.htmlspecialchars($room[15]).'"></time>
          </div>
        </a>
        </div>';
      };


foreach ($freerooms as $freeroom){

    echo '<div class="container"><h5 class="card-title">'.htmlspecialchars($freeroom[1]).' x '.htmlspecialchars($freeroom[2]).' bedroom</h5>
              <h6 class="card-subtitle mb-2 text-muted"></h6>
              <p>'.htmlspecialchars(substr($freeroom[3], 0, 80)).'</p>
            <time class="timeago" datetime="'.htmlspecialchars($freeroom[6]).'"></time>
            <p>'.$freeroom[4].'</p>
            <p>'.$freeroom[5].'</p>
            <br>
        </div>';
      };
?>


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