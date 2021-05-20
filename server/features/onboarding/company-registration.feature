Feature:
    In order to prove that I can register my company
    As a user
    I want to save my company data

    Background: 
        Given the database is purged
        And the user "john@example.com" is created
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@example.com"
        And I go to "/en/onboarding/2-2"
  

    Scenario: I can search countries from the country list
        When I press "Country"
        And I fill in "country-searchinput" with "bel"
        Then I should not see "Bergium"

    Scenario: I can't save my company fields are empty
        When I press "Next"
        And I wait 250
        Then I should see "This field is required"

    Scenario: I can't save if company name fields are empty
        When I press "Country"
        And I select "Belgium" from "countryCode"
        And I fill in "website" with "https://bestcompany.com"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"        
        Then I should see "This field is required"

    Scenario: I can't save if company country is not selected
        When I fill in "name" with "Best Company"
        And I fill in "website" with "https://bestcompany.com"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"        
        Then I should see "This field is required"

    Scenario: I can't save if company website is not filled
        When I fill in "name" with "Best Company"
        And I press "Country"
        And I select "Belgium" from "countryCode"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"
        Then I should see "This field is required"
        
    Scenario: I see the error message disappear when I fill in the field
        When I press "Next"
        And I should see "This field is required"
        And I fill in "name" with "Best Company"
        And I press "Country"     
        And I select "Belgium" from "countryCode"
        And I fill in "website" with "https://bestcompany.com"
        And I fill in "activity" with "Best describe ever"
        Then I should not see "This field is required"
