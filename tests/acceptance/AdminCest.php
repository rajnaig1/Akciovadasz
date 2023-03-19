<?php

class AdminCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function adminGyokerLogTeszt(AcceptanceTester $I)
    {
        $I-> amOnUrl('http://127.0.0.1:8090/admin');
        $I->amGoingTo('Check basic homepage layout');
        $I->see('Cron Runner Logs');
        $I->see('Penny manuális feltöltés');
        $I->see('Tesco manuális feltöltés');
        $I->see('Oldalankénti találat');
        $I->see('Keresés');
        $I->see('Előző oldal');
        $I->see('1');
        $I->see('Következő oldal');

        $I->dontSee('A penny adatbázis manuális feltöltése');
        $I->dontSee('Biztosan felül akarja írni az adatbázis?');
        $I->dontSee('Igen');
        $I->dontSee('Nem');
        $I->amGoingTo('PennyModal:Check if pennymodal becomes visible, and it will be closed with buttons');
        $I->click('Penny manuális feltöltés');
        $I->waitForText('A penny adatbázis manuális feltöltése', 30); // secs
        $I->see('Biztosan felül akarja írni az adatbázis?');
        $I->see('Igen');
        $I->see('Nem');

        $I->click('Nem');
        $I->wait(1);
        $I->dontSee('A penny adatbázis manuális feltöltése');
        $I->dontSee('Biztosan felül akarja írni az adatbázis?');
        $I->dontSee('Igen');
        $I->dontSee('Nem');
        
        $I->click('Penny manuális feltöltés');
        $I->waitForText('A penny adatbázis manuális feltöltése', 30); // secs
        $I->see('Biztosan felül akarja írni az adatbázis?');
        $I->see('Igen');
        $I->see('Nem');

        $I->click('#PennyModalCloseButton');
        $I->wait(1);
        $I->dontSee('A penny adatbázis manuális feltöltése');
        $I->dontSee('Biztosan felül akarja írni az adatbázis?');
        $I->dontSee('Igen');
        $I->dontSee('Nem');

        $I->dontSee('A Tesco adatbázis manuális feltöltése');
        $I->dontSee('Biztosan felül akarja írni az adatbázis?');
        $I->dontSee('Igen');
        $I->dontSee('Nem');
        $I->amGoingTo('TescoModal:Check if tescomodal becomes visible, and it will be closed with buttons');
        $I->click('Tesco manuális feltöltés');
        $I->waitForText('A Tesco adatbázis manuális feltöltése', 30); // secs
        $I->see('Biztosan felül akarja írni az adatbázis?');
        $I->see('Igen');
        $I->see('Nem');

        $I->click('#TescoModalDismissButton');
        $I->wait(1);
        $I->dontSee('A Tesco adatbázis manuális feltöltése');
        $I->dontSee('Biztosan felül akarja írni az adatbázis?');
        $I->dontSee('Igen');
        $I->dontSee('Nem');
        
        $I->click('Tesco manuális feltöltés');
        $I->waitForText('A Tesco adatbázis manuális feltöltése', 30); // secs
        $I->see('Biztosan felül akarja írni az adatbázis?');
        $I->see('Igen');
        $I->see('Nem');

        $I->click('#TescoModalCloseButton');
        $I->wait(1);
        $I->dontSee('A Tesco adatbázis manuális feltöltése');
        $I->dontSee('Biztosan felül akarja írni az adatbázis?');
        $I->dontSee('Igen');
        $I->dontSee('Nem');
        $I->amGoingTo('Keresőmező:Ellenőrzés olyan inputra, ami biztos, hogy nincs, Successre és exceptionre');
        $I->see('Exception');
        $I->see('Success');
        $I->fillField('Keresés','Baromság');
        $I->waitForText('Sajnáljuk nincs ilyen találat', 30); // secs
        $I->see('Nincs record (Az összes');

        $I->fillField('Keresés','Succ');
        $I->waitForText('Success', 30); // secs
        $I->dontSee('Exception');
        
        $I->fillField('Keresés','Exc');
        $I->waitForText('Exception', 30); // secs
        $I->dontSee('Success');
        
        $I->fillField('Keresés','c');
        $I->waitForText('Success', 30); // secs
        $I->see('Exception');
        $I->amGoingTo('Ellenőrzés, hogy a tábla idő szerint rendez e');
        $firstTime = $I->grabTextFrom('/html/body/div/div[2]/div[2]/div/table/tbody/tr[1]/td[1]');
        $I->click('/html/body/div/div[2]/div[2]/div/table/thead/tr/th[1]');
        $I->wait(5);
        $lastTime = $I->grabTextFrom('/html/body/div/div[2]/div[2]/div/table/tbody/tr[1]/td[1]');
        if($firstTime==$lastTime){
        throw new Exception('A táblázat nem rendez');
        }else if($firstTime>=$lastTime){
        throw new Exception('Az első dátum nagyobb, mint a második');
        }
    }
}
