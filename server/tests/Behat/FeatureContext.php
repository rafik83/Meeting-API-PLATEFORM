<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ResponseTextException;
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
        $this->pressButton('menu-responsive');
        $this->iWaitUntilIClick('#join-community');
        $this->fillField('username', $email);
        $this->fillField('password', 'password');
        $this->pressButton('sign_in_button');
        $this->iWaitUntilISeeTextContent('John Doe', 'main h2');
    }

    /**
     * @Then I wait until I see :cssSelector
     */
    public function iWaitUntilISee($cssSelector)
    {
        if (
            $this->getSession()->wait(
                4000,
                "document.querySelector('$cssSelector')"
            )
        ) {
            return true;
        }

        $message = "The css selector '$cssSelector' was not found after a 4 seconds timeout";
        throw new ResponseTextException($message, $this->getSession());
    }

    /**
     * @Then I wait until I can click on :cssSelector
     */
    public function iWaitUntilIClick($cssSelector)
    {
        if (
            $this->getSession()->wait(
                4000,
                "document.querySelector('$cssSelector')"
            )
        ) {
            $this->getSession()
                ->getPage()
                ->find('css', $cssSelector)
                ->click();

            return true;
        }

        $message = "Click on element '$cssSelector' was not be done after a 4 seconds timeout";
        throw new ResponseTextException($message, $this->getSession());
    }

    /**
     * @Then I wait until I see :textContent in :cssSelector
     */
    public function iWaitUntilISeeTextContent($textContent, $cssSelector)
    {
        if (
            $this->getSession()->wait(
                7000,
                "document.querySelector('$cssSelector').textContent.match('$textContent') !== null"
            )
        ) {
            return true;
        }

        $message = "The text '$textContent' was not found in '$cssSelector' after a 7 seconds timeout";
        throw new ResponseTextException($message, $this->getSession());
    }

    /**
     * Presses button  with specified id|name|title|alt|value n times
     * Example: Then I press "Log In" 3 times
     * Example: And I press "Log In" 3 times
     *
     * @Then I press :button :timesCount times
     */
    public function iPressTimes(string $button, int $timesCount)
    {
        for ($i = 1; $i <= $timesCount; ++$i) {
            $this->pressButton($button);
        }
    }
}
