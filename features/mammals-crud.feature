Feature: I would like to edit mammals

  Scenario Outline: Insert records
    Given I am on homepage
    And I follow "Login"
    And I fill in "Username" with "admin"
    And I fill in "Password" with "loremipsum"
    And I press "Login"
    And I go to "/admin/mammals/"
    Then I should not see "<mammals>"
    And I follow "Create a new entry"
    Then I should see "Mammals creation"
    When I fill in "Name" with "<mammals>"
    And I fill in "Weight" with "<weight>"
    And I press "Create"
    Then I should see "<mammals>"
    And I should see "<weight>"

  Examples:
    |mammals          |weight |
    |blue whale       |150    |
    |african elephant |5      |
    |white rhino      |4      |



  Scenario Outline: Edit records
    Given I am on homepage
    And I follow "Login"
    And I fill in "Username" with "admin"
    And I fill in "Password" with "loremipsum"
    And I press "Login"
    And I go to "/admin/mammals/"
    Then I should not see "<new-mammals>"
    When I follow "<old-mammals>"
    Then I should see "<old-mammals>"
    When I follow "Edit"
    And I fill in "Name" with "<new-mammals>"
    And I fill in "Weight" with "<new-weight>"
    And I press "Update"
    And I follow "Back to the list"
    Then I should see "<new-mammals>"
    And I should see "<new-weight>"
    And I should not see "<old-mammals>"

  Examples:
    |old-mammals     |new-mammals |new-weight|
    |blue whale      |nowosc      |50        |
    |african elephan |nowyy       |40        |


  Scenario Outline: Delete records
    Given I am on homepage
    And I follow "Login"
    And I fill in "Username" with "admin"
    And I fill in "Password" with "loremipsum"
    And I press "Login"
    And I go to "/admin/mammals/"
    Then I should see "<mammals>"
    When I follow "<mammals>"
    Then I should see "<mammals>"
    When I press "Delete"
    Then I should not see "<mammals>"

  Examples:
    |mammals    |
    |nowosc     |
    |nowyy      |
    |white rhino|
