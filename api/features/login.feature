# This file contains a user story for demonstration only.
# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html

Feature:
    In order to prove that a user can log in application
    As a user
    I want to have a login scenario

    Scenario: I can not log into the plattform if provide a bad username
        When I go to "/fr/join/login"
        And I fill in "loginUserName" with "fooo"
        And I fill in "loginPassword" with "password"
        And I press "Se connecter"
        And I wait 1000
        Then I should see "Nom d'utilisateur ou mot de passe incorrect"

    Scenario: I can not log into the platform if no email provided
        Given I am on the homepage
        When I go to "/fr/join/login"
        And I fill in "loginUserName" with "john"
        And I press "Se connecter"
        Then I should see "Ce champs est requis"

    Scenario: I can log into the platform
        Given I am on the homepage
        When I go to "/fr/join/login"
        And I fill in "loginUserName" with "user@example.com"
        And I fill in "loginPassword" with "password"
        And I press "Se connecter"
        And I wait 2000
        Then I should see "Vous êtes connecté"    

 
