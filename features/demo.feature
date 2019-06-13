Feature: Test Homepage and Contact Page

  Scenario: Navigate Beetween HomePage and ContactPage
    Given I am on homepage
    Then I should see "My Beers 🍻"
    And I wait for 1
    When I follow "Contact Us"
    Then I should be on "/contact"
    And I wait for 1
    When I fill in "First name" with "Jean-Pierre"
    And I fill in "Last name" with "Pernault"
    And I fill in "Email" with "jp@test.fr"
    And I fill in "Message" with "Hello MyBeers, I love your site"
    And I wait for 1
    When I press "Submit"
    And I wait for 1
    Then I should be on "/"
    And I should see "Thanks to contact us!"
