<?php
    $nav = array(
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
    );

    /*$this->twig = new \Twig_Environment(null, array_merge([
        'cache' => Yii::getAlias($this->cachePath),
        'charset' => Yii::$app->charset,
    ], $this->options));
    $this->twig->addGlobal('this', 'loool');
    $this->loader = new \Twig_Loader_Filesystem('@frontend/views/templates/');
    $this->template = $this->twig->loadTemplate('topbar.twig');
    Twig_Autoloader::register();

    $this->twig->render('shit', [
        'nav' => $nav
    ]);*/
    $twig = new \Twig_Environment();
    $twig->loader('@frontend/views/templates/');
    $twig->render('topbar.twig', ['username' => 'Alex']);
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