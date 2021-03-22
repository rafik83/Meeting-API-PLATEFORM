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
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/fr"
        And I sign in as "john@doe.com"
        Then I should see "John Doe"
