Feature: Registration and login of a user
  In order to use the wiki
  As a classical user
  I should be able to register and login
  And update my preferences

  Scenario: Be able to register
    Given I am on "/en/article/home.html"
     Then I follow "Member"
      And I follow "Register"
     When I fill in "Username" with "Nek"
      And I fill in "Email" with "fake@email.com"
      And I fill in "Password" with "0000"
      And I fill in "Password again" with "0000"
      And I press "Join us !"
     Then I should see "Thank you for register :)"

  Scenario: Be able to login
    Given I am on "/en/article/home.html
     Then I follow "Member"
      And I follow "Login"
     When I fill in "Username" with "admin"
      And I fill in "Password" with "admin"
      And I press "Login"
     Then I should see "Your profile"
