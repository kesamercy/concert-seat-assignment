# Concert Seat Assignment Coding Challenge

Implemented a program that assigns the best seat available (closest to front and middle) at a concert venue.

# Assumptions
The venue layout which is defined by rows x columns, and the seats available are all represented in the JSON files located in the assets folder. The available seating is defined by the standard A1, A2 A3... representing the row and column respectively. The JSON files show different venue layouts that the program supports. The program supports 9 x9 venue layouts. Beyond this, behavior for the program is undefined.


The program will return an error message to indicate a seat request that can not be fulfilled. The user can only request a minimum of 1 seat and a maximum of 3 seats defined for each venue seat selection option.

For simplicity, the program does not automatically update the JSON file when a seat has been assigned to a user. The current seats available are predefined in the JSON files and do not change after a person has selected a seat.

Therefore, once a seat has been assigned, if the user returns to the home page of the program and follows their initial steps for a seat request, the same seat will be assigned to the user since the update functionality per user is unsupported in the current implementation.

The program was built with PHP as the backend and HTML/CSS for the front-end.

## Instructions for deploying and executing the tests

## Prerequisites:

#### Remote Server Access
1. With access to a remote server, clone the git repository into a directory of your choice on the server.
2. Navigate to that directory and then go to concert-seat-assignment/src/index.php to access the home-page of the application and begin a walkthrough as a user.

#### Local Server Access
1. Set up [Xampp local server](https://www.ionos.com/digitalguide/server/tools/xampp-tutorial-create-your-own-local-test-server/)
2. Clone the repository into htdocs folder found in the Xampp server directory.
3. In your browser navigate to localhost ```http://localhost/concert-seat-assignment/``` to find the home page of the application and begin a walkthrough as a user.

## Executing Tests
1. To run the tests, the project will need to be cloned onto your local server and using the terminal, navigate to the directory of the project: yourpath/htdocs/concert-seat-assignment/src/

2. run the command ```php vendor/bin/codecept run --steps``` to execute the tests.


# Design Overview
The program first parses the JSON file and stores the list of seats available based on the venue layout from each JSON file. The program also displays a layout of the venue based on the number of rows and columns for each respective venue layout. By default, seats that are unavailable will show as occupied, and seats available will show an empty seat.

The functions to determine the best available seat is in the find-seat.php file. Based on the number of seats requested by the user, the algorithm will search every seat starting from the top row (A in this case) and center (ceiling (number of columns/2)), then right to left to find a seat available.

The venue.php page shows the layout for the chosen venue and the seats available. The user has 3 options to choose what seat they want and that page redirects to the find-seat.php file where based on the request, the user is assigned a seat if available.

The file common-functions.php has functions that are used in both the venue.php and find-seat.php while processing seat requests.

function processSingleSeatRequest is responsible for finding any available seat and assigning it to the user.
function processTwoSeatRequest finds any 2 consecutive open seats and assigns them to the user.
function processThreeSeatAllocation finds any 3 consecutive open seats and assigns them to the user.

To explore the behavior of the algorithm for different seat availability, one can modify the values in the JSON files and run the program again to observe the new seat allocations.

Due to the simplicity, and abiding by minimum functionality standards for this exercise, the program is guaranteed to return correct results for the defined cases in the JSON files, for more robust edge cases with increased rows and columns in the venue layouts, the program functions might need to be modified to return more accurate results.


<a href="https://ibb.co/QvV5Vr2"><img src="https://i.ibb.co/0yLwLhg/Concert-Seats.png" raw=true alt="Concert-Seats" border="0"></a>

