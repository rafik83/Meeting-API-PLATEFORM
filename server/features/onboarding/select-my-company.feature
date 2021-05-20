Feature:
    In order to prove that I can select my company
    As a user
    I want to select an existing company

Background: DB is empty and aerospatial user exists
        Given the database is purged
        And the user "jane@vimeet.events" is created
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "jane@vimeet.events"

Scenario: I can select an existing company
        And I go to "/en/onboarding/2-1"
        Then I should see "searching"
        And I wait 3000
        Then I press "company-2565911836-button"
        Then I should see "It's my company"
        And I should see "Your company is"
        And I press "Next"
        And I wait 3000
        Then I should see "Please fill in your company details."

Scenario: I can fill in my company details
        And I go to "/en/onboarding/2-1"
        Then I should see "searching"
        And I wait 3000
        Then I press "company-2565911836-button"
        Then I should see "It's my company"
        And I should see "Your company is"
        And I press "Next"
        And I wait 3000
        Then I should see "Please fill in your company details."   
        And I press "Country"
        And I select "Belgium" from "countryCode"
        And I fill in "website" with "https://bestcompany.com"
        And I press "Next"
        And I wait 1000
        Then I should be on "/en/onboarding/3"
