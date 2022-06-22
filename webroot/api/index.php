<?php
 $url = file_get_contents('https://restcountries.com/v3.1/all');
 $toPhp = json_decode($url, true);
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
  <nav class="navbar navbar-dark bg-dark shadow">
    <div class="container-fluid px-5">
      <a class="navbar-brand" href="#">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b9/Marvel_Logo.svg" alt="" height="35"
          style="margin: -6px 0;" class="d-inline-block align-text-top">
        <span class="fw-bold fs-3">Earth-616 </span> <span class="fs-6"> : Countries list</span>
      </a>
    </div>
  </nav>

  <div class="container mt-5">
    <br>
    <!-- Nav tabs -->
    <ul class="nav nav-pills nav-justified" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#home">Card View</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#menu1">Table View</a>
      </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div id="home" class="container tab-pane active"><br>
        <div class="container mt-5">
          <div class="row  justify-content-center">
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-magnifying-glass"></i></span>
              <input id="tableSearch" type="text" class="form-control" placeholder="Enter Name or Country Code"
                aria-label="Recipient's username" aria-describedby="basic-addon2">
            </div>
          </div>
          <div class="row justify-content-center" id="info-container">
          <?php
            for( $i = 0; $i < count($toPhp); $i++) {

              echo '<div class="country-container col-10 col-md-4 col-lg-3 exists"><div class="card my-4 shadow">';

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
            }
          ?>
      </div>
      <div id="no-results-container">
        <div class="alert alert-warning text-center fw-bold" role="alert">
          No results found!
        </div>
      </div>
    </div>
  </div>

  <!-- Table view -->

      <div id="menu1" class="container tab-pane fade pb-5 mb-5"><br><br>
        <div class="card p-4 shadow">
          <table id="countrydatatable" class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <th>Country Name</th>
                <th>Capital</th>
                <th>Region</th>
                <th>Subregion</th>
                <th>Languages</th>
                <th>Population</th>
                <th>Currencies</th>
                <th>Alpha Code 2</th>
                <th>Alpha Code 3</th>
                <th>Flag</th>
              </tr>
            </thead>
            <tbody>
              <?php
            for( $i = 0; $i < count($toPhp); $i++){
                echo '<tr>';
                echo '<td>'.$toPhp[$i]['name']['common'].'</td>';
                echo '<td>';
                if (is_countable($toPhp[$i]['capital']) && count($toPhp[$i]['capital']) > 0){                
                    foreach ($toPhp[$i]['capital'] as $value) {
                      echo "$value ";
                    }
                  } 
                echo '</td>';
                echo '<td>'.$toPhp[$i]['region'].'</td>';
                echo '<td>'.$toPhp[$i]['subregion'].'</td>';
                echo '<td><ul>';
                if (is_countable($toPhp[$i]['languages']) && count($toPhp[$i]['languages']) > 0){                
                    foreach ($toPhp[$i]['languages'] as $value) {
                      echo "<li>$value</li>";
                    }
                  }  
                echo '</ul></td>';
                echo '<td>'.$toPhp[$i]['population'].'</td>';
                echo '<td><ul>';
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
                echo '</ul></td>';
                echo '<td>'.$toPhp[$i]['cca2'].'</td>';
                echo '<td>'.$toPhp[$i]['cca3'].'</td>';
                echo '<td><img src="'.$toPhp[$i]['flags']['svg'].'" class="card-img-top" alt="..." ></td>';
                echo '</tr>';
            }
            ?>
            </tbody>            
          </table>
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
  <script src="../js/app.js"></script>
</body>

</html>
