<?php 
    session_start();
    require "buscar-produtos.php";
    require "operacoes-carrinho.php";

    $pdoConnection = require "src/conexao-bd-cc.php";

    $resultsCarts = getContentCart($pdoConnection);
    $totalCarts  = getTotalCart($pdoConnection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Produtos no Carrinho</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                <h4 class="card-title">Produtos no Carrinho</h4>
            </div>
        </div>

        <?php if($resultsCarts) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($resultsCarts as $result) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['name']) ?></td>
                            <td><?php echo htmlspecialchars($result['quantity']) ?></td>
                            <td>R$<?php echo number_format($result['price'], 2, ',', '.') ?></td>
                            <td>R$<?php echo number_format($result['subtotal'], 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-right"><b>Total:</b></td>
                        <td>R$<?php echo number_format($totalCarts, 2, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-warning" role="alert">
                O carrinho está vazio.
            </div>
        <?php endif; ?>
        
    </div>
</body>
</html>
