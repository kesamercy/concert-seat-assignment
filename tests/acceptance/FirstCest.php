<?php
class HomepageCest
{
    public function homePageElements(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Home');
        
        
    }
    public function venuneButtonsRouteValidation(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Madison');
        $I->amOnPage('/parse-json');
        $I->see('Madison');

        $I->click('back');

        $I->amOnPage('/');
        $I->click('Kenedy');
        $I->amOnPage('/parse-json');
        $I->see('Kenedy');

        $I->click('back');
        $I->click('Criscross');
        $I->amOnPage('/parse-json');
        $I->see('Criscross');
    }
}
                