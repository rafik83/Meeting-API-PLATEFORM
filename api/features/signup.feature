Feature:
    In order to prove that a user can sign up to the application
    As a user
    I want to sign up

    Scenario: I can see the sign up form
        When I go to "/fr"
        And I press "join-community"
        And I fill in "loginUserName" with "john"
        And I follow "S'inscrire"
        Then I should see "Créer un compte"

    Scenario: I can not sign up if I miss to fill some field
        When I go to "/fr"
        And I press "join-community"
        And I follow "S'inscrire"
        And I fill in "password" with "hello world"
        And I fill in "email" with "john@doe.com"
        And I press "S'inscrire"

    Scenario: I can not sign up if I did'nt provide a valid email
        When I go to "/fr"
        And I press "join-community"
        And I follow "S'inscrire"
        And I fill in "email" with "invalid email"
        And I press "S'inscrire"
        Then I should see "Cet email est invalide"

    Scenario: I can not sign up if I did'nt provide a valid password
        When I go to "/fr"
        And I press "join-community"
        And I follow "S'inscrire"
        And I fill in "password" with "toto"
        And I press "S'inscrire"
        Then I should see "Le mot de passe doit avoir une longueur de 8 caractères minimum"

    Scenario: I can sign up as John Doe
        Given the database is purged
        And I want to join proximum community
        When I go to "/fr"
        And I press "join-community"
        And I follow "S'inscrire"
        And I fill in "email" with "john@doe.com"
        And I fill in "firstname" with "john"
        And I fill in "lastname" with "doe"
        And I fill in "password" with "password"
        And I check "termsAndCondition"
        And I press "S'inscrire"
        And I wait 2000
        Then I should see "Se connecter"
        