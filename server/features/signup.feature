
Feature:
    In order to prove that a user can sign up to the application
    As a user
    I want to sign up

    Scenario: I can see the sign up form
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I press "join-community"
        And I fill in "loginUserName" with "john"
        And I follow "Signup"
        Then I should see "Register"

    Scenario: I can not sign up if I miss to fill some field
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I press "join-community"
        And I follow "Signup"
        And I fill in "password" with "hello world"
        And I fill in "email" with "john@example.com"
        And I press "Signup"

    Scenario: I can not sign up if I did'nt provide a valid email
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I press "join-community"
        And I follow "Signup"
        And I fill in "email" with "invalid email"
        And I press "Signup"
        Then I should see "This email is not valid"

    Scenario: I can not sign up if I did'nt provide a valid password
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I press "join-community"
        And I follow "Signup"
        And I fill in "password" with "toto"
        And I press "Signup"
        Then I should see "the password must be at least 8 characters long"

    Scenario: I can sign up as John Doe
        Given the database is purged
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I press "join-community"
        And I follow "Signup"
        And I fill in "email" with "john@example.com"
        And I fill in "firstname" with "john"
        And I fill in "lastname" with "doe"
        And I fill in "password" with "password"
        And I check "termsAndCondition"
        And I press "Signup"
        And I wait 2000
        Then I should see "Signin"
        