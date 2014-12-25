Feature: Search
  In order to find an article
  As a non authenticated user
  I should be able to type words in the search bar
  And get a list of results

  @smartStep
  Scenario: I search the page foo search
    Given my current language is "english"
      And I am on "/en/article/home.html"
     When I fill in "Search" with "foo search"
      And I press "submit_search"
     Then I should see "You can create the page \"Foo search\" right now."
      And I should see "Results for your search"

  Scenario: redirected automatically on the right page
    Given I am on "/en/article/home.html"
     When I fill in "Search" with "Something in english"
      And I press "submit_search"
     Then I should see "Something in english"

  Scenario: existing page in another language
    Given I am on "/en/article/home.html"
     When I fill in "Search" with "Foo Bar"
      And I press "submit_search"
     Then I should see "Results for your search"
      And I should see "The page exists in another language"

  Scenario: the page does not exists but there are related results on search
    Given I am on "/"
     When I fill "Search" with "Something"
      And I press search
     Then I should see the search page
      And I should see a list of related results

  Scenario: the page does not exists and there is no results in my languages
    Given I am on "/"
    When I fill "search" with "Foo"
    And I press search
    Then I should see the search page
    And I should see "There is no results for your current language but there are results in other languages"
    And I should see a list of revelant results sorted by language
