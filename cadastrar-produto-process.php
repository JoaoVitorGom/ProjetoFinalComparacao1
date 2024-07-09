<?php

    require "src/conexao-bd.php";
    require "src/Modelo/Produto.php";
    require "src/Repositorio/ProdutoRepositorio.php";
    
    if (isset($_POST['cadastro'])){
        $produto = new Produto(null,
            $_POST['tipo'],
            $_POST['nome'],
            $_POST['descricao'],
            $_POST['preco']
        );

        if (isset($_FILES['imagem'])){
            $produto->setImagem(uniqid() . $_FILES['imagem']['name']);
            move_uploaded_file($_FILES['imagem']['tmp_name'], $produto->getImagemDiretorio());
        }

        $produtoRepositorio = new ProdutoRepositorio($pdo);
        $produtoRepositorio->salvar($produto);

        header("Location: admin.php");

    }



