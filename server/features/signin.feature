Feature:
    In order to prove that a user can log in application
    As a user
    I want to login

    Scenario: I can not log into the platform if no email provided
        When I go to "/en"
        And I press "menu-responsive"
        And I wait until I can click on "#join-community"
        And I fill in "username" with "john"
        And I press "Sign in"
        Then I should see "This field is required"

    Scenario: I can not log into the platform if no password provided
        When I go to "/en"
        And I press "menu-responsive"
        And I wait until I can click on "#join-community"
        And I fill in "username" with "john"
        And I press "Sign in"
        Then I should see "This field is required"  

    Scenario: I can log into the platform
        Given the database is purged
        And the aerospace community is created
        And the user "john@example.com" is created
        And all the required nomenclature are created for the community "aerospace"
        And as "john@example.com" I want to join aerospace community
        When I go to "/en"
        And I sign in as "john@example.com"
        Then I wait until I see "John Doe" in "h2"
