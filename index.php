<!doctype html public 
  "-//w3c//dtd html 4.01 transitional//en"
  "http://www.w3.org/tr/1999/rec-html401-19991224/loose.dtd">
<html> 
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>  
<title>Microfilm Newspaper List Search</title>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.2.12/jquery.jgrowl.min.css" />
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.2.12/jquery.jgrowl.min.js"></script>

<script type="text/javascript" src="formly/formly.js"></script>
<link rel="stylesheet" href="formly/formly.css" type="text/css" />

<script type="text/javascript">
	
	$(document).ready(function() {		
		$('#newsform').formly(); 
	});
	
	function validateForm() {
			
		var yearExists = /^\d\d\d\d$/.test(document.forms["newssearch"]["year"].value);
		var titleExists = /[A-Na-n]/.test(document.forms["newssearch"]["title"].value);
		var cityExists = /[A-Na-n]/.test(document.forms["newssearch"]["city"].value);
		var countyExists = document.forms["newssearch"]["county"].value != "";
		
		if (!yearExists && !titleExists && !cityExists && !countyExists) {
			//new Messi('Need something to search', {title: 'Search Error', titleClass: 'info', buttons: [{id: 0, label: 'Close', val: 'X'}]});
			$.jGrowl("Need something to search", { theme: 'validation', header: 'Search Error', live: 10000 });
			return false;
		}
		
	}
</script>
<style type="text/css">
body {
	font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
}
.heading {
	text-align:center;
	font-size:120%;padding:20px;
}
.backto {
	text-align:center;
	padding:10px;
}
a.navlinks {
	text-decoration: none;
}
a.navlinks:hover {
	color: red;
	text-decoration: underline;
}
div.jGrowl div.validation {
	background-color: #808080;
	width: 200px;
	min-height: 0px;
	border: 1px solid #000;
}

