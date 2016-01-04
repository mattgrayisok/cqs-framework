<?php
/**
 * User: Slice
 * Date: 15/08/15
 * Time: 18:08
 */

$I = new AcceptanceTester($scenario);
$I->am('a user');
$I->wantTo('see the home page');
$I->amOnPage('/');
$I->see('Laravel');