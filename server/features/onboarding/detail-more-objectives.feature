Feature:
    In order to detail more objectives
    As a user
    I want to select another goal to detail

Background:
    Given the database is purged
    And the user "john@example.com" is created
    And the aerospace community is created
    And all the required nomenclature are created for the community "aerospace"
    And as "john@example.com" I want to join aerospace community
    And these are my main objectives:
    | tagName  |
    | Buy      |
    | Sell     |
    When I go to "/en"
    And I sign in as "john@example.com"

Scenario: I can select one more goal
    When I go to "/en/onboarding/4-3"
    Then I wait until I see "Buy" in "main"
    And I press "Buy"
    Then I should be on "/en/onboarding/4-1?tagId=3"
