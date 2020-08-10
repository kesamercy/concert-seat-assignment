<?php
class HomepageCest
{
    public function venueButtonsPresent(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Home');
        $I->see('Madison');
        $I->see('Kenedy');
        $I->see('Criscross');

        $I->click('Madison');
        $I->click('Kenedy');
        $I->click('Criscross');
    }
}
                