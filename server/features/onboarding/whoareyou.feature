@debug
Feature:
    In order to prove that I can save my personal data
    As a user
    I want to tell who I am

    Background: DB is empty and aerospatial user exists
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/en"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"
 
    Scenario: I can reach the next step if I fill all the required fields
        When I press "Employment"
        And I select "Minister" from "jobPosition"
        And I fill in "jobTitle" with "Roi du monde connu"
        And I press "Main language"
        And I select "Français" from "mainLanguage"
        And I press "Country"
        And I select "Belgium" from "country"
        And I press "Timezone"
        And I select "Acre Time (Eirunepe)" from "timezone"
        And I press "Next"
        And I wait 2000
        Then I should see "Create your company."

    Scenario: I can search my job position from the job position list
        When I press "Employment"
        And I fill in "employment-searchinput" with "Mush"
        Then I should not see "Minister"
