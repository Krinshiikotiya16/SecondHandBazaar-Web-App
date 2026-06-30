<?php
session_start();

require_once '../../razorpay-php-master/Razorpay.php';


use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$key_id = "rzp_live_T0E03YO2u78Pfu";
$key_secret = "IxFXhxbSWSxuk11XiV1eBUoX";

$payment_id = $_POST['payment_id'] ?? '';
$order_id   = $_POST['order_id'] ?? '';
$signature  = $_POST['signature'] ?? '';
$xicode     = $_POST['I_CODE'] ?? '';

$success = true;

try
{
    $api = new Api($key_id,$key_secret);

    $attributes = [
        'razorpay_order_id'   => $order_id,
        'razorpay_payment_id' => $payment_id,
        'razorpay_signature'  => $signature
    ];

    $api->utility->verifyPaymentSignature($attributes);
}
catch(SignatureVerificationError $e)
{
    $success = false;
}

if($success)
{
?>
<form id="frm" action="orders.php" method="post">

    <input type="hidden" name="payment_id"
    value="<?php echo $payment_id; ?>">

    <input type="hidden" name="cart_payment"
    value="1">

</form>

<script>
document.getElementById("frm").submit();
</script>

<?php
}
else
{
    echo "<script>
    alert('Payment Verification Failed');
    window.location='cart.php';
    </script>";
}
?>