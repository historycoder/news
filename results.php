<?php

// Save in file dbcon.ini:
// [news_connection]
// thishost = "127.0.0.1"
// news_db_title = "news"
// news_db_table = "microfilm"
// user = "user"
// pass = "pass"

$dbcon = parse_ini_file('conf/dbcon.ini');

$county_criterion = "";
$sort = "Title";
$sort_criteria = "Title, BegYear";
$search_criteria = array();
$title_exists = false;
$county_exists = false;
$city_exists = false;
$year_exists = false;
$sort_exists = false;
$nothing_to_search = false;
$message = "";
$no_results = false;
$max_per_page = 20;
$max_rows = 1000;
$start = 1;
$end = $start + ($max_per_page - 1);
$prev_start = 1;
$next_start = $start + $max_per_page;
$num_rows = array();

require 'paginator.class.php';

if (!empty($_POST['title']) || !empty($_GET['title'])) {
	$title_exists = true;
	$title = !empty($_POST['title']) ? substr($_POST['title'],0,50) : substr($_GET['title'],0,50);
	if (preg_match('/[^a-zA-Z ]/', $title)) { exit; }
	$title_criterion = "Title LIKE '%" . $title . "%'";
	array_push($search_criteria, $title_criterion);
}
if (!empty($_POST['city']) || !empty($_GET['city'])) {
	$city_exists = true;
	$city = !empty($_POST['city']) ? substr($_POST['city'],0,50) : substr($_GET['city'],0,50);
	if (preg_match('/[^a-zA-Z ]/', $city)) { exit; }
	$city_criterion = "City LIKE '" . $city . "%'";
	array_push($search_criteria, $city_criterion);
}

if (!empty($_POST['county']) || !empty($_GET['county'])) {
	$county_exists = true;
	$county = !empty($_POST['county']) ? substr($_POST['county'],0,10) : substr($_GET['county'],0,10);
	if (preg_match('/[^a-zA-Z]/', $county)) { exit; }
	$county_criterion = "County = '" . $county . "'";
	array_push($search_criteria, $county_criterion);
}
if (!empty($_POST['year']) || !empty($_GET['year'])) {
	$year = !empty($_POST['year']) ? trim(substr($_POST['year'],0,4)) : trim(substr($_GET['year'],0,4));
	if (preg_match('/[^0-9]/', $year)) { exit; }
	$year_exists = true;
	$year_criteria = "BegYear >= " . $year . " AND EndYear <= " . $year;
	array_push($search_criteria, $year_criteria);
}

if (!empty($_POST['start']) || !empty($_GET['start'])) {
	$start = !empty($_POST['start']) ? substr($_POST['start'],0,10) : substr($_GET['start'],0,10);
	if (preg_match('/[^\d]/', $start)) { exit; }
} 
if (!$county_exists && !$year_exists && !$city_exists && !$title_exists) { 
	$nothing_to_search = true;
	$message = "Need something to search";
}

$statement = "SELECT * FROM " . $dbcon['news_db_table'] . " WHERE ";
$pages = new Paginator;
$criteria_total = count($search_criteria);
if (!$nothing_to_search) {
	for ($i = 0; $i < $criteria_total; $i++) {
		if ($i > 0) { $statement .= " AND "; }
	 	$statement .= array_shift($search_criteria);
	}
	
	$count_statement = preg_replace('/\*/','count(*)',$statement);
	try {
		
		$db = new PDO('mysql:host='.$dbcon['thishost'].';dbname='.$dbcon['news_db_title'].';charset=utf8', $dbcon['user'], $dbcon['pass']);  
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$num_rows[0] = $db->query($count_statement)->fetchColumn();
		if ($num_rows[0] < 1) { $no_results = true; }
		$pages->items_total = $num_rows[0];
		$pages->mid_range = 5;
		$pages->paginate();
		
		$statement .= " ORDER BY " . $sort_criteria . " " . $pages->limit;
		
		$db = new PDO('mysql:host='.$dbcon['thishost'].';dbname='.$dbcon['news_db_title'].';charset=utf8', $dbcon['user'], $dbcon['pass']);
		$results = $db->query($statement);
		$db = null;
		
	} catch(PDOException $e) {  
		print($e->getMessage());
		die();
	}
	
}

?>

<!doctype html public 
  "-//w3c//dtd html 4.01 transitional//en"
  "http://www.w3.org/tr/1999/rec-html401-19991224/loose.dtd">
