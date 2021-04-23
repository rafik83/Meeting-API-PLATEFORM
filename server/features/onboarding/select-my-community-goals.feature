Feature:
    In order to select my community goals objectives
    As a member
    I want to select my community interests
    Background:
    Given the database is purged
    And the user "john@doe.com" is created
    And as "john@doe.com" I want to join aerospacial community
    And these are my main objectives:
    |tagId   | tagName  |
    |  3     | Buy      |

    When I go to "/en"
    And I press "menu-responsive"
    And I wait 1000
    And I sign in as "john@doe.com"
    And I go to "/en/onboarding/4-1?tagId=3"
    And I wait 3000

Scenario: I can select maximum 3 goals
    When I follow "Satellites"
    And I click on "treeSelect-6-label"
    And I follow "SpaceApps"
    Then I should see "3/3 selected"
    And I press "Next"
    And I wait 2000
    Then I should see "Space R&D"
    And I should see "Satellites"

Scenario: I can  deselect my goals
    When I follow "Satellites"
    And I click on "treeSelect-6-label"
    Then I should see "3/3 selected"
    And I click on "treeSelect-6-label"
    Then I should see "0/3 selected"
