<?php
include 'global/config.php';
include 'global/conexion.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1>Hello, world!</h1>
    <!-- nav-bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="index.php">Logo empresa</a>
        <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="my-nav" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php"> Home <span class="sr-only"> (Current) </span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#"> Carrito (0) <span class="sr-only"> (Current) </span></a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- nav-bar -->
    <br><br>

    <!-- container-alert-->
    <div class="container">
        <br>
        <!-- alert-success-->
        <div class="alert alert-success" role="alert">
            Pantalla de mensaje . . .
            <a href="#" class="badge badge-success"> Ver carrito </a>
        </div>
        <!-- alert-success-->

        <div class="row">

            <!-- consult products -->
            <?php
            $sentence = $pdo->prepare("SELECT * FROM `create_products_table`");
            $sentence->execute();
            $productsList = $sentence->fetchAll(PDO::FETCH_ASSOC);
            //print_r($productsList); 
            ?>
            <!-- close consult products -->

            <!-- open-foreach -->
            <?php foreach ($productsList as $product) { ?>

                <!-- card-container -->
                <div class="col-3">
                    <div class="card">
                        <!-- image -->
                        <img class="card-img-top"
                        data-toggle="popover"
                        data-content="<?= $product['description']; ?>"
                        data-trigger="hover" 
                        title=" <?= $product['name']; ?> " 
                        alt=" <?= $product['name']; ?>" 
                        src="<?= $product['image']; ?>">
                        <!-- image -->        
                         
                        <!-- prouct-description-->
                        <div class="card-body">
                            <span class="lead"> <?= $product['name']; ?> </span>
                            <h5 class="card-title"> <?= $product['price']; ?> </h5>
                            <p class="card-text"> $<?= $product['description']; ?> </p>

                            <form action="" type="post">
                                    
                                <input type="text" name="id" id="id" value="<?= openssl_encrypt($product['id'],code,key); ?>"></input>
                                <input type="text" name="name" id="name" value="<?= openssl_encrypt($product['name'],code,key); ?>"></input>
                                <input type="text" name="price" id="price" value="<?= openssl_encrypt($product['price'],code,key); ?>"></input>
                                <input type="text" name="quantity" id="quantity" value="<?= openssl_encrypt(1,code,key); ?>"></input>

                            </form>

                            <button class="btn btn-primary" 
                                name="btnAction" 
                                value="agregar" 
                                type="submit">Agregar al carro</button>
                            </div>
                            <!-- product-description-->
                    </div>
                </div>
                <!-- card-container -->
            <?php } ?>
            <!-- close-foreach -->
        </div>
    </div>
    <!-- container-alert -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $('[data-toggle="popover"]').popover()
        })
    </script>
</body>

</html>