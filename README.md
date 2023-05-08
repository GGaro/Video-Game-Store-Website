# Video-Game-Store-Website

Introduction
The purpose of this project was to create a website for a video game shop using a minimal gold and black color scheme. The website has various features such as sign up, login, browsing games, adding games to cart or Wishlist, and checkout. Additionally, an admin panel was created for managing games, and an easter egg page was added for fun.
Design
The website design was based on a minimal gold and black color scheme, with custom icons created for the navigation bar. The homepage (index.php) displays the logo, and the navigation bar allows the user to browse the website's various sections. My index.php is a basic one where the user sees the logo and then they can navigate the page using the navigation bar on top.
•	The signup.php uses a form to get data from the user, it takes a username , an email and a password with an additional field for the user to confirm their password, then the user can click the sign up button to register, the user will be notified if the username or email they added was already in use and they will not be able to make a new account with the same.
•	The login.php uses a form to get the username or email and the password of the user and if it finds the user in the database it then proceeds to log them in the website which unlocks many features, if the username admin and password admin is inputted it unlock a new page for admins to manage the games that are currently on display.
•	The Browse.php works in a view only mode if the user is not logged in, however if the user is logged in they can add the game in their cart or their Wishlist, it takes the data from a game.csv which has the games title, description, price and image link, if the user is logged in as the admin they can upload a new csv file using the tools in the admin.php.
•	The checkout.php does not allow access unless the user is logged in, once logged in it will display all the games that are in the cart as well as the total amount of money, then the user can use the purchase button to “buy” them and a display on the delivery date will appear (“Note: nothing will arrive on that date”)
•	After the user is logged in the login.php and signup.php will change to profile.php and logout.php.
•	The profile.php will have a setting for the user to change their username and their password. The page also displays any game the user put in their Wishlist on the right side of the page.
•	The logout.php logs out the user.
•	If the user is logged in as an admin, the admin.php will appear, in there they can update the games that are on the browse.php using the update games button which will read the data from the csv and add them accordingly, there is also an easter egg .php which I made using php.
