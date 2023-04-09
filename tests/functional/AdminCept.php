<?php
if (file_exists(storage_path() . '/logs/cron_test.log')) {
    unlink(storage_path() . '/logs/cron_test.log');
}
$I = new FunctionalTester($scenario);
$I->wantTo('Check that original database doesnt contain testresponse');
$I->useDatabase('TestShopping');
$I->dontSeeInCollection('Penny_General', ['Total' => 2]);
$count = $I->grabCollectionCount('Penny_Products');
$I->expect($count != 2);

$I->wantTo('See the page without logfile loaded');
$I->amOnPage('/admin');
$I->see('Cron Runner Logs');
$I->see('Penny Manuális Feltöltés');
$I->see('Tesco Manuális Feltöltés');
$I->see('Nincs logfile!');
$I->dontSee('error');
$I->dontSee('warning');
$I->dontSee('notice');

$I->wantTo('Check modal buttons');
$I->click('#PennyModalButton');
$I->click('#PennyModalDismissButton');
$I->see('Nincs logfile!');
$I->dontSee('OOps something went wrong');
$I->click('#PennyModalButton');
$I->click('#PennyModalCloseButton');
$I->see('Nincs logfile!');
$I->dontSee('OOps something went wrong');
$I->click('#PennyModalAgreeButton');
$I->dontSee('OOps something went wrong');
$I->see('Penny Database Updated Succesfully!');

$I->wantTo('Check that original database contain testresponse');
$I->useDatabase('TestShopping');
$I->seeInCollection('Penny_General', ['Total' => 2]);
$count = $I->grabCollectionCount('Penny_Products');

$I->expect($count == 2);

$I->wantTo('Check modal buttons');
$I->click('#TescoModalButton');
$I->click('#TescoModalDismissButton');
$I->dontSee('OOps something went wrong');
$I->click('#TescoModalButton');
$I->click('#TescoModalCloseButton');
$I->dontSee('OOps something went wrong');
$I->click('#TescoModalAgreeButton');
$I->dontSee('OOps something went wrong');
$I->see('Tesco Database Updated Succesfully!');

if (file_exists(storage_path() . '/logs/cron_test.log')) {
    unlink(storage_path() . '/logs/cron_test.log');
}
