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
     Then I should see "The page exist in another language"
      And I should see "Foo Bar (fr)"

  Scenario: the page does not exists but there are related results on search
    Given I am on "/en/article/home.html"
     When I fill in "Search" with "Something"
      And I press "submit_search"
     Then I should see "Results for your search"
      And I should see "Something in english"

  Scenario: the page does not exists and there is no results in my languages
    Given I am on "/en/article/home.html"
     When I fill in "Search" with "Foo"
      And I press "submit_search"
     Then I should see "Sorry, absolutely nothing was found for your search :-( ."
      And I should see "Foo Bar (fr)"
