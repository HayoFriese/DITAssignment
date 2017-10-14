function back() {
    window.history.back();
}
//getRequest function provided by the wheel.
	function getRequest(url, callbackFunction) {
		'use strict';
		var httpRequest;
		if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		  httpRequest = new XMLHttpRequest();
		}
		else if (window.ActiveXObject) { // IE
		  try {
		      httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
		  }
		  catch (e) {
		      try {
		          httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
		      }
		      catch (e) {}
		  }
		}
		if (!httpRequest) {
		  alert('Giving up :( Cannot create an XMLHTTP instance');
		  return false;
		}
		httpRequest.onreadystatechange = function() {
		   var completed = 4, successful = 200;
		   if (httpRequest.readyState == completed) {
		       if (httpRequest.status == successful) {
		           callbackFunction(httpRequest.responseText);
		       } else {
		           alert('There was a problem with the request.');
		       }
		   }
		};
		 
		httpRequest.open('get', url, true);
		httpRequest.send(null);
	}


//JSON OFFERS
	$(document).ready(function () {
   		'use strict';
   		//initialize with full-fat ajax
	   	$.ajax({ 
	   		//set datatype as JSON, method as GET ($_GET), and the source code for retrieving JSON material as getOffers.php?useJSON (taking the ?useJSON function)
           	dataType: "json",
           	method: "get",
           	url: "getOffers.php?useJSON"}
		)
		//on success, process the data
		.done(function (data, status, jqxhr) {
			//create variable that appends a <ul> tag to the id #JSONoffers element in the document.
			var JSONoffers = $('#JSONoffers').append('<ul/>');
			//display the result in the console log, success/fail, and a test result, this case being CDTITLE for debugging.
			window.console && console.log(status +'\n'+data.CDTitle);
			//append results in LI tags under the newly created UL tags
            $(JSONoffers).find('ul').append("<li>"+data.CDTitle+ "</li>"
               								+"<li>"+data.catDesc+"</li>"
               								+"<li>"+data.CDPrice+"</li>");
		})
		//on fail, return the status of the query, and die the error message in the console.
   		.fail(function(jqxhr, textStatus, errorThrown) {
    	    window.console && console.log(textStatus +': '+errorThrown);
    	    }
    	);
	});

//HTML offer
	//call the onload event handler, which forces the action of a function with a return value.
	window.onload = function() {
		updateTarget();
	};
	//defines the updateTarget in an object oriented format, utilizing the getRequest function provided by the wheel at the top of the page, with arguments url, function, and a return value
	var updateTarget = function() {
		'use strict';
 		getRequest('getOffers.php', update, false);
 		//iterate every 5s
 		setTimeout(updateTarget, 5000);
	};
 	//use an external function to echo the result of the above function, echoing the results in the element of id offers in the document.
	function update(result) {
  		'use strict';
   		document.getElementById('offers').innerHTML = result;
	};


//Autocomplete
	$(document).ready( function () {
    	'use strict';
    	//initialize the autocomplete to correspond to the text input of id keywords, with code coming from autocomplete.php, and the minimum length of 3
    	$('#keywords').autocomplete({
        	source: 'autocomplete.php',
        	minLength:3,
        	//on selecting an option, open a text field under text input of id keywords with all return values, each on a new line.
        	select: function(event, ui) {
        		event.preventDefault();
        		//echo in the console log for debugging.
        	    console.log(ui);
        	    $('#keywords').val(ui.item.label + "\n"); 
        	},
        	//on focus do the same as above (no debugging, and echoing the sole focused line)
        	focus: function(event, ui){
        		event.preventDefault();
        		$('#keywords').val(ui.item.label);
        	}
    	});
	});

//order form
	function calculate_total(formid, id, orderid) {
	    'use strict';
		// code here
		//variables
			//Splitting the sections off, to avoid interference from other input types.
			var form = document.getElementById(formid);
			var totalID = document.getElementById(id);
			var orderTax = document.getElementById(orderid);

			//Alternative solution could be to call input[type=radio/checkbox], and do 2 for loops for them.
			//This method allows for change to the sections. 
			var inputButtons = totalID.getElementsByTagName('input');
			var inputRadio = orderTax.getElementsByTagName('input');

			var total = document.getElementsByName("total");
			var finalSum = 0;
			var delivery = 0;
			var sum = 0;
		//if checked, then add value to sum
			for (var i=0; inputButtons[i]; i++){
				if (inputButtons[i].type == 'checkbox'){
					if (inputButtons[i].checked){
						sum += parseFloat(inputButtons[i].title);
					}
				}
			}
		//if radio checked, add value to delivery
			for (var c=0; inputRadio[c]; c++){
				if (inputRadio[c].type == 'radio'){
					if (inputRadio[c].checked){
						delivery += parseFloat(inputRadio[c].title);
					}
				}
			}
		//if no cd selected, form value = 0, else it equals sum of CDs and delivery method
			if(sum == 0 && delivery !=0){
				form.total.value = finalSum.toFixed(2);
			} else{
				finalSum = parseFloat((sum+delivery).toFixed(2));
				form.total.value = finalSum.toFixed(2);
			}
	}

	function terms(id){
		//define the variables
		var termBox = document.getElementById("termsChkbx");
		var placeOrder = document.getElementById("placeOrder");
		var termText = placeOrder.getElementsByTagName("p");

		//termText is referred as the first element of the array as the first P tag in the section corresponds to the checkbox text, and the second to the submit button, ergo only the 
		//first element from the return array is called. Could loop through the function for more reusability, but suffers the same risk: not corressponding to the checkbox text if
		//new P tag appears before. If it's checked, change style, else, change it to another style. 
			if(termBox.checked){
				termText[0].style.color = "black";
				termText[0].style.fontWeight = "normal";
			} else {
				termText[0].style.color = "#FF0000";
				termText[0].style.fontWeight = "bold";
			}
	}

	function test(idcust){
		var order = document.getElementById(idcust);
		var s = order.getElementsByTagName('select');
		var formCust = document.getElementById('retCustDetails');
		var formTrade = document.getElementById('tradeCustDetails');
		
		//loop through all select tags, and identify the values. if value is "ret" make the customer form visible, and the company form hidden. else if the value is "trd", invert it.
		for (var i=0; i < s.length; i++){
			var customer = s[i].value;
			if(customer == "ret"){
				formCust.style.visibility = "visible";
				formTrade.style.visibility = "hidden";
			}
			else if(customer == "trd"){
				formCust.style.visibility = "hidden";
				formTrade.style.visibility = "visible";
			}
		}
	}

	function orderEnable(){
		//Get variables for total price, customer/trade form, and terms and conditions.
		var totalPrice = document.getElementsByName("total");

		var forename = document.getElementsByName("forename");
		var surname = document.getElementsByName("surname"); 
		var company = document.getElementsByName("companyName");
		
		var termsCheck = document.getElementById("termsChkbx");

		var submit = document.getElementsByName("submit");
			//check if totalPrice, forename, surname, company all have values, and if terms is checked
				if(totalPrice[0].value != "0.00" && ((forename[0].value != "" && surname[0].value != "") || company[0].value != "" ) && termsCheck.checked){
				//make the button enabled.
					submit[0].disabled = false;
				}else{
					submit[0].disabled = true;
				}
			}