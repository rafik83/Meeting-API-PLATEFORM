Feature:
    In order to prove that a user can log in application
    As a user
    I want to login

    Scenario: I can not log into the platform if no email provided
        When I go to "/fr"
        And I press "join-community"
        And I fill in "loginUserName" with "john"
        And I press "Se connecter"
        Then I should see "Ce champs est requis"

    Scenario: I can not log into the platform if no password provided
        When I go to "/fr"
        And I press "join-community"
        And I fill in "loginUserName" with "john"
        And I press "Se connecter"
        Then I should see "Ce champs est requis"

    Scenario: I can log into the platform
        When I go to "/fr"
        And I press "join-community"
        And I fill in "loginUserName" with "user@example.com"
        And I fill in "loginPassword" with "password"
        And I press "Se connecter"
        And I wait 2000
        Then I should see "Vous êtes connecté"
