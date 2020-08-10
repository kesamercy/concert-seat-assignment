<?php
class HomepageCest
{
    public function venueButtonsPresent(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Home');
        $I->see('Madison');
        $I->see('Kenedy');
        $I->see('Crisscross');

        $I->click('Madison');
        $I->click('Kenedy');
        $I->click('Criscross');
    }
}
                