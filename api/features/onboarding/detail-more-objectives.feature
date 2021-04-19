Feature:
    In order to detail more objectives
    As a user
    I want to select another goal to detail
    Background:
    Given the database is purged
    And the user "john@doe.com" is created
    And as "john@doe.com" I want to join aerospacial community
    And these are my main objectives:
    |tagId   | tagName                            |
    |  3     | Buy      |
    |  4     | Sell     |
    When I go to "/fr"
    And I sign in as "john@doe.com"
    Scenario: I can select one more goal
    When I go to "/fr/onboarding/4-3"
    And I wait 3000
    Then I should see "Buy"
    And I press "Buy"
    Then I should be on "/fr/onboarding/4-1?tagId=3"
