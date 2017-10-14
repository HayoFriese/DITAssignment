<?php
	ini_set("session.save_path", "/home/unn_w13020720/sessionData");
	session_start(); 
	require_once('functions.php');
	include 'data_conn.php';
	
	//If the function calls $_GET[CDID], or if a cd has been clicked on, get that id, and display a different page.
	if(isset($_GET['CDID'])){
		$getcdid = $_GET['CDID'];

		$sqlSelect = "SELECT CDID, CDTitle, CDYear, catDesc, pubName, location, CDPrice 
					FROM nmc_cd
					INNER JOIN nmc_publisher ON nmc_publisher.pubID = nmc_cd.pubID
					INNER JOIN nmc_category ON nmc_category.catID = nmc_cd.catID
					WHERE CDID = '$getcdid'";

		$rsCds = mysqli_query($conn, $sqlSelect) or die (mysqli_error($conn));

		while ($row = mysqli_fetch_assoc($rsCds)){
			$CDID = $row['CDID'];
			$title = $row['CDTitle'];
			$year = $row['CDYear'];
			$pub = $row['pubName'];
			$loc = $row['location'];
			$cat = $row['catDesc'];
			$price = $row['CDPrice'];

			echo productStart();
			echo "<div class=\"singleWrapper\">
			<div class=\"singleWrap\">
				<a onclick=\"back()\" href=\"#\" class=\"closeCD\">&#43;</a>
				<div class=\"singleCont\">
					<div class=\"cover\"> 
						<p>&#9835;</p>
					</div>
					<div class=\"singleInfo\">
						<div class=\"title\">
							<h2>$title</h2>
						</div>
						<h3>&pound;$price</h3>
						<div class=\"detailCont\">
							<div class=\"details\"><h4>Genre: </h4><span>$cat</span></div>
							<div class=\"details\"><h4>Released: </h4><span>$year</span></div>
							<div class=\"details\"><h4>Publisher: </h4><span>$pub, ($loc)</span></div>
						</div>";
						if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
							echo "<div class=\"editUpdate\">
								<a href=\"updateProduct.php?CDID=$CDID\">Edit</a>
							</div>";
						}
					echo "</div>
				</div>";
				echo productEnd();	
		}
		mysqli_free_result($rsCds);
	} else {
		//if it isn't receiving a CDID in any query, echo the complete products page.
		echo htmlSet();
		if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
			echo navLogOut("{$_SESSION['username']}");
		}
		else{
			echo navLogIn();
		}
		echo pageStart("searchCont");
