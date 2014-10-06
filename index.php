<?php 
$path='';
require "ohcsite/webbodyheader.php" ?>
	<div class="container">	
			<div id="heading" class="container"><h1>Microfilm Newspaper List Search<h1>
			</div>
			
			<div id="maincontent" class="container">
			<div class="maincontent">
				<form id="newsform" name="newssearch" action="results.php" method="POST" onsubmit="return validateForm()">
				<br/>
				Title:  <input type="search" name="title" size="25" maxsize="50">
				City: <input type="search" name="city" size="25" maxsize="50">
				<br/>
				County: 
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
				<br/>
				<input type="submit" value="Search" />
				</form>

			<div id="instructions">
				<p>This is a database of MICROFILMED Ohio newspapers available for use in the Archives/Library Reading Room or through interlibrary loan.
				<br/>Search by NEWSPAPER TITLE, CITY, or COUNTY.</p>
			</div>
			</div>
			</div>
			<div id="endmaincontent" class="container"></div>
			<div id="altinstructions" class="container">
				<p>A complete list of all the newspapers, including both filmed and unfilmed (original paper) titles, that are available for use at the Ohio Historical Society's Archives/Library can be accessed using the <a href="http://www.ohiohistory.org/occ/">Online Collection Catalog's</a> Newspaper Database search feature.</p>
			</div>
		</div>	

<?php require "ohcsite/webfooterendbody.php" ?>