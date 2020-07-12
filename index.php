<?php

include 'global/config.php';
include 'global/conexion.php';
include 'cart.php';
include 'templates/_header.php';
?>

        <br>
        <!-- message alert success-->
        <?php if ($message != "") { ?>
        <div class="alert alert-success" role="alert">
            <?= $message; ?>
            <a href="#" class="badge badge-success"> Ver carrito </a>
        </div>
        <?php } ?>

        <div class="row">

            <!-- consult products -->
            <?php
            $sentence = $pdo->prepare("SELECT * FROM `create_products_table`");
            $sentence->execute();
            $productsList = $sentence->fetchAll(PDO::FETCH_ASSOC);
            //print_r($productsList); 
            ?>

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
                        src="<?= $product['image']; ?>"
                        height="317px">       
                         
                        <!-- prouct-description-->
                        <div class="card-body">
                            <span class="lead"> <?= $product['name']; ?> </span>
                            <h5 class="card-title"> <?= $product['price']; ?> </h5>
                            <p class="card-text"> $<?= $product['description']; ?> </p>

                            <form action="" method="post">
                                    
                                <input type="hidden" name="id" id="id" value="<?= openssl_encrypt($product['id'],code,key); ?>"></input>
                                <input type="hidden" name="name" id="name" value="<?= openssl_encrypt($product['name'],code,key); ?>"></input>
                                <input type="hidden" name="price" id="price" value="<?= openssl_encrypt($product['price'],code,key); ?>"></input>
                                <input type="hidden" name="quantity" id="quantity" value="<?= openssl_encrypt(1,code,key); ?>"></input>

                                <button class="btn btn-primary" 
                                name="btnAction" 
                                value="add" 
                                type="submit">Agregar al carro</button>

                            </form>
                        </div>
                    </div>
                </div>
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

<?php include 'templates/_footer.php'; ?>