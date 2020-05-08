<?php 

// Include configuration file   
require_once 'config.php'; 

		
		// Product Details 
// Minimum amount is $0.50 US 

$itemName = "Hosting/Domain/Business Email"; 
$itemNumber = $transId; 
$itemPrice = $sellingCurrencyAmount; 
$currency = "USD";

 
?>

<!DOCTYPE html>
<html lang="en-US">
<head>

<title>Stripe Chechout</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="asset/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="asset/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="asset/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="asset/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="asset/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="asset/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="asset/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="asset/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="asset/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="asset/css/util.css">
	<link rel="stylesheet" type="text/css" href="asset/css/main.css">
<!--===============================================================================================-->

<!-- Stripe JavaScript library -->
<!-- Stripe JavaScript library -->
<script src="https://js.stripe.com/v2/"></script>

<script src="js/jquery-3.3.1.min.js"></script>

<!-- jQuery is used only for this example; it isn't required to use Stripe -->
<!-- jQuery is used only for this example; it isn't required to use Stripe -->
<!---<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> ---->


</head>
<!-- MAIN BODY-->
<body>

<div <div class="limiter">
		<div class="container-login100" style="background-image: url('asset/images/bg-01.jpg');">

    <div class="wrap-login100">
	<!-- Payment form -->
	<form class="login100-form validate-form" action="charge.php" method="POST" id="paymentFrm">
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						<h4>Charge with Stripe</h4>
						  <!-- Product Info -->
        <p><b></b></p>
        <p><b></b></p>
	
        <!-- Display errors returned by createToken -->
        <div class="payment-status"></div>
					</span>
        
		
					<div class="wrap-input100 validate-input" data-validate = "">
								<label>Product name</label>
						<input class="input100" name="item" id="item" placeholder="Enter item name" required="" autofocus="">
						<span class="focus-input100" data-placeholder=""></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "">
								<label>Price</label>
						<input class="input100" name="amount" id="amount" placeholder="Enter amount" required="" autofocus="">
						<span class="focus-input100" data-placeholder=""></span>
					</div>
	  
	  <div class="wrap-input100 validate-input" data-validate = "">
								<label>Name on Card</label>
						<input class="input100" name="name" id="name" placeholder="Enter name" required="" autofocus="">
						<span class="focus-input100" data-placeholder=""></span>
					</div>
    
     <div class="wrap-input100 validate-input" data-validate = "">
								<label>Email</label>
						<input class="input100" type="email"  name="email" id="email" value="<?php echo $email;?>">
						<span class="focus-input100" data-placeholder=""></span>
					</div>
		<div class="wrap-input100 validate-input" data-validate = "">
								<label>Address</label>
						<input class="input100" type="text"  name="address_line1" id="address_line1" placeholder="1234 Main St" required="">
						<span class="focus-input100" data-placeholder=""></span>
					</div>
     
	 <div class="wrap-input100 validate-input" data-validate = "">
								<label>City</label>
						<input class="input100" type="text" name="address_city" id="address_city" placeholder="Tamale" required="">
						<span class="focus-input100" data-placeholder=""></span>
					</div>
	 
	 <div class="wrap-input100 validate-input" data-validate = "">
								<label>Country</label>
						<input class="input100" type="text" name="address_country" id="address_country" placeholder="Ghana" required="">
						<span class="focus-input100" data-placeholder=""></span>
					</div>

        <div class="wrap-input100 validate-input" data-validate = "">
								<label>Card Number</label>
		<input class="input100" type="text" name="card_number" id="card_number" placeholder="1234 1234 1234 1234" autocomplete="off" required="">
						<span class="focus-input100" data-placeholder=""></span>
					</div>
			
			<div class="wrap-input100 validate-input" data-validate = "">
								<label>Expiry Date</label>
		<input class="input100" type="text" name="card_exp_month" id="card_exp_month" placeholder="MM" required="">
						<span class="focus-input100" data-placeholder=""></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "">
								<label></label>
		<input class="input100" type="text" name="card_exp_year" id="card_exp_year" placeholder="YYYY" required="">
						<span class="focus-input100" data-placeholder=""></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "">
								<label>CVC Code</label>
		<input class="input100" type="text" name="card_cvc" id="card_cvc" placeholder="CVC" autocomplete="off" required="">
						<span class="focus-input100" data-placeholder=""></span>
					</div>
            
            
			<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" id="payBtn">
							Submit Payment
						</button>
					</div>
			
			
            
        </form>
	</div>
 </div>
</div>





<!--script to generate token-->
<script>
// Set your publishable key
Stripe.setPublishableKey('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

// Callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    if (response.error) {
        // Enable the submit button
        $('#payBtn').removeAttr("disabled");
        // Display the errors on the form
        $(".payment-status").html('<p>'+response.error.message+'</p>');
    } else {
        var form$ = $("#paymentFrm");
        // Get token id
        var token = response.id;
        // Insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // Submit form to the server
        form$.get(0).submit();
    }
}

$(document).ready(function() {
    // On form submit
    $("#paymentFrm").submit(function() {
        // Disable the submit button to prevent repeated clicks
        $('#payBtn').attr("disabled", "disabled");
		
        // Create single-use token to charge the user
        Stripe.createToken({
			address_line1: $('#address_line1').val(),
			address_city: $('#address_city').val(),
			address_country: $('#address_country').val(),
            number: $('#card_number').val(),
            exp_month: $('#card_exp_month').val(),
            exp_year: $('#card_exp_year').val(),
            cvc: $('#card_cvc').val()
        }, stripeResponseHandler);
		
        // Submit from callback
        return false;
    });
});
</script>

<!--===============================================================================================-->
	<script src="asset/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="asset/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="asset/vendor/bootstrap/js/popper.js"></script>
	<script src="asset/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="asset/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="asset/vendor/daterangepicker/moment.min.js"></script>
	<script src="asset/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="asset/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="asset/js/main.js"></script>

</body>
</html>