<html>
<head>
<title>Microfilm Newspaper List Search results</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/> 

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/json2/20121008/json2.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jStorage/0.3.0/jstorage.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

<link type="text/css" rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.6.0/jquery.selectBoxIt.css" />
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.6.0/jquery.selectBoxIt.min.js"></script>

<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.2.12/jquery.jgrowl.min.css" />
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.2.12/jquery.jgrowl.min.js"></script>

<script type="text/javascript" src="formly/formly.js"></script>
<link rel="stylesheet" href="formly/formly.css" type="text/css" />

<style type="text/css">

body {
	font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
}

.paging-section {
	text-align:center;
	padding:6px;
	height: 30px;
}
	
.paginate {
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
}

a.paginate {
	border: 1px solid #000080;
	padding: 2px 6px 2px 6px;
	text-decoration: none;
	color: #000080;
}

a.paginate:hover {
	background-color: #000080;
	color: #FFF;
	text-decoration: underline;
}

a.current {
	border: 1px solid #000080;
	font: bold .7em Arial,Helvetica,sans-serif;
	padding: 2px 6px 2px 6px;
	cursor: default;
	background:#000080;
	color: #FFF;
	text-decoration: none;
}

span.inactive {
	border: 1px solid #999;
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
	padding: 2px 6px 2px 6px;
	color: #999;
	cursor: default;
}

a.navlinks {
	text-decoration:none;
}
a.navlinks:hover {
	color: red;
	text-decoration: underline;
}

div.jGrowl div.resultsAlerts {
	background-color: #808080;
	width: 200px;
	min-height: 0px;
	border: 1px solid #000;
}

</style>

<script type="text/javascript">	
	$(document).ready(function() {
		$('#newsResults').formly(); 		
	});	
</script>

	
</head>
<body>

<div style="text-align:center;padding:20px;">
	<a class="navlinks" href="index.php">Microfilm Newspaper List</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a class="navlinks" href="http://www.ohiohistory.org/collections--archives/archives-library">Library/Archives Home</a>
</div>
 	
<div class="paging-section">
	<?php echo $pages->display_pages(); ?>
</div>

<br/>

<?php
	echo( '<div style="width:100%">' );
	echo( '<form id="newsResults" style="margin: 0 auto; width: 500px">' );
	
	if ($nothing_to_search) {
		echo("<p>".$message."</p>");
	} else if ($no_results) { 
		echo("<p>No results.</p>");
	} else {
		
		while($row = $results->fetch(PDO::FETCH_ASSOC)) {
			
			echo( '<label for="result-'.$row['ID'].'">'. $row['Title'] );
			echo( '<span style="white-space: normal; font-size:80%">' );
			echo( ", " );
			echo( (trim($row['Rollnumber']) != "") ? $row['Rollnumber'] : "n/a" );
			echo( ", " );
			echo(  $row['BegMonth'] . "/" . $row['BegDay'] . "/" . $row['BegYear'] );
			echo( " - " );
			echo( $row['EndMonth'] . "/" . $row['EndDay'] . "/" . $row['EndYear'] );
			echo( ", " );
			echo( (trim($row['City']) != "") ? $row['City'] : "na" );
			echo( ", " );
			echo( (trim($row['County']) != "") ? $row['County'] . " County" : "n/a" );

			echo( "</span>" );
			echo( '</label><br/>' );
			echo( '<hr>' );
		}
		
	}
	echo( '</form>' );
	echo( '<form id="searchVals" action="results.php" method="post">' );
	echo( '<input type="hidden" name="Title" value="'.($title_exists ? $title : "").'">' );
	echo( '<input type="hidden" name="County" value="'.($county_exists ? $county : "").'">' );
	echo( '<input type="hidden" name="Year" value="'.($year_exists ? $year : "").'">' );
	echo( '<input type="hidden" name="City" value="'.($city_exists ? $city : "").'">' );
	echo( '<input type="hidden" name="sort" value="'.($sort_exists ? $sort : "").'">' );
	echo( '<input type="hidden" name="start" value="'.$start.'">' );
	echo( '</form>' );
	echo( '</div>' );	
?>

<div style="text-align:center;padding:6px; height: 30px;margin-top:10px;">
   
    <a href="index.php">Microfilm Newspaper List Home</a>&nbsp;&nbsp;
	<?php echo $pages->display_pages(); ?>
   
</div> 
	
  </body>
</html>

