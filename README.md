p4.torman.us
============
The purpose of this application is to calculate how much
each family has to pay or get back if they are overpaid.
Each year, we have a big BBQ party with over 15 families. 
Each family might have to prepare food, drinks or other groceries, 
they can just enter the expenses they have paid to the application. 
Since, seniors and children under 12 are free of charge. 
Each family needs to enter the numbers of headcount, senior and 
children, and expenese to the application.

Those information will be stored in database. When the application loads,
family data is retrieved from database and load to the balance
sheet table. js will do all calculations for the balance sheet 
(the amount in balance column)

* Only admin has privilege of creating user and family.
* There is an interface in which admin can enter BBQ data for any family
* Each user belongs to a family. One family can have more than 
one members/users who can access the application. 
For example, Ethan and Emily are the family member of Kuen. 
Either Ethan or Emily can update their family information for the BBQ.
* ordinary users can only edit his/her family's data.
* each user can see the balance sheet

* The balance column of balance sheet is handled by js

* In /users/family_data_edit page, js will validate the entry fields
1. headcount must not be less than the sum of senior and children
2. expenses field must be a number (can be decimal)

* In /admin/admin page, js will validate entry fields including
1. email 
2. first name
3. last name
4. password  (with certain pattern)
5. retype password must match to password


Instructors can use some user accounts listed below to test the application.

user/email	        password	role
---------------     --------    ----------
"emily@abcd.com"	"asdf2@"	admin
"justin@abcd.com"	"asdf3#"	basic user
"ethan@abcd.com"	"asdf2@"	basic user
