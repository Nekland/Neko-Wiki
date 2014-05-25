Feature: Show the homepage

@javascript
Scenario: homepage
    When I am on the homepage
    Then I should see "Home"
