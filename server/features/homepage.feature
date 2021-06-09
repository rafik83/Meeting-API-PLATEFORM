Feature:
    In order to prove that I can do many action with the home page
    As a user
    I want to interact with the cards displayed

    Background: 
        Given the database is purged
        And the aerospace community is created
        And the user "john@example.com" is created
        And all the required nomenclature are created for the community "aerospace"
        And as "john@example.com" I want to join aerospace community
        And those company are created
        |name         |countryCode|website                 |activity      |
        |Proximum     |FR         |http://www.proximum.com |Event organizer|
        |Fairness.coop|FR         |http://www.fairness.coop|Event organizer|
        And those accounts are created
        |firstName  |lastName |jobPosition |email            |companyDomainName|
        |Piotr      |Kropot   |Minister    |p@proximum.com   |www.proximum.com  |
        |Emma       |Goldman  |Minister    |e@fairness.coop  |www.fairness.coop |
        When I go to "/en"

Scenario: If I am not logged in, it is suggested that I log in to meet a member
    Then I should see "Loading"
    And I wait until I see "#homepage-slider-1"
    And I press "homepage-slider-1-next" 2 times
    And I press "meet-emma-goldman-button"
    Then I should see "Let's Start!"
    And I should see "Sign In"

Scenario: If I'm logged in I can meet a member
    Given I wait until I see "#menu-responsive"
    And I sign in as "john@example.com"
    And I go to "/en"
    And I wait until I see "#homepage-slider-1"
    And I press "homepage-slider-1-next" 2 times
    And I press "meet-emma-goldman-button"
    Then I should be on "/en/videoconference/898999"
