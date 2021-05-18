Feature:
    In order to prove that a user can log in application
    As a user
    I want to login
    
    Scenario: I can not log into the platform if no email provided
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I press "join-community"
        And I fill in "username" with "john"
        And I press "Signin"
        Then I should see "This field is required"

    Scenario: I can not log into the platform if no password provided
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I press "join-community"
        And I fill in "username" with "john"
        And I press "Signin"
        Then I should see "This field is required"  

    Scenario: I can log into the platform
        Given the database is purged
        And the user "john@example.com" is created
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@example.com"
        Then I should see "John Doe"
