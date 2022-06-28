<?php

$arrContextOptions=array(

  "ssl"=>array(

      "verify_peer"=>false,

      "verify_peer_name"=>false,

  ),

);

 function sortBypopulation($a, $b) {

  return $a['population'] < $b['population'];

}

$url = "";

$toPhp = "";

$createurl ="";

$createnameurl ="";

$createfullnameurl ="";

$createcodeurl ="";

if( !(empty($_POST["searchCountry"])) && !(empty($_POST["searchfilter"]))){

  $createnameurl ="https://restcountries.com/v3.1/name/".$_POST["searchCountry"];

  $createfullnameurl ="https://restcountries.com/v3.1/name/".$_POST["searchCountry"]."?fullText=true";

  $createcodeurl ="https://restcountries.com/v3.1/alpha/".$_POST["searchCountry"]; 

  if($_POST["searchfilter"] == 'name'){

    if (!(is_null(json_decode(file_get_contents($createfullnameurl, false, stream_context_create($arrContextOptions)))))) {

      $createurl =" full name";

      $url = file_get_contents($createfullnameurl, false, stream_context_create($arrContextOptions));

      $toPhp = json_decode($url, true);

      usort($toPhp, 'sortBypopulation');

    } elseif  (!(is_null(json_decode(file_get_contents($createnameurl, false, stream_context_create($arrContextOptions)))))) {

      $createurl =" name";

      $toPhp = json_decode(file_get_contents($createnameurl, false, stream_context_create($arrContextOptions)), true);

      usort($toPhp, 'sortBypopulation');

    } else{

      $createurl =" none found";

      $toPhp = null;

    }

  } elseif ($_POST["searchfilter"] == 'code'){

    if (!(is_null(json_decode(file_get_contents($createcodeurl, false, stream_context_create($arrContextOptions)))))) {

      $createurl ="";

      $toPhp = json_decode(file_get_contents($createcodeurl, false, stream_context_create($arrContextOptions)), true);

      usort($toPhp, 'sortBypopulation');

    } else{

      $createurl =" none found";

      $toPhp = null;

    } 

  }

}

 ?>

<!doctype html>

<html>

<head>

  <meta charset="utf-8">

  <title>Countries Search</title>

  <link href=https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css rel="stylesheet"

    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="stylesheet" href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css

    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="

    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link href=https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css rel="stylesheet">

  <link rel="stylesheet" href="../css/main.css">

</head>

