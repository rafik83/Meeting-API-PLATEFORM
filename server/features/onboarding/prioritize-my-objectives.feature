Feature:
    In order to prioritize my objectives
    As a member
    I want to give a priority to my goals
Background:
    Given the database is purged
    And the user "john@doe.com" is created
    And as "john@doe.com" I want to join aerospacial community
    And these are my main objectives:
    |tagId   | tagName  |
    |  3     | Buy      |

    And I've selected those tags:
    |tagId   | tagName                                       |
    |  9     | PowerGenerator                                |
    |  10    | EEE Components technologies                   |
    |  11    | Method and process                            |
    |  8     | Electromagnetic                               |
    
    When I go to "/en"
    And I press "menu-responsive"
    And I wait 1000
    And I sign in as "john@doe.com"
    And I go to "/en/onboarding/4-2?tagId=3"
    And I wait 3000

Scenario: I can select one tag
        When I press "Electromagnetic"
        Then I should see "1/3 selected"
Scenario: Priorities are updated when I select a tag for the second time
        When I press "PowerGenerator"
        And I press "Electromagnetic"
        And I wait 3000 
        Then I should see "2/3 selected"
        And I press "Method and process" 
        Then I should see "3/3 selected"
        And I should not see "2/3 selected"
        And I press "PowerGenerator"
        Then I should see "2/3 selected"   
