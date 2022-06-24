<?php

 

$arrContextOptions=array(

  "ssl"=>array(

      "verify_peer"=>false,

      "verify_peer_name"=>false,

  ),

);

 $url = file_get_contents('https://restcountries.com/v3.1/all', false, stream_context_create($arrContextOptions));

 $toPhp = json_decode($url, true);

 

 function sortBypopulation($a, $b) {

  return $a['population'] < $b['population'];

}

 

usort($toPhp, 'sortBypopulation');

 

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

    <nav class="navbar navbar-dark bg-dark shadow">

      <div class="container-fluid px-5">

        <a class="navbar-brand" href="">

          <span class="fw-bold fs-3">Rest Countries</span> <span class="fs-6"> Search</span>

        </a>

      </div>

    </nav>

    <div class="container mt-5">

      <div class="row  justify-content-center">

        <form  action="index.php" method="post">

          <div class="input-group mb-4">

            <button type="submit" class="btn btn-outline-primary" type="button" id="button-addon1">Search <i class="fa-solid fa-magnifying-glass"></i></button>

            <input value="<?php echo $_POST["searchCountry"]; ?>" name="searchCountry" type="text" class="form-control" placeholder="Enter Country Name or Alpha Code" aria-label="Example text with button addon" aria-describedby="button-addon1" required>
            <a href="" class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fa-solid fa-circle-xmark"></i></a>

          </div>

        </form>

        <!-- <div class="input-group mb-3">

          <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-magnifying-glass"></i></span>

          <input id="tableSearch" type="text" class="form-control" placeholder="Enter Name or Country Code"

            aria-label="Recipient's username" aria-describedby="basic-addon2">

        </div> -->

      </div>

      <nav aria-label="Page navigation example" id="cards-pagination">

        <ul id="pagination-demo" class="pagination justify-content-center">

        </ul>

      </nav>

    </div>

  </div>

 

  <button onclick="topFunction()" id="myBtn" class="btn btn-secondary"><i class="fa-solid fa-arrow-up"></i></button>

 

  <div class="container" id="fixed-header-body">

    <br>

    <!-- Tab panes -->

    <div class="tab-content">

      <div id="home" class="container tab-pane active">

        <div class="container">

         

          <div  id="info-container">

         

          <?php

 

            $page = 0;

            $pagenum = 1;

            for( $i = 0; $i < count($toPhp); $i++) {

              $page = $page + 1;

              if($page == 1){                

                echo '<div class="row justify-content-center page" id="page'.$pagenum.'">';

                $pagenum = $pagenum + 1;

              }

 

              echo '<div class="country-container col-10 col-md-4 col-lg-3 exists"><div class="card my-4">';

 

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

          ?>

      </div>

      <div class="no-results-container">

        <div class="alert alert-warning text-center fw-bold" role="alert">

          No results found!

        </div>

      </div>

    </div>

  </div>

 

     

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

  <script src=https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js></script>

  <script src="../js/app.js"></script>

</body>

 

</html>