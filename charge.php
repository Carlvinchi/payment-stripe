<?php 
// Include configuration file  
require_once 'config.php'; 

$payment_id = $statusMsg = ''; 
$ordStatus = 'error'; 
$currency = "USD";
// Check whether stripe token is not empty 
if(!empty($_POST['stripeToken'])){ 
     
    // Retrieve stripe token, card and user info from the submitted form data 
    $token  = $_POST['stripeToken']; 
    $name = $_POST['name']; 
    $itemName = $_POST['item'];
    $itemPrice = $_POST['amount'];
    $email = $_POST['email']; 
	$address_line1 = $_POST['address_line1']; 
	$address_city = $_POST['address_city']; 
	$address_country = $_POST['address_country']; 
    $card_number = $_POST['card_number']; 
    $card_exp_month = $_POST['card_exp_month']; 
    $card_exp_year = $_POST['card_exp_year']; 
    $card_cvc = $_POST['card_cvc']; 
     
    // Include Stripe PHP library 
    require_once 'stripe-php/init.php'; 
     
    // Set API key 
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
     
    // Add customer to stripe 
    $customer = \Stripe\Customer::create(array( 
        'email' => $email, 
        'source'  => $token 
    )); 
     
    // Unique order ID 
    $orderID = strtoupper(str_replace('.','',uniqid('', true))); 
     
    // Convert price to cents 
    $itemPrice =($itemPrice*100); 
     
    // Charge a credit or a debit card 
    $charge = \Stripe\Charge::create(array( 
        'customer' => $customer->id, 
        'amount'   => $itemPrice, 
        'currency' => $currency, 
        'description' => $itemName, 
        'metadata' => array( 
            'order_id' => $orderID 
        ) 
    )); 
     
    // Retrieve charge details 
    $chargeJson = $charge->jsonSerialize(); 
 
    // Check whether the charge is successful 
    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){ 
        // Order details  
        $transactionID = $chargeJson['balance_transaction']; 
        $paidAmount = $chargeJson['amount']; 
        $paidCurrency = $chargeJson['currency']; 
        $payment_status = $chargeJson['status']; 
         
		 $statusMsg = "Transaction was successful!";
      
         
    }else{ 
        //print '<pre>';print_r($chargeJson); 
        $statusMsg = "Transaction has been failed!"; 
    } 
}else{ 
    $statusMsg = "Error on form submission."; 
}

$amountPaid = $paidAmount/100 ;
			
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
</head>
<body>
<div class="container">
    <div class="status">
        <?php if($payment_status =="succeeded"){ ?>
            <h1 class="<?php  ?>"><?php echo $statusMsg; ?></h1>
			
            <h4>Payment Information</h4>
            
            <p><b>Transaction ID:</b> <?php echo $transactionID; ?></p>
            <p><b>Paid Amount:</b> <?php echo $amountPaid.' '.$paidCurrency; ?></p>
            <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>
			
            <h4>Product Information</h4>
            
            <p><b>Price:</b> <?php echo $amountPaid.' '.$currency; ?></p>
        <?php }else{ ?>
            <h1 class="error">Your Payment has Failed</h1>
			
			
			
			
        <?php } ?>
		
		
    </div>
    <center>	
            <a href="https://uvitechgh.com">Powered By UviTech Inc.</a>
</center>
</div>

</body>
</html>