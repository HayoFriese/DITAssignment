<?php
	ini_set("session.save_path", "/home/unn_w13020720/sessionData");
	session_start(); 
	include 'data_conn.php';
	require_once('functions.php');
	
	echo htmlSet();
	//in order to update, the user must be signed in. this verifies whether that is the case.
	if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
		//if you get the CDID via the edit button
		if(isset($_GET['CDID'])){
			//store the ID in a variable
			$getcdid = $_GET['CDID'];

			//Get everything from NCM_CD where the id is equal to the one submitted.
			$sqlCD = "SELECT CDID, CDTitle, CDYear, nmc_category.catID, catDesc, nmc_publisher.pubID, pubName, CDPrice 
						FROM nmc_cd
						INNER JOIN nmc_publisher ON nmc_publisher.pubID = nmc_cd.pubID
						INNER JOIN nmc_category ON nmc_category.catID = nmc_cd.catID
						WHERE CDID = '$getcdid'";
		
			//Selecting everything from cat and publisher is done for comparison later, as wel as echoing all existing variables for selection. 
			$sqlPub = "SELECT * FROM nmc_publisher";
			$sqlCat = "SELECT * FROM nmc_category";
			//select all the available years within nmc_cd
			$sqlYear = "SELECT DISTINCT CDYear FROM nmc_cd ORDER BY CDYear";

			//run each query
			$rCD = mysqli_query($conn, $sqlCD) or die (mysqli_error($conn));
			$rYear = mysqli_query($conn, $sqlYear) or die (mysqli_error($conn));
			$rPub = mysqli_query($conn, $sqlPub) or die(mysqli_error($conn));
			$rCat = mysqli_query($conn, $sqlCat) or die(mysqli_error($conn));
	
			//put all CDs in their own variables.
			$rowCD = mysqli_fetch_assoc($rCD);
				$catIDCD = $rowCD['catID'];
				$pubIDCD = $rowCD['pubID'];
				$CDID = $rowCD['CDID'];
				$title = $rowCD['CDTitle'];
				$yearCD = $rowCD['CDYear'];
				$pubCD = $rowCD['pubName'];
				$catCD = $rowCD['catDesc'];
				$price = $rowCD['CDPrice'];

			echo productStart();
			
			echo "<div class=\"singleWrapper\">
			<form class=\"singleWrap\" method=\"post\" action=\"updateProduct.php\">
				<a href=\"products.php\" class=\"closeCD\">&#43;</a>
				<div class=\"singleCont\">
					<div class=\"cover\"> 
						<p>&#9835;</p>
					</div>
					<div class=\"singleInfo\">
						<div class=\"title\">
							<input type=\"hidden\" name=\"CDID\" value=\"$getcdid\">
							<input type=\"text\" id=\"title\" name=\"title\" value=\"$title\">
						</div>
						<h3>&pound;<input type=\"number\" name=\"price\" step=\"0.01\" value=\"$price\"></h3>
						<div class=\"detailCont\">
							<div class=\"details\">
								<h4>Genre: </h4>
								<select name=\"category\">";
									while($rowCat = mysqli_fetch_assoc($rCat)){
										$catID = $rowCat['catID'];
										$cat = $rowCat['catDesc'];
										$cid = htmlspecialchars($cat);
										//compare the CD's original category with the available categories. if they are the same, set it as the default selected variable.
										if($cid == $catCD){
											echo "<option value=\"$catID\" selected>$cid</option>\n";
										} else{
											echo "<option value=\"$catID\">$cid</option>\n";
										}
										
									}
								echo "</select>
							</div>
							<div class=\"details\">
								<h4>Released: </h4>
								<select name=\"year\">";
									while($rowYear = mysqli_fetch_assoc($rYear)){
										$year = $rowYear['CDYear'];
										$yid = utf8_encode($year);
										//same for year. 
										if($yid == $yearCD){
											echo "<option value=\"$yid\" selected>$yid</option>\n";
										} else{
											echo "<option value=\"$yid\">$yid</option>\n";
										}
									}
								echo "</select>
							</div>
							<div class=\"details\">
								<h4>Publisher: </h4>
								<select name=\"publisher\">";
									while($rowPub = mysqli_fetch_assoc($rPub)){
										$pubID = $rowPub['pubID'];
										$pub = $rowPub['pubName'];
										//same for publisher
										if($pub == $pubCD){
											echo "<option value=\"$pubID\" selected>$pub</option>\n";
										} else{
										echo "<option value=\"$pubID\">$pub</option>\n";
										}
									}
								echo "</select>
							</div>
						</div>";
						if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
							echo "<div class=\"editUpdate\">
								<input type=\"submit\" name=\"update\" value=\"Update\">
							</div>";
						}
					echo "</div>
				</form>";
			echo productEnd();
		}
		elseif(isset($_POST['update'])) {
			$getcdid = $_POST['CDID'];
			$errors = [];

			//check if the input_post of name has a variable, if so print the variable, else print null
			$CDTitle = filter_has_var(INPUT_POST, 'title') ? $_POST['title']: null;
			$CDYear = filter_has_var(INPUT_POST, 'year') ? $_POST['year']: null;
			$idpub = filter_has_var(INPUT_POST, 'publisher') ? $_POST['publisher']: null;
			$idcat = filter_has_var(INPUT_POST, 'category') ? $_POST['category']: null;
			$CDPrice = filter_has_var(INPUT_POST, 'price') ? $_POST['price']: null;			

			//remove whitespace
			$CDTitle = trim($CDTitle);
			$CDYear = trim($CDYear);
			$idpub = trim($idpub);
			$idcat = trim($idcat);
			$CDPrice = trim($CDPrice);

			//remove encode tags
			$CDTitle=filter_var($CDTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$CDYear=filter_var($CDYear, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$idpub=filter_var($idpub, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$idcat=filter_var($idcat, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$CDPrice=filter_var($CDPrice, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

			//sanitize for special chars
			$CDTitle= filter_var($CDTitle, FILTER_SANITIZE_SPECIAL_CHARS);
			$CDYear= filter_var($CDYear, FILTER_SANITIZE_SPECIAL_CHARS);
			$idpub= filter_var($idpub, FILTER_SANITIZE_SPECIAL_CHARS);
			$idcat= filter_var($idcat, FILTER_SANITIZE_SPECIAL_CHARS);
			$CDPrice= filter_var($CDPrice, FILTER_SANITIZE_SPECIAL_CHARS);

			//if the year is numeric.
			if(!is_float($CDYear)){
				$errors = "<p>Please enter a valid year</p>";
			}
			//if the values are empty or null
			elseif(!empty($CDTitle) || !empty($CDYear) || !empty($idpub) || !empty($idcat) || !empty($CDPrice)){
				$errors = "<p>Please fill in all fields</p>";
			}
			//if the category id is numeric
			elseif(!is_numeric($idcat)){
				$errors = "<p>Please select a valid category</p>";
			}

			//if there are errors, display them in a list, otherwise, continue with the execution of the code.
			if(is_array($errors)){
				echo "<ul>";
				foreach($errors as $key => $value){
					echo "<li>$value </li>";
				}
				echo "</ul>";
			}
			//update the nmc_cd table via command-style prepared statement. No need for inner join as the category and publisher arent being changed, just the refering id in the nmc_cd table
			else{
				$sqlUpdate = "UPDATE nmc_cd SET CDTitle = ?, CDYear = ?, pubID = ?, catID = ?, CDPrice = ? WHERE CDID = ?";
				$stmt = mysqli_prepare($conn, $sqlUpdate) or die(mysqli_error($conn));
				mysqli_stmt_bind_param($stmt, "sdsddd", $CDTitle, $CDYear, $idpub, $idcat, $CDPrice, $getcdid) or die(mysqli_error($conn));
				mysqli_stmt_execute($stmt) or die(mysqli_error($conn));
				mysqli_stmt_close($stmt);	

				//echo success statement for verification of the function having succeeded
				$sqlSuccess = "SELECT CDID, CDTitle, CDYear, catDesc, pubName, location, CDPrice 
					FROM nmc_cd
					INNER JOIN nmc_publisher ON nmc_publisher.pubID = nmc_cd.pubID
					INNER JOIN nmc_category ON nmc_category.catID = nmc_cd.catID
					WHERE CDID = '$getcdid'";
				//run the query
				$rSuccess = mysqli_query($conn, $sqlSuccess) or die (mysqli_error($conn));
				//echo the query. This is not necessary to display, but has merely been used for debugging. 
				while ($rowSuccess = mysqli_fetch_assoc($rSuccess)){
					$idcd = $rowSuccess['CDID'];
					$sTitle = $rowSuccess['CDTitle'];
					$sYear = $rowSuccess['CDYear'];
					$sPub = $rowSuccess['pubName'];
					$sLoc = $rowSuccess['location'];
					$sCat = $rowSuccess['catDesc'];
					$sPrice = $rowSuccess['CDPrice'];
				
					echo "<div id=\"successUpdate\">
						<div id=\"successCont\">
							<p><a href=\"updateProduct.php?CDID=$idcd\">Back...</a></p>
							<h1>$sTitle was successfully updated!</h1>
							<div>
								<h2>Price: </h2>
									<p>$sPrice</p>
							</div>
							<div>
								<h2>Genre: </h2>
									<p>$sCat</p>
							</div>
							<div>
								<h2>Released: </h2>
									<p>$sYear</p>
							</div>
							<div>
								<h2>Publisher: </h2>
									<p>$sPub ($sLoc)</p>		
							</div>
						</div>
					</div>
					";
				}

				//go to products.php and lcose the connection.
				header('location: products.php');
				mysqli_close($conn);

			}
		}	
	}else{
		echo navLogIn();
	}
?>	