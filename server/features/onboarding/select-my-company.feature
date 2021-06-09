Feature:
    In order to prove that I can select my company
    As a user
    I want to select an existing company

Background: DB is empty and aerospatial user exists
        Given the database is purged
        And the aerospace community is created
        And the user "jane@vimeet.events" is created
        And all the required nomenclature are created for the community "aerospace"
        And as "jane@vimeet.events" I want to join aerospace community
        And the company "Vimeet Events" ("http://vimeet.events") has been already registered
        When I go to "/en"
        And I sign in as "jane@vimeet.events"
        And I go to "/en/onboarding/2-1"
        Then I should see "searching"

Scenario: I can select an existing company
        Then I wait until I can click on "#company-2565911836-button"
        Then I should see "It's my company"
        And I should see "Your company is"
        And I press "Next"
        Then I wait until I see "Select 1 goal" in "main"
