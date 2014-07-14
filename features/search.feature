Feature: Search
  In order to find an article
  As a non authenticated user
  I should be able to type words in the search bar
  And get a list of results

  Scenario: homepage
    Given I am on the homepage
     When I fill in "Search" with "foo search"
     Then I should see "Create the page \"Foo search\" on this wiki."
      And I should see "Results of the search"
