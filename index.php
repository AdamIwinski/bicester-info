<?php
  require_once "connect.php";

  $connection = @new mysqli($host, $db_user, $db_password, $db_name);

  if($connection -> connect_errno!=0)
  {
    echo "Error: ".$connection->connect_errno;
  }
    
    $pullJobs = $connection->query("SELECT * FROM jobs ORDER BY id DESC LIMIT 10");
    $jobs = $pullJobs-> fetch_all();

    $pullRooms = $connection->query("SELECT * FROM rooms ORDER BY id DESC LIMIT 10");
    $rooms = $pullRooms-> fetch_all();

    $pullHouses = $connection->query("SELECT * FROM houses ORDER BY id DESC LIMIT 10");
    $houses = $pullHouses-> fetch_all();

    $pullCars = $connection->query("SELECT * FROM cars ORDER BY id DESC LIMIT 10");
    $cars = $pullCars-> fetch_all();

    // print_r($cars);

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
    <link rel="apple-touch-icon" href="./assets/favicon.ico"/>

    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-side-modals.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Google Fonts -->
    
    <!-- Font Awesome -->
    <script src="###" crossorigin="anonymous"></script>

    <!-- OWL Carusel-->
    <link rel="stylesheet" href="css/owl/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl/owl.theme.default.min.css">
  </head>
  <body>
    <!-- Responsive navbar-->

    <!-- Page content-->
    
    <!-- Hero -->

    <div class="p-5 text-center">
    <img class="d-block mx-auto mb-4" src="assets/img/Hero.png" alt="Bicester Info">
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Local news, jobs and accommodation, restaurants, essential sightseeing and attractions.</p>
    </div>
  </div>
    
    <!-- end hero -->
<!-- news -->

<?PHP 
$url = "https://newsapi.org/v2/top-headlines?country=gb&apiKey=###";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$news = curl_exec($curl);
curl_close($curl);
// var_dump($news);
$news = json_decode($news, true);
// print_r ($news['articles']);
?>

<!-- news -->
    <!-- Houses -->
    <div class="container ">
      <div class="latest">
      <h2>Latest Headlines</h2>
      </div>
    </div>
  <div id="owl-news" class="owl-carousel">
<!--  -->
      <?php foreach ($news['articles'] as $new){
          $publisher = $new['source']['name'];
          $author = $new['author'];
          $title = $new['title'];
          $description = $new['description'];
          $url = $new['url'];
          // $source = $new['source'];
          $image = $new['urlToImage'];
          $published_at = $new['publishedAt'];
          // $category = $new['category'];
          if(!empty($image)){
          $imageData = base64_encode(file_get_contents($image));
          echo 
        ' <div class="newscard">
            <a href="'.$url.'" target=_blank>
              <div class="tile card m-2">
                <div class="card-body newscards">
                    <h3 class="card-title">'.$publisher.'<br> <br></h3>
                    <div class="imgcont">
                      <img src="data:image/jpeg;base64,'.$imageData.'">
                    </div>
                    <h4 class="card-title">'.$title.'<br> <br></h4>
                    <p class="bottom">
                      <span class="bottoml">'.$author.'</span>
                      <span class="bottomr"><time class=" text-muted timeago" datetime="'.$published_at.'"></time></span>
                    </p>
                </div>            
              </div>
            </a>
          </div>';
      }
    };
?>
</div>

