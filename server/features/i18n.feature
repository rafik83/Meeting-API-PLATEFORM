Feature:
    In order to prove that the app still supports i18n
    As a user
    I want to login in french
    Scenario: I can not log into the platform if no email provided
        When I go to "/fr"
        And I press "menu-responsive"
        And I wait 100
        And I press "join-community"
        And I fill in "username" with "john"
        And I press "Se connecter"
        Then I should see "Ce champs est requis"

    Scenario: I can not log into the platform if no password provided
        When I go to "/fr"
        And I press "menu-responsive"
        And I wait 1000
        And I press "join-community"
        And I fill in "username" with "john"
        And I press "Se connecter"
        Then I should see "Ce champs est requis"
