# CLOCKINOUT
CLOCKINOUT is a webapp to keep track of employees. It has three main components:
- Timetable
- Keypad
- Management

## Timetable
The timetable displays at what time an employee clocks in or out

## List
The list view conviently displays which users are in or out.

## Keypad
The keypad view is the way employees interact with the system. They punch in their four digit code and then the system will either clock them in or out according to their current status. This view was developed to be accessed from an old ipad I had lying around. 

## Management
The management view allows an administrator to add users to the system

## Getting Started
CLOCKINOUT was built using bootstrap and jquery for the front end, and lumen for the backend. All required libraries are included in this repo but there are other requirements listed below that are needed to be able to run it.

### Requirements
- Composer
- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension

### Database credentials and migrations
Before you can start using this web app you will need to create a .env file in the backend folder with database credentials. There is a sample file named .evn.example; you may edit that one and rename it as .env; Make sure to add a database name, username, and password.
```
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=you_database_password
```
Once you've created the .env file you may run the migrations to create the needed tables
```
php artisan migrate
```

## Use
Once you've everything up and running you may start using the web app.
### Management - Add emlpoyees
The first thing you must do is create some users. Go to the management section and add some users.The predefined categories are volunteer, undergrad, grad, staff, and faculty. These categories are hardcoded and if you wish to change them you may do so by editing the management.html file.
The system will let you know if the user has been successfully added or if there is any error. The new user will show up on the employees list.

### Keypad - Clock In / Out
After you've successfully created a user you may now go to the Keypad view. From here you can test the four digit PIN you may have given a user. After you click enter, the system will let you know if the user clocked in, out, or if the PIN is incorrect.

### Timetable - View Employees
Once a user has clocked in a record will be created and you can see in real time which users are in or have clocked in through out the day. You may click on a user name to see a total number of hours that user has worked for the current week.
