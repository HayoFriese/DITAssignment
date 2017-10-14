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
?>

<div id="wrapper">
	<h1>Buy CDs</h1>

	<form id="orderForm" action="javascript:alert('form submitted');" onChange="calculate_total(this.id, 'selectCD', 'collection'); orderEnable();" method="get">
		<section id="selectCD">
			<h2>Select CDs</h2>
<?php
include_once('data_conn.php');
$sqlCDs = 'SELECT CDID, CDTitle, CDYear, catDesc, CDPrice FROM nmc_cd b inner join nmc_category c on b.catID = c.catID WHERE 1 order by CDTitle';
$rsCDs = mysqli_query($conn, $sqlCDs);
while ($CD = mysqli_fetch_assoc($rsCDs)) {
    echo "\t<div class='item'>
            <span class='CDTitle'>{$CD['CDTitle']}</span>
            <span class='CDYear'>{$CD['CDYear']}</span>
            <span class='catDesc'>{$CD['catDesc']}</span>
            <span class='CDPrice'>{$CD['CDPrice']}</span>
            <span class='chosen'><input type='checkbox' name='CD[]' value='{$CD['CDID']}' title='{$CD['CDPrice']}' /></span>
        </div>\n";
}
?>
		</section>

		<section id="collection">
			<h2>Collection method</h2>
			<p>Please select whether you want your chosen CD(s) to be delivered to your home address (a charge applies for this) or whether you want to collect them yourself.</p>
			<p>
			Home address - &pound;4.99 <input type="radio" name="deliveryType" value="home" title="4.99" checked />&nbsp; | &nbsp;
			Collect from warehouse - no charge <input type="radio" name="deliveryType" value="trade" title="0" />
			</p>
		</section>

		<section id="checkCost">
			<h2>Total cost</h2>
			Total <input type="text" name="total" size="10" readonly />
		</section>

		<section id="placeOrder" >
			<h2>Place order</h2>
			Your details
			Customer Type: <select name="customerType" onChange="test('placeOrder');">
				<option value="">Customer Type?</option>
				<option value="ret">Customer</option>
				<option value="trd">Trade</option>
			</select>

			<div id="retCustDetails" class="custDetails">
				Forename <input type="text" name="forename" />
				Surname <input type="text" name="surname" />
			</div>
			<div id="tradeCustDetails" class="custDetails" style="visibility:hidden">
				Company Name <input type="text" name="companyName" />
			</div>
			<p style="color: #FF0000; font-weight: bold;">I have read and agree to the terms and conditions
			<input type="checkbox" id="termsChkbx" onclick="terms(this);" /></p>

			<p><input type="submit" name="submit" value="Order now!" disabled /></p>
		</section>
	</form>
</div>
</div>
<script src="cd.js"></script>
</body>
</html>