<!-- Jobs -->
    <div class="container ">
      <div class="latest">
      <h2>Latest jobs</h2> <a href="preview/jobs.php">see all</a>
      </div>
    </div>
      <div id="owl-jobs" class="owl-carousel d-flex;">
      <?php foreach ($jobs as $job){

        // salary from formating
        $number = $job[8];
        $SalaryMin = formatMoney($number);

        if((strlen($job[1])) <= 18){
          // display card bootstrap style
          echo 
          '<div class="jobcard">
          <a href="preview/job.php?id='.$job[0].'">
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
          <a href="preview/job.php?id='.$job[0].'">
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
      </div>
<!-- end jobs -->

<!-- Rooms -->
    <div class="container ">
      <div class="latest">
      <h2>Latest rooms</h2> <a href="preview/rooms.php">see all</a>
      </div>
    </div>
  <div id="owl-rooms" class="owl-carousel">
<!--  -->
      <?php foreach ($rooms as $room){

        // salary from formating
        $number = $room[9];
        $price = formatMoney($number);

          // display card bootstrap style
          echo 
          '<div class="roomcard">
          <a href="preview/room.php?id='.$room[0].'">
            <div class="tile card m-3">
            <img src="add/'.htmlspecialchars($room[12]).'" class="img-fluid" alt="..." style=" object-fit:cover; vertical-align: middle; width:100%; height: 230px;">
              <div class="card-body">
                <h3 class="card-title">'.htmlspecialchars($room[1]).' x '.htmlspecialchars($room[2]).'<br></h3>
                <p class="location text-muted">Couples: '.htmlspecialchars($room[11]).' | '.htmlspecialchars($room[7]).'</p>
                <p class="location text-muted"> Location: '.htmlspecialchars($room[4]).'</p>
                <p class="card-text"> <span class="price">'.htmlspecialchars($price).'</span> <span class="per">/'.htmlspecialchars($room[8]).'</span></p>
                <p> <span class="text-muted left">Bills: '.htmlspecialchars($room[10]).'</span> <span class="right"><time class=" text-muted timeago" datetime="'.htmlspecialchars($room[16]).'"></time></span></p>
              </div>  
            </div>
          </a>
          </div>';
      };
      ?>

<!--  -->
      </div>  
<!-- end rooms -->



<!-- Houses -->
    <div class="container ">
      <div class="latest">
      <h2>Latest Houses/Flats</h2> <a href="preview/houses.php">see all</a>
      </div>
    </div>
  <div id="owl-houses" class="owl-carousel">
<!--  -->
      <?php foreach ($houses as $house){

        // salary from formating
        $number = $house[9];
        $price = formatMoney($number);

          // display card bootstrap style
          echo 
          '<div class="roomcard">
          <a href="preview/house.php?id='.$house[0].'">
            <div class="tile card m-3">
            <img src="add/'.htmlspecialchars($house[12]).'" class="img-fluid" alt="..." style=" object-fit:cover; vertical-align: middle; width:100%; height: 230px;">
              <div class="card-body">
                <h3 class="card-title">'.htmlspecialchars($house[1]).' bedroom '.htmlspecialchars($house[2]).'<br></h3>
                <p class="location text-muted">'.htmlspecialchars($house[7]).'</p>
                <p class="location text-muted"> Location: '.htmlspecialchars($house[4]).'</p>
                <p class="baseline"> <span class="text-muted left"><span class="price">'.htmlspecialchars($price).'</span> <span class="per">/'.htmlspecialchars($house[8]).'</span></span> <span class="right"><time class=" text-muted timeago" datetime="'.htmlspecialchars($house[3]).'"></time></span></p>
              </div>  
            </div>
          </a>
          </div>';
      };
      ?>
<!--  -->
      </div>  
<!-- end houses -->


<!-- cars -->
    <div class="container ">
      <div class="latest">
      <h2>Vehicles</h2> <a href="preview/cars.php">see all</a>
      </div>
    </div>
  <div id="owl-cars" class="owl-carousel">
<!--  -->
      <?php foreach ($cars as $car){

        // salary from formating
        $number = $house[9];
        $price = formatMoney($number);

          // display card bootstrap style
          echo 
          '<div class="carcard">
          <a href="preview/car.php?id='.$car[0].'">
            <div class="tile card m-3">
            <img src="add/'.htmlspecialchars($car[16]).'" class="img-fluid" alt="..." style=" object-fit:cover; vertical-align: middle; width:100%; height: 230px;">
              <div class="card-body">
                <h3 class="card-title">'.htmlspecialchars($car[9]).'  '.htmlspecialchars($car[6]).' year <br></h3>
                <h3 class="card-title">'.htmlspecialchars($car[5]).'  '.htmlspecialchars($car[4]).'<br></h3>




                <p class="baseline"> <span class="text-muted left"><span class="price">£ '.htmlspecialchars($car[13]).'</span> </span> <span class="right"><time class=" text-muted timeago" datetime="'.htmlspecialchars($car[17]).'"></time></span></p>
              </div>  
            </div>
          </a>
          </div>';
      };
      ?>
<!--  -->
      </div>
      <br>  
      <hr>
      <br><br>
<!-- end cars -->

    <!-- Choose category -->

    <!-- create add button-->
    <button id="createAdd" type="button" class="btn btn-primary" data-bs-target="#bottom_modal" data-bs-toggle="modal">Create new listing</i></button>
    <!-- end create add button-->
    <div class="modal modal-bottom fade" id="bottom_modal" tabindex="-1" role="dialog" aria-labelledby="bottom_modal">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create new listing</h5>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button> -->
          </div>
          <div class="modal-body">
            <a href="add/Job.php" class="d-block"><i class="fas fa-briefcase"></i> Job</a>
            <hr>
            <a href="add/Room.php" class="d-block"><i class="fas fa-bed"></i> Room</a>
            <hr>
            <a href="add/House.php" class="d-block disabled" ><i class="fas fa-house-user"></i> House</a>
            <hr>
            <a href="add/Vehicle.php" class="d-block disabled" ><i class="fas fa-car"></i> Vehicle</a>
          </div>
        </div>
      </div>
    </div>

    <!-- endcreate add modal -->

    <!-- end choose category -->

    <!-- End Page content -->

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- owl carusel -->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/owl/owl.carousel.min.js"></script>
    <script src="./js/owl/mousewheel.js"></script>
    <!-- Time stamp format -->
    <script src="./js/jquery.timego.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

    <!-- Font Awsome -->
    <script src="https://kit.fontawesome.com/dd12015ad5.js" crossorigin="anonymous"></script>
    <script>
      jQuery(document).ready(function() {
      jQuery("time.timeago").timeago();
      });
    </script>
  </body>
</html>
