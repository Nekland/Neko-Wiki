Feature: Search
  In order to find an article
  As a non authenticated user
  I should be able to type words in the search bar
  And get a list of results

  @smartStep
  Scenario: I search the page foo search
    Given I am on "/en/article/home.html"
     When I fill in "Search" with "foo search"
      And I press "submit_search"
     Then I should see "You can create the page \"Foo search\" right now."
      And I should see "Results for your search"

  Background:
    Given the page "Foo Bar" exists in "french"
      And the page "Something in english" exists in "english"
      And my current language is "english"

  Scenario: redirected automatically on the right page
    Given I am on "/"
     When I fill "search" with "Something in english"
      And I press search
     Then I should see the page "Something in english"

  Scenario: existing page in another language
    Given I am on "/"
     When I fill "search" with "Foo Bar"
      And I press search
     Then I should see the search page
      And I should see highlighted "The page exists in another language"

  Scenario: the page does not exists but there are related results on search
    Given I am on "/"
     When I fill "search" with "Something"
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
