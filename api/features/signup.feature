Feature:
    In order to prove that a user can sign up to the application
    As a user
    I want to sign up

    Scenario: I can see the sign up form
        When I go to "/fr"
        And I click on "success-kid"
        And I follow "S'inscrire"
        Then I should see "Créer un compte"

    Scenario: I can not sign up if I miss to fill some field
        When I go to "/fr"
        And I click on "success-kid"
        And I follow "S'inscrire"
        And I fill in "password" with "hello world"
        And I fill in "password" with "toto"
        And I fill in "email" with "john@doe.com"
        And I press "S'inscrire"

    Scenario: I can not sign up if I did'nt provide a valid email
        When I go to "/fr"
        And I click on "success-kid"
        And I follow "S'inscrire"
        And I fill in "email" with "invalid email"
        And I press "S'inscrire"
        Then I should see "Cet email est invalide"

    Scenario: I can not sign up if I did'nt provide a valid password
        When I go to "/fr"
        And I click on "success-kid"
        And I follow "S'inscrire"
        And I fill in "password" with "toto"
        And I press "S'inscrire"
        Then I should see "Le mot de passe doit avoir une longueur de 8 caractères minimum"
