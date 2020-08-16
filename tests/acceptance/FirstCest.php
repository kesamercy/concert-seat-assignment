<?php
class HomepageCest
{
    public function homePageElements(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('The Venue');
        
    }
    public function validateMadisonPageElements(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Madison Square Garden');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->see('The Venue');
        $I->see('Madison Square Garden Seating');
        $I->selectOption('How many seats would you like to book:','1');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
    }

    public function selectOneSeatAtMadison(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Madison Square Garden');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->see('The Venue');
        $I->see('Madison Square Garden Seating');
        $I->selectOption('How many seats would you like to book:','1');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
        $I->see('Best Seat Option: I8');
        $I->click('Thank you, order complete');
        $I->canSeeInCurrentUrl('/');
    }
    public function selectTwoSeatsAtMadison(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Madison Square Garden');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->selectOption('How many seats would you like to book:','2');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
        $I->see('Sorry, two seats are not available');
        $I->click('Thank you, order complete');
    }
    public function selectThreeSeatsAtMadison(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Madison Square Garden');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->see('The Venue');
        $I->see('Madison Square Garden Seating');
        $I->selectOption('How many seats would you like to book:','3');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
        $I->see('Sorry, three seats are not available');
        $I->click('Thank you, order complete');
    }

    // Criss-Cross Page elements
    public function validateCrissCrossPageElements(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Criscross Raging Ball');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->see('The Venue');
        $I->see('Criscross Raging Ball Seating');
        $I->selectOption('How many seats would you like to book:','1');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
    }

    public function selectOneSeatAtCrissCross(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Criscross Raging Ball');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->selectOption('How many seats would you like to book:','1');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
        $I->see('Best Seat Option: A1');
        $I->click('Thank you, order complete');
        $I->canSeeInCurrentUrl('/');
    }
    public function selectTwoSeatsAtCrissCross(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Criscross Raging Ball');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->selectOption('How many seats would you like to book:','2');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
        $I->see('Best Seat Option: B4 , B5');
        $I->click('Thank you, order complete');
    }
    public function selectThreeSeatsAtCrissCross(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Criscross Raging Ball');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->see('The Venue');
        $I->see('Criscross Raging Ball');
        $I->selectOption('How many seats would you like to book:','3');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
        $I->see('Best Seat Option: B4 , B5, B3');
        $I->click('Thank you, order complete');
    }

    // kenedy page elements
    public function validateKenedyPageElements(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('JF Kenedy Center');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->see('The Venue');
        $I->see('JF Kenedy Center Seating');
        $I->selectOption('How many seats would you like to book:','1');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
    }

    public function selectOneSeatAtKenedy(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('JF Kenedy Center');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->selectOption('How many seats would you like to book:','1');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
        $I->see('Best Seat Option: A7');
        $I->click('Thank you, order complete');
        $I->canSeeInCurrentUrl('/');
    }
    public function selectTwoSeatsAtKenedy(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('JF Kenedy Center');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->selectOption('How many seats would you like to book:','2');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
        $I->see('Best Seat Option: D3 , D2');
        $I->click('Thank you, order complete');
    }
    public function selectThreeSeatsAtKenedy(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('JF Kenedy Center');
        $I->canSeeInCurrentUrl('/src/venue');
        $I->selectOption('How many seats would you like to book:','3');
        $I->click('Submit');
        $I->canSeeInCurrentUrl('/src/find-seat');
        $I->see('Best Seat Option: D3 , D2, D1');
        $I->click('Thank you, order complete');
    }
}
                