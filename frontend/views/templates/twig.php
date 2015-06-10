<?php
$nav = [
    'primary' => array(
        array('name' => 'Clothes', 'url' => '/clothes'),
        array('name' => 'Shoes and Accessories', 'url' => '/accessories'),
        array('name' => 'Toys and Gadgets', 'url' => '/toys'),
        array('name' => 'Books and Movies', 'url' => '/media'),
    ),
    'secondary' => array(
        array('name' => 'By Price', 'url' => '/selector/v328ebs'),
        array('name' => 'By Brand', 'url' => '/selector/gf843k2b'),
        array('name' => 'By Interest', 'url' => '/selector/t31h393'),
        array('name' => 'By Recommendation', 'url' => '/selector/gf942hb')
    )
];

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(__DIR__);
$twig = new Twig_Environment($loader);
$template = $twig->loadTemplate('index.twig');
echo $template->render([
    'nav' => $nav,
]);

/*$twig = new \Twig_Environment();
    $loader = new Twig_Loader_Filesystem('@web');
    $twig->render('topbar.twig', ['username' => 'Alex']);*/
/*try {
    $loader = new Twig_Loader_Filesystem('templates');

    $twig = new Twig_Environment($loader);

    $template = $twig->loadTemplate('shop.tmpl');

    echo $template->render(array (
        'nav' => $nav,
        'updated' => '24 Jan 2011'
    ));

} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}*/