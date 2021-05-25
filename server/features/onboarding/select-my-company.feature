Feature:
    In order to prove that I can select my company
    As a user
    I want to select an existing company

Background: DB is empty and aerospatial user exists
        Given the database is purged
        And the user "jane@vimeet.events" is created
        And I want to join aerospacial community
        And the company "Vimeet Events" ("http://vimeet.events") has been already registered
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "jane@vimeet.events"
        And I go to "/en/onboarding/2-1"
        Then I should see "searching"              
        And I wait 3000

Scenario: I can select an existing company
        Then I press "company-2565911836-button"
        Then I should see "It's my company"
        And I should see "Your company is"
        And I press "Next"
        And I wait 3000
        Then I should not see "Please fill in your company details."
