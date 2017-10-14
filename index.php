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
			echo homeStart();

				echo sectionTitle("Current Offers");
					echo offer("JSONoffers", "offers");

				echo sectionTitle("New Releases");
					echo release("adele.jpg", "25", "Adele", "Add to Basket");
					echo release("zico.jpg", "Gallery", "Zico", "Add to Basket");
					echo release("justin.jpg", "Purpose", "Justin Bieber", "Add to Basket");
					echo release("elvis.jpg", "If I Can Dream", "Elvis Presley", "Add to Basket");

				echo sectionTitle("Popular Genres");	
					echo genre("miles.jpg", "Jazz", "See More");
					echo genre("ariana.jpg", "Pop", "See More");
					echo genre("wiz.jpg", "Rap", "See More");
					echo genre("bob.jpg", "Reggae", "See More");
			echo homeEnd();
		echo footer();
	echo htmlEnd();
?>