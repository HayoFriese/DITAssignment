<?php
	ini_set("session.save_path", "/home/unn_w13020720/sessionData");
	session_start(); 
	include 'data_conn.php';
	require_once('functions.php');
	
	echo htmlSet();
	if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
		echo navLogOut("{$_SESSION['username']}");
	}
	else{
		echo navLogIn();
	}
			echo referenceStart();
				echo referenceB("Landing Image:",
										"Hutharts Law", 
										"2015", 
										"Contact Us", 
										"http://www.hutharts.com/contact-us", 
										"December 5th, 2015");
				
				echo referenceA("Adele Cover:",
										"Carpico", 
										"M", 
										"2015", 
										"Album Review: Adele, '25'", 
										"http://pop-break.com/2015/11/23/album-review-adele-25/", 
										"December 11, 2015");
				
				echo referenceB("Zico Cover:",
								"KPOP Mart", 
								"2015", 
								"Block B: Zico Mini Album Vol.1 - Gallery", 
								"http://kpopmart.com/product.php?id_product=9306", 
								"December 11, 2015");
				
				echo referenceA("Justin Bieber Cover:",
									"Frydenlund", 
									"Z", 
									"2015",
									"Justin Bieber's 'Purpose' Album Will Feature Nas, Ariana Grande, Travi&#36; Scott, Mike Dean, &amp; More", 
									"http://uk.complex.com/music/2015/10/justin-bieber-purpose-album-will-feature-nas-ariana-grande-travis-scott-mike-dean", 
									"December 11th, 2015");
				
				echo referenceB("Elvis Presley Cover:",
									"Classic Pop Icons",
									"2011",
									"If I Can Dream: Elvis Presley with the Royal Philarmonic Orchestra",
									"http://www.classicpopicons.com/if-i-can-dream-elvis-presley-with-the-royal-philharmonic-orchestra/",
									"December 11th, 2015");
				
				echo referenceB("Miles Davis Cover:",
									"Somehow Jazz",
									"no date",
									"In a Silent Way - Miles Davis (Favorite Albums)",
									"http://www.somehowjazz.com/in-a-silent-way.html",
									"December 11th, 2015");
				
				echo referenceB("Ariana Grande Cover:",
									"Rap-Up",
									"2015",
									"Ariana Grande Unveils 'Focus' Cover Art",
									"http://www.rap-up.com/2015/10/14/ariana-grande-focus-cover-art/",
									"December 11th, 2015");
				
				echo referenceA("Wiz Khalifa Cover:",
									"S.",
									"N",
									"2012",
									"Wiz Khalifa It's Nothin",
									"http://www.djbooth.net/index/tracks/review/wiz-khalifa-its-nothin",
									"December 11th, 2015");
				
				echo referenceB("Bob Marley Cover:",
									"EIL.com",
									"2015",
									"BOB MARLEY AND THE WAILERS",
									"http://eil.com/shop/moreinfo.asp?catalogid=411809",
									"December 11th, 2015");
				
				echo referenceB("General PHP Referencing:",
										"Php.net",
										"2015",
										"PHP Manual",
										"http://php.net/manual/en",
										"November-December, 2015");

				echo referenceME();	

			echo referenceEnd();
		echo footer();
	echo htmlEnd();
?>