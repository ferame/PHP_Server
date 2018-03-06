<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $table = null;
    if ($_GET['table'] === 'students' || $_GET['table'] === 'personal_tutors' || $_GET['table'] === 'tutorials') {
        $table = $_GET['table'];
    }
    if (!is_null($table)) {
        echo <<<EOF
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">DATABASE</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/index.php">Structure</a></li>
        <li><a href="tableData.php?table=personal_tutors">Personal Tutors</a></li>
        <li><a href="tableData.php?table=students">Students</a></li>
        <li><a href="tableData.php?table=tutorials">Tutorials</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
    </div>
    <div class="col-sm-8 text-left"> 
EOF;

        $json = dbQueryRequest("/" . $table . "/");
        if ($table === "personal_tutors"){
            echo "<h2>Personal Tutors</h2>";
        }elseif ($table === "students"){
            echo "<h2>Students</h2>";
        }else{
            echo "<h2>Tutorials</h2>";
        }

        if (count($json) !== 0) {
            echo <<<EOF
    <div class="table-responsive">          
      <table class="table">
        <thead>
          <tr>
EOF;

            foreach ($json[0] AS $key => $name) {
                echo "<th>" . $key . "</th>";
            }
            // <th>Column</th>
            echo <<<EOF
          </tr>
        </thead>
        <tbody>
EOF;

            foreach ($json as $row) {
                echo "<tr>";
                foreach ($row as $key => $val) {
                    echo "<td>" . $val . "</td>";
                }
                echo "</tr>";
            }

            echo <<<EOF
        </tbody>
      </table>
      </div>
      </div>
EOF;
        } else {
            echo "<h2>This table is empty</h2>";
        }
echo <<<EOF
      <hr>      
    <div class="col-sm-2 sidenav">
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Project: <b>"Smart Offices and Event Participation Tracking with Internet of Things"</b></p>
</footer>

</body>
EOF;
    }
}
function dbQueryRequest($query){
    $curl = curl_init();
    $fullQuery = "http://tweety.gq/ArrestDB" . $query;

    curl_setopt_array($curl, array(
        //CURLOPT_URL => ("http://tweety.gq/ArrestDB/students/rfid/" . $processedRFID),
        CURLOPT_URL => $fullQuery,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
        return NULL;
    } else {
        return json_decode($response, true);
    }
}
?>