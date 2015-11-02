<?php use tests\codeception\frontend\AcceptanceTester;
$I = new AcceptanceTester($scenario);
$I->wantTo('log in as regular user');
$I->amOnPage('/signup');
$I->fillField(['name' => 'username'], 'admiralexo@gmail.com');
$I->fillField(['name' => 'email'], 'admiralexo@gmail.com');
$I->fillField(['name' => 'password'], 'admiralexo@gmail.com');
$I->click('Зарегистрироваться');