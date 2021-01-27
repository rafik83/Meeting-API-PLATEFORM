# This file contains a user story for demonstration only.
# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html

Feature:
    In order to prove that the app work with a svelte client & symfony api
    As a user
    I want to have a demo scenario

    @javascript
    Scenario: It receives a response from svelte ap
        Given I am on the homepage
        When I go to "/fr"
        Then I should see "C'est parti !"
        And I should see "Créer un compte"
