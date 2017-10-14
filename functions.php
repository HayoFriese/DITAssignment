<?php
//PAGE STRUCTURES
	function htmlSet(){
		$pageStartContent = <<<HTMLSTART
		<!doctype html>
		<html lang="en">
		<head>
			<meta charset="UTF-8" />
			<title>Assignment A</title>
			<link rel="stylesheet" type="text/css" href="cd.css">
		</head>
		<body>
			<div class="wrapper">
HTMLSTART;
		$pageStartContent .="\n";
		return $pageStartContent;
	}

	function navLogIn(){
		$pageBanner = <<<BANNER
		<div class="bannerCont">
			<div class="navCont">
				<div class="bannerLogo">
					<a href="index.php">NMC Co.</a>
				</div>
				<ul>
					<li><form action="search.php" method="get"><input type="text" id="keywords" name="keyword" placeholder="Search CD..."></form></li>
					<li><a href="orderCDsForm.php">Order</a></li>
					<li><a href="products.php">Browse</a></li>
					<li><a href="credits.php">Credits</a></li>
					<li><a>Log On</a><form method="post" action="signin.php">
						<ul class="logonCont">
							<li><input type="text" name="username" placeholder="Username..."></li>
							<li><input type="password" name="password" placeholder="Password..."></li>
							<li><input type="submit" name="logon" value="Log On"></li>
						</ul>
						</form>
					</li>
				</ul>
			</div>

		</div>
BANNER;
	$pageBanner .= "\n";
	return $pageBanner;
	}

	function navLogOut($uname){
		$pageBanner = <<<BANNER
		<div class="bannerCont">
			<div class="navCont">
				<div class="bannerLogo">
					<a href="index.php">NMC Co.</a>
				</div>
				<ul>
					<li><form action="search.php" method="get"><input type="text" id="keywords" name="keyword" placeholder="Search CD..."></form></li>
					<li><a href="orderCDsForm.php">Order</a></li>
					<li><a href="products.php">Browse</a></li>
					<li><a href="credits.php">Credits</a></li>
					<li><a>$uname</a>
						<ul class="signoutCont">
							<li><a href="signout.php">Sign Out</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
BANNER;
	$pageBanner .= "\n";
	return $pageBanner;
	}

	function footer(){
		$footer = <<<FOOTER
		<footer>
			<div class="footercont">
				<p>&copy; 2015 Hayo Friese, W13020720 Northumbria University Web Design &amp; Development. All Rights Reserved</p>
			</div>
		</footer>
FOOTER;
		$footer .="\n";
		return $footer;
	}

	function htmlEnd(){
		$htmlEnd = <<<HTMLEND
			<script src="jquery-2.2.3.min.js"></script>
			<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
			<script src="cd.js"></script>
		</div>
		</body>
		</html>
HTMLEND;
	$htmlEnd .= "\n";
	return $htmlEnd;
	}

/************************************************************************************************/

//HOMEPAGE
	function homeStart(){
		$homeStart = <<<HOMESTART
		<div class="welcome">
			<div class="welcomeBlack">
				<div class="headerCont">
					<h2>The Best Tunes in the North East</h2>
				</div>
			</div>
		</div>
		<div class="contWrapper">
			<div class="home">
				<div class="homeCont">
HOMESTART;
		$homeStart .="\n";
		return $homeStart;
	}

	function sectionTitle($sectionTitle){
		$section = <<<SECTIONTITLE
		<div class="secCont">
				<h3>$sectionTitle</h3>
		</div>
SECTIONTITLE;
		$section .="\n";
		return $section;
	}

	function offer($idJSON, $idHTML){
		$offer = <<<HOMEOFFER
		<div class="offerCont">
			<div class="homeOffer">
				<div class="offerCover">
					<p>&#9835;</p>
				</div>
				<div class="offerInformation">
					<aside id="$idJSON"></aside>
				</div>
			</div>
			<div class="homeOffer">
				<div class="offerCover">
					<p>&#9835;</p>
				</div>
				<div class="offerInformation">
					<aside id="$idHTML"></aside>
				</div>
			</div>
		</div>
HOMEOFFER;
		$offer .= "\n";
		return $offer;
	}

	function release($img, $title, $artist, $fauxButton){
		$contentBox = <<<RELEASED
		<div class="contCont">
			<div class="black">
				<div class="homeImg" style="background: url(images/$img) no-repeat  center">
				</div>
			</div>
			<div class="homeBreak"></div>
			<div class="homeTitle">
				<h3>$title</h3>
			</div>
			<div class="container">
				<h4>$artist</h4>
				<div class="content">
					<a href="#">$fauxButton</a>
				</div>
			</div>
		</div>
RELEASED;
		$contentBox .="\n";
		return $contentBox;
	}

	function genre($img, $title, $fauxButton){
		$contentBox = <<<GENRE
		<div class="contCont">
			<div class="black">
				<div class="homeImg" style="background: url(images/$img) no-repeat  center">
				</div>
			</div>
			<div class="homeBreak"></div>
			<div class="homeTitle">
				<h3>$title</h3>
			</div>
			<div class="container">
				<div class="content">
					<a href="#">$fauxButton</a>
				</div>
			</div>
		</div>
GENRE;
		$contentBox .="\n";
		return $contentBox;
	}

	function homeEnd(){
		$homeEnd = <<<HOMEEND
					</div>
				</div>		
			</div>
HOMEEND;
		$homeEnd .="\n";
		return $homeEnd;
	}

