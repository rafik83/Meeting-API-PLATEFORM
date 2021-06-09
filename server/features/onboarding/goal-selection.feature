Feature:
    In order to prove that I can save my personal data
    As a user
    I want to select my goals
    
    Scenario: I can select my first objective
        Given the database is purged
        And the user "john@example.com" is created
        And the aerospace community is created
        And all the required nomenclature are created for the community "aerospace"
        And as "john@example.com" I want to join aerospace community
        When I go to "/en"
        And I sign in as "john@example.com"
        And I go to "/en/onboarding/3"
        And I press "Buy"
        Then I should see "1/2 maximum selected"

    Scenario: I can deselect a tag to update priorities
        When I go to "/en"
        And I sign in as "john@example.com"
        And I go to "/en/onboarding/3"
        And I press "Buy"
        And I press "Sell"
        Then I should see "2/2 maximum selected" 
        And I press "Sell" 
        Then I should see "1/2 maximum selected"
        And I should not see "2/2 maximum selected"    
