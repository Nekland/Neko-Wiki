Feature: Search
  In order to find an article
  As a non authenticated user
  I should be able to type words in the search bar
  And get a list of results

  @smartStep
  Scenario: I search the page foo search
    Given I am on the homepage
     When I fill in "Search" with "foo search"
      And I press "submit_search"
     Then I should see "You can create the page \"Foo search\" right now."
      And I should see "Results for your search"
