# GLOBE-BANK
A Simple CMS ( Content Management System ) named "GLOBE BANK"

Technologies: 
HTML, CSS, PHP, MySQL

Views: 
It has 2 views
  1.) Private
      Is accessible to only files of the project
      
  2.) Public
      Is accessible to everyone
      a.) Index - Accessible to everyone without authentication
      b.) Staff - Accessible to only admin with proper authentication ( LOGIN - username, password ) 
          i.) Admins - CRUD ( Create, Read, Update, Delete )
          ii.) Subjects - CRUD ( Create, Read, Update, Delete )
          iii.) Pages - CRUD ( Create, Read, Update, Delete )
          
          SUBJECT and PAGE has one-to-many relationship
          Explanation:
          Each subject can have multiple pages but a page must have under 1 subject
  
Security: 
No SQL injection can break security as it uses proper methods to handle data during inserting or fetching data from database and from URL

