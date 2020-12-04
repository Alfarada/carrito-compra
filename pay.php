<?php

include 'global/config.php';
include 'global/conexion.php';
include 'cart.php';
include 'templates/_header.php';
?>

<?php

if ($_POST) {

    $total = 0;
    $sessionId = session_id();
    $email = $_POST['email'];

    foreach ($_SESSION['cart'] as $index => $product) {
        $total = $total + ($product['price'] * $product['quantity']);
    }

    $sentence = $pdo->prepare(
        "INSERT 
        INTO `create_sales_table` (`id`, `transaction_key`, `paypal_data`, `date`, `mail`, `total`, `status`)
        VALUES (NULL, :transaction_key, '', NOW() , :email, :total, 'pendiente');"
    );

    $sentence->bindParam(":transaction_key", $sessionId);
    $sentence->bindParam(":email", $email);
    $sentence->bindParam(":total", $total);
    $sentence->execute();
    $saleId = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $index => $product) {

        $sentence = $pdo->prepare(
            "INSERT
        INTO `create_sale_detail_table` (`id`, `sale_id`, `product_id`, `price`, `quantity`, `download`)
        VALUES (NULL, :sale_id, :product_id, :price, :quantity , '0')"
        );

        $sentence->bindParam(":sale_id", $saleId);
        $sentence->bindParam(":product_id", $product['id']);
        $sentence->bindParam(":price", $product['price']);
        $sentence->bindParam(":quantity", $product['quantity']);
        $sentence->execute();

        //print_r($sentence);
    }

    //echo "<h3>".$total."</h3>";
}
?>

<!-- Including PayPal JavaScript SDK -->
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<style>
   
    /* Media query for mobile viewport */
    @media screen and (max-width: 400px) {
        #paypal-button-container {
           width: 100%;
        }
    }
   
    /* Media query for desktop viewport */
    @media screen and (min-width: 400px) {
        #paypal-button-container {
           width: 250px;
            display: inline-block;
        }
    }
   
</style> 

<div class="jumbotron text-center">
    <h1 class="display-4"> ! Paso final ¡</h1>
    <hr class="my-4">
    <p class="lead"> Estas a punto de pagar con paypal la cantidad de:
        <h4> $ <?= number_format($total, 2); ?> </h4>
        <!-- Setting a container element for the button -->
        <div id="paypal-button-container"></div>
    </p>
    <p>Los productos podrán ser descargados una vez que se procese el pago
        <br><strong>( Para aclaraciones : uhperezoscar@gmail.com)</strong>
    </p>
</div>

<script>

paypal.Button.render({

    env: 'sandbox', // sandbox | production
    style: {

        label: 'checkout',  // checkout | credit | pay | buynow | generic
        size:  'responsive', // small | medium | large | responsive
        shape: 'pill',   // pill | rect
        color: 'gold'   // gold | blue | silver | black

    },

    // PayPal Client IDs - replace with your own
    // Create a PayPal app: https://developer.paypal.com/developer/applications/create

    client: {
        sandbox:   'AXlAuQZdeYFxfSn4n5bDvvu6EGbeYAMQnT6XSd7v4C8CNzDa6PWIJOx56MiwatzyBjK5RVHekA-2WfaF',
        production: 'Ad4gISmI-MsvrEqt1j5BifFe-Tv8ZP7HKzGFVRPlXxp0uJn6LCnNVgzPpxt-dvcmU6KbS8efIkNnUMzL'
    },

    // Wait for the PayPal button to be clicked
    payment: function(data, actions) {
        return actions.payment.create({
            payment: {
                transactions: [
                    {
                        amount: { total: '<?=$total;?>', currency: 'USD' }, 
                        description:"Compra de productos a Develoteca:$<?= number_format($total,2) ?>",
                        custom:"<?= $sessionId; ?> # <?= openssl_encrypt($saleId,code,key); ?>"
                    }
                ]
            }
        });

    },

    // Wait for the payment to be authorized by the customer
    onAuthorize: function(data, actions) {
        return actions.payment.execute().then(function() {
            // window.alert("Pyment complete");
            console.log(data);
            window.location="checker.php?paymentToken="+data.paymentToken+"&paymentID="+data.paymentID;
        });
    }
}, '#paypal-button-container');

</script>

<?php include 'templates/_footer.php'; ?>