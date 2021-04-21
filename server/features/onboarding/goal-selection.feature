Feature:
    In order to prove that I can save my personal data
    As a user
    I want to select my goals
    
    Scenario: I can select my first objective
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/fr"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"
        And I go to "/fr/onboarding/3"
        And I press "Buy"
        Then I should see "1/2 maximum sélectionné"

    Scenario: I can deselect a tag to update priorities
        When I go to "/fr"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"
        And I go to "/fr/onboarding/3"
        And I press "Buy"
        And I press "Sell"
        Then I should see "2/2 maximum sélectionnés" 
        And I press "Sell" 
        Then I should see "1/2 maximum sélectionné"
        And I should not see "2/2 maximum sélectionnés"    
