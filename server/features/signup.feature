Feature:
    In order to prove that a user can sign up to the application
    As a user
    I want to sign up

    Scenario: I can see the sign up form
        When I go to "/en"
        And I press "menu-responsive"
        And I wait until I can click on "#join-community"
        And I fill in "username" with "john"
        And I follow "Signup"
        Then I should see "Register"

    Scenario: I can not sign up if I miss to fill some field
        When I go to "/en"
        And I press "menu-responsive"
        And I wait until I can click on "#join-community"
        And I follow "Signup"
        And I fill in "password" with "hello world"
        And I fill in "email" with "john@example.com"
        And I press "Signup"

    Scenario: I can not sign up if I did'nt provide a valid email
        When I go to "/en"
        And I press "menu-responsive"
        And I wait until I can click on "#join-community"
        And I follow "Signup"
        And I fill in "email" with "invalid email"
        And I press "Signup"
        Then I should see "This email is not valid"

    Scenario: I can not sign up if I did'nt provide a valid password
        When I go to "/en"
        And I press "menu-responsive"
        And I wait until I can click on "#join-community"
        And I follow "Signup"
        And I fill in "password" with "toto"
        And I press "Signup"
        Then I should see "the password must be at least 8 characters long"

    Scenario: I can sign up as John Doe
        Given the database is purged
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait until I can click on "#join-community"
        And I follow "Signup"
        And I fill in "email" with "john@example.com"
        And I fill in "firstName" with "john"
        And I fill in "lastName" with "doe"
        And I fill in "password" with "password"
        And I check "acceptedTermsAndCondition"
        And I press "Signup"
        Then I wait until I see "Signin" in "header h2"
