Feature:
    In order to prove that I can register my company
    As a user
    I want to save my company data

    Background:
        Given the database is purged
        And the user "john@example.com" is created
        And the aerospace community is created
        And all the required nomenclature are created for the community "aerospace"
        And as "john@example.com" I want to join aerospace community
        And I go to "/en"
        And I sign in as "john@example.com"
        And I go to "/en/onboarding/2-2"
        And I wait until I see "John Doe" in "main h2"

    Scenario: I can save my company if all required fields are filled
        And I fill in "name" with "Best Company"
        And I press "Country"
        And I select "Belgium" from "countryCode"
        And I fill in "website" with "https://bestcompany.com"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"
        Then I wait until I see "Select 1 goal" in "main"

    Scenario: I can search countries from the country list
        When I press "Country"
        And I fill in "country-searchinput" with "bel"
        Then I should not see "Bergium"

    Scenario: I can't save my company fields are empty
        And I press "Next"
        Then I wait until I see "This field is required" in "form"

    Scenario: I can't save if company name fields are empty
        When I press "Country"
        And I select "Belgium" from "countryCode"
        And I fill in "website" with "https://bestcompany.com"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"
        Then I wait until I see "This field is required" in "form"
        
    Scenario: I can't save if company country is not selected
        When I fill in "name" with "Best Company"
        And I fill in "website" with "https://bestcompany.com"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"
        Then I wait until I see "This field is required" in "form"

    Scenario: I can't save if company website is not filled
        When I fill in "name" with "Best Company"
        And I press "Country"
        And I select "Belgium" from "countryCode"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"
        Then I wait until I see "This field is required" in "form"
        
    Scenario: I see the error message disappear when I fill in the field
        When I press "Next"
        And I should see "This field is required"
        And I fill in "name" with "Best Company"
        And I press "Country"     
        And I select "Belgium" from "countryCode"
        And I fill in "website" with "https://bestcompany.com"
        And I fill in "activity" with "Best describe ever"
        Then I should not see "This field is required"
