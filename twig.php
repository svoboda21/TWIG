<?php
    require_once 'vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem('./template');
    $twig = new Twig_Environment($loader, array(
        'cache'       => './tmp/cashe',
        'auto_reload' => true
     ));
    $ar1=array(
        'kost'=>array(
            'key1'=>array(
                    'hhh'=>"value1",
                    'hhp'=>"value2"
            ),
            'key2'=>array(
                    'hhh'=>"value3",
                    'hhp'=>"value4"
            ),
        ),
        'name'=>'dmitry'
    );
    echo "<pre>";
    print_r($ar1);
    echo $twig->render('formstwig.php',$ar1);
?>