Feature:
    In order to prove that I can save my personal data
    As a user
    I want to tell who I am

    Scenario: I can not save my personal data if I did'nt select all the required fields
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/fr"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"
        And I press "Fonction"
        And I select "Ministre" from "jobPosition" 
        And I press "Suivant"
        Then I should see "Ce champs est requis"

    Scenario: I can reach the next step if I fill all the required fields
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/fr"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"
        And I press "Fonction"
        And I select "Ministre" from "jobPosition" 
        And I fill in "jobTitle" with "Roi du monde connu"
        And I press "Langue principale"
        And I select "Français" from "mainLanguage"
        And I press "Pays"
        And I select "Belgium" from "country"
        And I press "Fuseau horaire"
        And I select "Acre Time (Eirunepe)" from "timezone"
        And I press "Suivant"
        And I wait 2000
        Then I should see "Créez votre entreprise."

    Scenario: I can search my job position from the job position list
        Given the database is purged
        And the user "john@doe.com" is created
        And I want to join aerospacial community
        When I go to "/fr"
        And I press "menu-responsive"
        And I wait 1000
        And I sign in as "john@doe.com"
        And I press "Fonction"
        And I fill in "fonction-searchinput" with "culti"
        Then I should not see "Ministre"
