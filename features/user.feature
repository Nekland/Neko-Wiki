Feature: Registration and login of a user
  In order to use the wiki
  As a classical user
  I should be able to register and login
  And update my preferences

  Scenario: Be able to register
    Given I am on the homepage
     Then I click on "Register"
     When I fill in "Username" with "Nek"
      And I fill in "Email" with "fake@email.com"
      And I fill in "Password" with "0000"
      And I click on "Join Us !"
     Then I should see "Your registration is complete :) ."

  Scenario: Be able to login
    Given I am on the homepage
     Then I click on "Login"
     When I fill in "Username" with "Nek"
      And I fill in "Password" with "0000"
      And I click on "Log in"
     Then I should be able to see "Successful login"
