Feature: Show the homepage

Scenario: homepage
    When I am on "/en/article/home.html"
    Then I should see "Home"
