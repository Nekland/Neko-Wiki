Feature: ability to change the language
  As a lambda user
  I should be able to change the current language
  When the page is available in another language

  Scenario: I go to the french version of the help
    Given I am on "/en/article/help.html"
    When I follow "Other languages"
    And I follow "Français"
    Then I should see "Aide"
