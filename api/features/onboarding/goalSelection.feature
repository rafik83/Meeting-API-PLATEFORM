Feature:
    In order to prove that I can save my personal data
    As a user
    I want to select my goals
    Scenario: I can select my first objective
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/fr"
        And I sign in as "john@doe.com"
        And I go to "/fr/onboarding/3"
        And I press "Etre le plus grand dresseur pokémon"
        Then I should see "1/3 maximum sélectionné"

    Scenario: I can select only 3 objectives
        When I go to "/fr"
        And I sign in as "john@doe.com"
        And I go to "/fr/onboarding/3"
        And I press "Etre le plus grand dresseur pokémon"
        And I press "Devenir le maître du monde!"
        Then I should see "2/3 maximum sélectionnés" 
        And I press "Vaincre le covid-19" 
        Then I should see "3/3 maximum sélectionnés"
        And I press "Être heureux!"
        Then I should see "3/3 maximum sélectionnés"
        And I should not see "4/3 maximum sélectionnés"    
