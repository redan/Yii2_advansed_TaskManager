<?php use frontend\tests\FunctionalTester;
$I = new FunctionalTester($scenario);
$I->wantTo('Check that MainPage,About and Tasks are work');
$I->amOnPage('/');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->see('Congratulations!');
$I->click('About');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->see('This is the About page.');