?>
			<form id="search" action="search.php" method="get">
				<div class="searchName">
					<input type="text" name="title" placeholder="Enter Title" />
				</div>
				<div class="searchRadio">
					<h2>Year of Release</h2>
					<ul class="selectYear">
						<?php
							$sqlYear = "SELECT DISTINCT CDYear FROM nmc_cd ORDER BY CDYear";
							$rsCds = mysqli_query($conn, $sqlYear) or die (mysqli_error($conn));
							while ($row = mysqli_fetch_assoc($rsCds)){
								$year = $row['CDYear'];
								$id = utf8_encode($row['CDYear']);
								echo "<li class=\"radioCont\">\n";
									echo "<label for=\"$id\">\n<input type=\"radio\" name=\"year\" id=\"$id\" value=\"$year\" />$year\n</label>\n";
								echo "</li>\n";
							}
						?>
					</ul>
				</div>
				<div class="searchOption">
					<select name="category">
						<option value="">-- Select Genre --</option>
						<?php
							$sqlCat = "SELECT DISTINCT catDesc FROM nmc_cd INNER JOIN nmc_category ON nmc_category.catID = nmc_cd.catID ORDER BY catDesc";
							$rsCds = mysqli_query($conn, $sqlCat) or die (mysqli_error($conn));
							while ($row = mysqli_fetch_assoc($rsCds)){
								$cat = $row['catDesc'];
								$cid = htmlspecialchars($cat);
								echo "<option value=\"$cid\">$cid</option>\n";
							}
						?>
					</select>
				</div>
				<div class="searchOption">
					<select name="publisher">
						<option value="">-- Select Publisher --</option>
						<?php
							$sqlPub = "SELECT DISTINCT pubName FROM nmc_cd INNER JOIN nmc_publisher ON nmc_publisher.pubID = nmc_cd.pubID ORDER BY pubName";
							$rsCds = mysqli_query($conn, $sqlPub) or die (mysqli_error($conn));
							while ($row = mysqli_fetch_assoc($rsCds)){
								$pub = $row['pubName'];
								echo "<option value=\"$pub\">$pub</option>\n";
							}
						?>
					</select>
				</div>
				<div class="searchRadio">
					<h2>Price Range</h2>
					<ul class="selectPrice">
						<li class="radioCont">
							<label for="p1">
								<input type="radio" name="price" id="p1" value="8.49" />
								&pound;7.50-8.50
							</label>
						</li>
						<li class="radioCont">
							<label for="p2">
								<input type="radio" name="price" id="p2" value="9.49" />
								&pound;8.50-9.50
							</label>
						</li>
						<li class="radioCont">
							<label for="p3">
								<input type="radio" name="price" id="p3" value="10.49" />
								&pound;9.50-10.50
							</label>
						</li>
						<li class="radioCont">
							<label for="p4">
								<input type="radio" name="price" id="p4" value="11.49" />
								&pound;10.50-11.50
							</label>
						</li>
						<li class="radioCont">
							<label for="p5">
								<input type="radio" name="price" id="p5" value="12.49" />
								&pound;11.50-12.50
							</label>
						</li>
						<li class="radioCont">
							<label for="p6">
								<input type="radio" name="price" id="p6" value="13.49" />
								&pound;12.50+
							</label>
						</li>
					</ul>
				</div>
				<div class="searchOption">
					<select name="order">
						<option value="">--Sort By--</option>
						<option value="">Title</option>
						<option value="year">Year of Release</option>
						<option value="phl">Price (High to Low)</option>
						<option value="plh">Price (Low to High)</option>
					</select>
				</div>

				<input type="submit" value="Find CD" />
			</form>
		</div>
		<div class="cdCont">
			<?php
					$sqlDisplay = "SELECT CDID, CDTitle, CDYear, catDesc, pubName, CDPrice 
									FROM nmc_cd
									INNER JOIN nmc_publisher ON nmc_publisher.pubID = nmc_cd.pubID
									INNER JOIN nmc_category ON nmc_category.catID = nmc_cd.catID
									ORDER BY CDTitle";
					$rsCds = mysqli_query($conn, $sqlDisplay) or die (mysqli_error($conn));
				
					while ($row = mysqli_fetch_assoc($rsCds)){
						$CDID = $row['CDID'];
						$title = $row['CDTitle'];
						$year = $row['CDYear'];
						$pub = $row['pubName'];
						$cat = $row['catDesc'];
						$price = $row['CDPrice'];

						$cid = htmlspecialchars($cat);

						echo "<div class= \"CD\">\n";
							echo "<div class=\"cdimage\">\n";
								echo "<a href=\"products.php?CDID=$CDID\">&#9835;</a>\n";
							echo "</div>\n";
							echo "<div class=\"cdbreak\"></div>\n";
							echo "<div class=\"Title\">
								<span class= \"title\">
								<a href=\"products.php?CDID=$CDID\">$title</a>
								</span>
								</div>\n";
							echo "<div class=\"container\">\n";
								echo "<div class=\"content\"><h2>Year</h2><span class= \"year\">$year</span></div>\n";
								echo "<div class=\"content\"><h2>Genre</h2><span class= \"cat\">$cid</span></div>\n";
								echo "<div class=\"content\"><h2>Price</h2><span class= \"price\">&pound;$price</span></div>\n";
							echo "</div>\n";
						echo "</div>\n";
					}
						echo pageEnd();
					echo footer();
				echo htmlEnd();	
			?>
		
<?php
			mysqli_free_result($rsCds);
		}
	mysqli_close($conn);
?>