/************************************************************************************************/

//PRODUCTS & SEARCH PAGE
	function pageStart($container){
		$pageStart = <<<PAGESTART
		<div class="mainCont">
			<div class="$container">
PAGESTART;
		$pageStart .="\n";
		return $pageStart;
	}

	function pageEnd(){
		$pageEnd = <<<PAGEEND
			</div>
		</div>
PAGEEND;
		$pageEnd .="\n";
		return $pageEnd;
	}

//Single Product Start
	function productStart(){
		$singleStart = <<<SINGLESTART
		<!doctype html>
		<html lang="en">
		<head>
			<meta charset="UTF-8" />
			<title>Assignment A</title>
			<link rel="stylesheet" type="text/css" href="cd.css">
		</head>
		<body>
SINGLESTART;
		$singleStart .="\n";
		return $singleStart;
	}

//Single Product End
	function productEnd(){
		return "<script src=\"cd.js\"></script>\n";
		return "</div>\n</body>\n</html>";
	}

/************************************************************************************************/

//SEARCH RESULTS PAGE
	function searchStart(){
		$searchStart = <<<SEARCHSTART
		<div class="mainCont">
			<div class="cdContSearch">
SEARCHSTART;
		$searchStart .="\n";
		return $searchStart;
	}

/************************************************************************************************/

//CREDITS PAGE
	//pagestart
	function referenceStart(){
		$referenceStart = <<<REFERENCESTART
		<div class="mainCont">
			<h1>References</h1>
REFERENCESTART;
		$referenceStart .= "\n";
		return $referenceStart;
	}

	//With Individual Authors
	function referenceA($source, $surname, $initial, $year, $webtitle, $url, $date){
		$referenceA = <<<REFERENCEA
		<div class="sources">
			<h3>$source</h3>
			<p>$surname, $initial. ($year)</p>
			<p><span>$webtitle.</span>
				 Available At: <a href="$url">$url</a>
				 (Accessed: $date).</p>
		</div>
REFERENCEA;
		$referenceA .= "\n";
		return $referenceA;

	}

	//With Organization Authors
	function referenceB($source, $organization, $year, $webtitle, $url, $date){
		$referenceB = <<<REFERENCEB
		<div class="sources">
			<h3>$source</h3>
			<p>$organization ($year)</p>
			<p><span>$webtitle.</span> 
				 Available At: <a href="$url">$url</a>
				 (Accessed: $date)
			</p>
		</div>
REFERENCEB;
		$referenceB .= "\n";
		return $referenceB;

	}

	//Myself
	function referenceME(){
		$referenceME = <<<REFERENCEME
		<div class="sources">
			<h2>Images through pure HTML or by myself:</h2>
				<p>Music Note (product cover).</p>
				<p>Logo (use of a rectangle, triangle, and adobe illustrator.</p>
		</div>
REFERENCEME;
		$referenceME .="\n";
		return $referenceME;
	}

	//Page End
	function referenceEnd(){
		$referenceEnd = <<<REFERENCEEND
		</div>
REFERENCEEND;
		$referenceEnd .= "\n";
		return $referenceEnd;
	}

?>