<body>

  <div id="fixed-header" class="shadow-sm">

    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow">

      <div class="container-fluid px-5">

        <a class="navbar-brand" href="">

          <span class="fw-bold fs-3">Rest Countries</span>

        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">

          <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

          <div class="navbar-nav ms-auto">

            <a class="nav-link" aria-current="page" href="index.php">Home</a>

            <a class="nav-link active" href="searchbyfilter.php">Search by Filter</a>

            <a class="nav-link" href="allcountries.php">All Countries</a>

          </div>

        </div>

      </div>

    </nav>

    <div class="container mt-5">

        <form  action="searchbyfilter.php" method="post">

          <div class="input-group">

            <select name="searchfilter" class="form-select" id="inputGroupSelect01" style="max-width:100px;border-color: #0d6efd;margin-right: 1px;" required>

              <?php

                if($_POST["searchfilter"]=="name"){

                  echo '<option value="name" selected>Name</option><option value="code">Code</option>';

                } elseif($_POST["searchfilter"] == "code"){

                  echo '<option value="name">Name</option><option value="code" selected>Code</option>';

                } else {

                  echo '<option value="name" selected>Name</option><option value="code">Code</option>';

                }

              ?>

            </select>

            <input value="<?php echo $_POST["searchCountry"]; ?>" name="searchCountry" type="text" class="form-control" placeholder="Enter Country Name or Alpha Code" aria-label="Example text with button addon" aria-describedby="button-addon1" required>

            <button type="submit" class="btn btn-outline-primary" type="button" id="button-addon1"> <i class="fa-solid fa-magnifying-glass"></i></button>

          </div>

        </form>

        <form action="allcountries.php" method="post">

          <button class="btn btn-link btn-sm ps-0"> Show all Countries</button>

        </form>        

          <?php

            if( !(empty($_POST["searchCountry"])) ){

              echo '<p>Searching for: "';

              echo $_POST["searchCountry"];

              echo '"</p>';

            }

          ?>

        <div class="input-group mb-3 d-none">

          <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-magnifying-glass"></i></span>

          <input id="tableSearch" type="text" class="form-control" placeholder="Enter Name or Country Code"

            aria-label="Recipient's username" aria-describedby="basic-addon2">

        </div>

      <nav class="d-none" aria-label="Page navigation example" id="cards-pagination">

        <ul id="pagination-demo" class="pagination justify-content-center">

        </ul>

      </nav>

    </div>

  </div>

  <button onclick="topFunction()" id="myBtn" class="btn btn-secondary"><i class="fa-solid fa-arrow-up"></i></button>

  <div class="container" id="fixed-header-body">

    <br>        

          <div  id="info-container">

          <?php

            if(!(is_null($toPhp)) && $toPhp != ""){

              $page = 0;

              $pagenum = 1;

              for( $i = 0; $i < count($toPhp); $i++) {

                $page = $page + 1;

                if($page == 1){                

                  echo '<div class="row justify-content-center page" id="page'.$pagenum.'">';

                  $pagenum = $pagenum + 1;

                }

                echo '<div class="country-container col-10 col-md-4 exists"><div class="card my-4">';

                echo '<img src="'.$toPhp[$i]['flags']['svg'].'" class="card-img-top" alt="..." >';

                echo '<div class="card-body"> ';

                echo '<div class="text-center fw-bold">'.$toPhp[$i]['name']['common'].'</div>';

                echo '<div style="font-size: 0.85rem;">';

                echo '<div class="mb-1"><strong>Capital</strong>: ';               

                if (is_countable($toPhp[$i]['capital']) && count($toPhp[$i]['capital']) > 0){                

                  foreach ($toPhp[$i]['capital'] as $value) {

                    echo "$value ";

                  }

                }  

                echo '</div>'; 

                echo '<div class="mb-1"><strong>Region</strong>: '.$toPhp[$i]['region'].'</div>'; 

                echo '<div class="mb-1"><strong>Subregion</strong>: '.$toPhp[$i]['subregion'].'</div>';

                echo '<div class="mb-1"><strong>Languages</strong>: <ul  class="horizontal-list">';

                if (is_countable($toPhp[$i]['languages']) && count($toPhp[$i]['languages']) > 0){                

                  foreach ($toPhp[$i]['languages'] as $value) {

                    echo "<li>$value</li>";

                  }

                }              

                echo '</ul></div>';

                echo '<div class="mb-1"><strong>Population</strong>: '.$toPhp[$i]['population'].'</div>';

                echo '<div class="mb-1"><strong>Currencies</strong>: <ul"> ';

                if (is_countable($toPhp[$i]['currencies']) && count($toPhp[$i]['currencies']) > 0){

                  foreach ($toPhp[$i]['currencies'] as $value) {

                    $z = 0;

                    foreach ($value as $val) {

                      $z = $z + 1;

                      if($z % 2 == 0){

                        echo $val.' </li> ';

                      }

                      else{

                        echo '<li>'.$val.' ';

                      }

                    }

                  }

                }

 

                echo '</ul></div>';

                echo '<div class="mb-1"><strong>Alpha Code2</strong>: '.$toPhp[$i]['cca2'].'</div>';

                echo '<div class="mb-1"><strong>Alpha Code3</strong>: '.$toPhp[$i]['cca3'].'</div>';

                echo '</div>';

                echo ' </div></div></div>';


                if($page == 50){                

                  echo '</div>';

                  $page = 0;

                }

 

              }

            } else{

                echo '<div id="no-results-container"><div class="alert alert-warning text-center fw-bold" role="alert">No results to show</div></div>';

            }

          ?>         

      </div>      

    </div>

  </div>

  <script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js

    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="

    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src=https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js

    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"

    crossorigin="anonymous"></script>

  <script src=https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js></script>

  <script src=https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>

  <script src="../js/app.js"></script>

</body>

</html>

 