</style>
</head> 
<body>
		
	<div class="backto"><a class="navlinks" href="http://www.ohiohistory.org/collections--archives/archives-library">Library/Archives Home</a></div>
	<div class="heading">Microfilm Newspaper List Search</div>
	
	<div style="width:100%">
	
	<form id="newsform" name="newssearch" action="results.php" method="POST" onsubmit="return validateForm()"  style="width: 500px;margin: 0 auto">
	<br/>Title:  <input type="search" name="title" size="25" maxsize="50">
	City:  <input type="search" name="city" size="25" maxsize="50">
	<br/>County: 
	<select type="search" name="county">
		<option value="" selected></option>
		<option value="ADAMS">ADAMS</option>
		<option value="ALLEN">ALLEN</option>
		<option value="ASHLAND">ASHLAND</option>
		<option value="ASHTABULA">ASHTABULA</option>
		<option value="ATHENS">ATHENS</option>
		<option value="AUGLAIZE">AUGLAIZE</option>
		<option value="BELMONT">BELMONT</option>
		<option value="BROWN">BROWN</option>
		<option value="BUTLER">BUTLER</option>
		<option value="CARROLL">CARROLL</option>
		<option value="CHAMPAIGN">CHAMPAIGN</option>
		<option value="CLARK">CLARK</option>
		<option value="CLERMONT">CLERMONT</option>
		<option value="CLINTON">CLINTON</option>
		<option value="COLUMBIANA">COLUMBIANA</option>
		<option value="COSHOCTON">COSHOCTON</option>
		<option value="CRAWFORD">CRAWFORD</option>
		<option value="CUYAHOGA">CUYAHOGA</option>
		<option value="DARKE">DARKE</option>
		<option value="DEFIANCE">DEFIANCE</option>
		<option value="DELAWARE">DELAWARE</option>
		<option value="ERIE">ERIE</option>
		<option value="FAIRFIELD">FAIRFIELD</option>
		<option value="FAYETTE">FAYETTE</option>
		<option value="FRANKLIN">FRANKLIN</option>
		<option value="FULTON">FULTON</option>
		<option value="GALLIA">GALLIA</option>
		<option value="GEAUGA">GEAUGA</option>
		<option value="GREENE">GREENE</option>
		<option value="GUERNSEY">GUERNSEY</option>
		<option value="HAMILTON">HAMILTON</option>
		<option value="HANCOCK">HANCOCK</option>
		<option value="HARDIN">HARDIN</option>
		<option value="HARRISON">HARRISON</option>
		<option value="HENRY">HENRY</option>
		<option value="HIGHLAND">HIGHLAND</option>
		<option value="HOCKING">HOCKING</option>
		<option value="HOLMES">HOLMES</option>
		<option value="HURON">HURON</option>
		<option value="JACKSON">JACKSON</option>
		<option value="JEFFERSON">JEFFERSON</option>
		<option value="KNOX">KNOX</option>
		<option value="LAKE">LAKE</option>
		<option value="LAWRENCE">LAWRENCE</option>
		<option value="LICKING">LICKING</option>
		<option value="LOGAN">LOGAN</option>
		<option value="LORAIN">LORAIN</option>
		<option value="LUCAS">LUCAS</option>
		<option value="MADISON">MADISON</option>
		<option value="MAHONING">MAHONING</option>
		<option value="MARION">MARION</option>
		<option value="MEDINA">MEDINA</option>
		<option value="MEIGS">MEIGS</option>
		<option value="MERCER">MERCER</option>
		<option value="MIAMI">MIAMI</option>
		<option value="MONROE">MONROE</option>
		<option value="MONTGOMERY">MONTGOMERY</option>
		<option value="MORGAN">MORGAN</option>
		<option value="MORROW">MORROW</option>
		<option value="MUSKINGUM">MUSKINGUM</option>
		<option value="NOBLE">NOBLE</option>
		<option value="OTTAWA">OTTAWA</option>
		<option value="PAULDING">PAULDING</option>
		<option value="PERRY">PERRY</option>
		<option value="PICKAWAY">PICKAWAY</option>
		<option value="PIKE">PIKE</option>
		<option value="PORTAGE">PORTAGE</option>
		<option value="PREBLE">PREBLE</option>
		<option value="PUTNAM">PUTNAM</option>
		<option value="RICHLAND">RICHLAND</option>
		<option value="ROSS">ROSS</option>
		<option value="SANDUSKY">SANDUSKY</option>
		<option value="SCIOTO">SCIOTO</option>
		<option value="SENECA">SENECA</option>
		<option value="SHELBY">SHELBY</option>
		<option value="STARK">STARK</option>
		<option value="SUMMIT">SUMMIT</option>
		<option value="TRUMBULL">TRUMBULL</option>
		<option value="TUSCARAWAS">TUSCARAWAS</option>
		<option value="UNION">UNION</option>
		<option value="VAN WERT">VAN WERT</option>
		<option value="VINTON">VINTON</option>
		<option value="WARREN">WARREN</option>
		<option value="WASHINGTON">WASHINGTON</option>
		<option value="WAYNE">WAYNE</option>
		<option value="WILLIAMS">WILLIAMS</option>
		<option value="WOOD">WOOD</option>
		<option value="WYANDOT">WYANDOT</option>
	</select>
	
	Year: <input type="search" name="year" size="4" maxsize="4">
	<br/><input type="submit" value="Search" />
</form>

<div style="width:500px;margin: 0 auto;">
	
<p>This is a database of MICROFILMED Ohio newspapers available for use in the Archives/Library Reading Room or through interlibrary loan.
<br/>Search by NEWSPAPER TITLE, CITY, or COUNTY.</p>

<p>A complete list of all the newspapers, including both filmed and unfilmed (original paper) titles, that are available for use at the Ohio Historical Society's Archives/Library can be accessed using the <a href="http://www.ohiohistory.org/occ/">Online Collection Catalog's</a> Newspaper Database search feature.</p>

</div>

</div>


</body>
</html>