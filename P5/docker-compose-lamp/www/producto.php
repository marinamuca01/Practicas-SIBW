<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");
    session_start();

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    if(isset($_GET['prod'])){
        $codProd = $_GET['prod'];
    } else {
        $codProd = -1;
    }

    $msqli = dbConnect();
    $infoProduct = getProducto($msqli, $codProd);
    $imagenes = getImagenesProducto($msqli, $codProd);
    $comments = getCommentsFromProduct($msqli, $codProd);
    $tags = getTagsFromProduct($msqli, $codProd);

    if(isset($_SESSION['username']))
        $user = getUser($msqli, 'username', $_SESSION['username']);

    if(isset($_GET['print'])){
        echo $twig->render('producto_imprimir.html', ['producto' => $infoProduct, 'imagenes' => $imagenes, 'user' => $user]);
    }
    else{
        echo $twig->render('producto.html', ['producto' => $infoProduct, 'imagenes' => $imagenes, 'comments' =>  $comments, 'tags' =>  $tags, 'user' => $user]);
    }

?>