Feature: Manage a wiki page
  As a user
  I should be able to make a new page
  And modify existing ones

  Scenario: Write a new page
    Given I search the page foo search
     When I follow "Foo search"
      And I should see "Modification de Foo search"
     Then I fill in the following:
      """
        Hello, I'm foo bar !
        **Are you ready to see what happen ?**
      """
      And I press "Edit"
      And I should see "Hello, i'm foo bar !"
