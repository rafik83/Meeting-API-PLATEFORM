<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * @Then I wait :arg1
     */
    public function iWait($arg1)
    {
        $this->getSession()->wait($arg1);
    }

    /**
     * @When I click on :elementId
     */
    public function iClickOn($elementId)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->findById($elementId); // runs the actual query and returns the element
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not find element with id: "%s"', $elementId));
        }

        $element->click();
    }

    /**
     * @Then I sign in as :email
     */
    public function iSignInAs($email)
    {
        $this->pressButton('join-community');
        $this->fillField('loginUserName', $email);
        $this->fillField('loginPassword', 'password');
        $this->pressButton('Signin');
        $this->iWait(4000);
    }
}
