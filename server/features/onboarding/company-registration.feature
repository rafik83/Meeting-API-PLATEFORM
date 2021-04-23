Feature:
    In order to prove that I can register my company
    As a user
    I want to save my company data
    Scenario: I can save my company if all required fields are filled
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"
        And I go to "/en/onboarding/2"
        And I fill in "companyName" with "Best Company"
        And I press "Country"
        And I select "Belgium" from "countryCode"
        And I fill in "website" with "https://bestcompany.com"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"
        And I wait 3000
        Then I should see "Select 1 goal"

    Scenario: I can search countries from the country list
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"
        And I go to "/en/onboarding/2"

        And I press "Country"
        And I fill in "country-searchinput" with "bel"
        Then I should not see "Bergium"

    Scenario: I can't save my company fields are empty
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"

        And I go to "/en/onboarding/2"
        And I press "Next"
        And I wait 250
        Then I should see "This field is required"

    Scenario: I can't save if company name fields are empty
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"

        And I go to "/en/onboarding/2"
        And I press "Country"
        And I select "Belgium" from "countryCode"
        And I fill in "website" with "https://bestcompany.com"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"
        
        Then I should see "This field is required"

    Scenario: I can't save if company country is not selected
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"

        And I go to "/en/onboarding/2"
        And I fill in "companyName" with "Best Company"
        And I fill in "website" with "https://bestcompany.com"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"
        
        Then I should see "This field is required"

    Scenario: I can't save if company website is not filled
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"

        And I go to "/en/onboarding/2"
        And I fill in "companyName" with "Best Company"
        And I press "Country"
        And I select "Belgium" from "countryCode"
        And I fill in "activity" with "Best describe ever"
        And I press "Next"

        Then I should see "This field is required"
