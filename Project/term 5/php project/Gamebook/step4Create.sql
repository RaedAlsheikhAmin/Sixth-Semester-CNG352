-- Creating cng443user account with password 1234
--

CREATE USER IF NOT EXISTS 'cng352user'@'localhost' IDENTIFIED BY '1234';


--
-- Creating Exam Database
--

CREATE DATABASE IF NOT EXISTS `Gamebook`;

--
-- Granting privileges to cng443user
--
GRANT ALL PRIVILEGES ON `Gamebook`.* TO 'cng352user'@'localhost';


--
-- Use this database to create the tables
--
USE `Gamebook`;




CREATE TABLE WishListGame(
Name CHAR(50) NOT NULL,
Icon BLOB DEFAULT NULL,
Typee CHAR(50) NOT NULL,
Genre CHAR(50) NOT NULL,
Age_rating INT NOT NULL CHECK (Age_rating IN (3, 7, 12, 16, 18)),
Store CHAR(50) NOT NULL,
Description TEXT NOT NULL,
Price INT NOT NULL,
PRIMARY KEY (Name));


CREATE TABLE Platform(
PlatformID INT NOT NULL,
Icon BLOB DEFAULT NULL,
Name CHAR(50) NOT NULL,
PRIMARY KEY (PlatformID));


CREATE TABLE Library(
LibraryID INT NOT NULL,
Sorting_Type CHAR(50) NOT NULL,
PRIMARY KEY (LibraryID));

 
CREATE TABLE Users(
UserID INT NOT NULL,
Fname CHAR(20) NOT NULL,
Lname CHAR(20) NOT NULL,
UserName CHAR(20) NOT NULL,
Email CHAR(50) NOT NULL,
Password char(10)NOT NULL,
DOB DATE NOT NULL,
Manage_LibraryID INT NOT NULL,
PRIMARY KEY (UserID),
FOREIGN KEY (Manage_LibraryID) REFERENCES Library (LibraryID));


CREATE TABLE OwnedGame(
Name CHAR(50) NOT NULL,
Icon BLOB DEFAULT NULL,
Typee CHAR(50) NOT NULL,
Genre CHAR(50) NOT NULL,
Age_rating INT NOT NULL CHECK (Age_rating IN (3, 7, 12, 16, 18)),
Store CHAR(50) NOT NULL,
Description TEXT NOT NULL,
HoursPlayed INT DEFAULT 0 NOT NULL,
isFavorite INT DEFAULT 0 CHECK (isFavorite IN (0,1)),
isInstalled INT NOT NULL CHECK (isInstalled IN (0,1)),
DateAdded DATE NOT NULL,
Stored_LibraryID INT NOT NULL,
PRIMARY KEY (Name),
FOREIGN KEY (Stored_LibraryID) REFERENCES Library (LibraryID));


CREATE TABLE Feedback(
FeedbackID INT NOT NULL,
Title CHAR(20) NOT NULL,
Comments TEXT NOT NULL,
Rating INT NOT NULL CHECK (Rating IN (0,1,2,3,4,5)),
time_stamp TIMESTAMP NOT NULL,
userid INT NOT NULL,
About_name CHAR(50) NOT NULL,
PRIMARY KEY (FeedbackID),
FOREIGN KEY (userid) REFERENCES Users(UserID),
FOREIGN KEY (About_name) REFERENCES OwnedGame(Name));


CREATE TABLE Question(
QID INT NOT NULL,
Textt TEXT NOT NULL,
userid INT NOT NULL,
PRIMARY KEY (QID),
FOREIGN KEY (userid) REFERENCES Users(UserID));


CREATE TABLE Response(
ResponseID INT NOT NULL,
Textt TEXT NOT NULL,
userid INT NOT NULL,
Belongs_QID INT NOT NULL,
PRIMARY KEY (ResponseID),
FOREIGN KEY (userid) REFERENCES Users(UserID),
FOREIGN KEY (Belongs_QID) REFERENCES Question(QID));


CREATE TABLE Belongs_game_platform(
Name CHAR(50) NOT NULL,
PlatformID INT NOT NULL,
PRIMARY KEY (Name,PlatformID),
FOREIGN KEY (Name) REFERENCES OwnedGame(Name),
FOREIGN KEY (PlatformID) REFERENCES Platform(PlatformID));


CREATE TABLE Owns(
userid INT NOT NULL,
Name CHAR(50) NOT NULL,
PRIMARY KEY (userid,Name),
FOREIGN KEY (userid) REFERENCES Users(UserID),
FOREIGN KEY (Name) REFERENCES OwnedGame(Name));


CREATE TABLE Belongs_platform_wishlist(
Name CHAR(50) NOT NULL,
PlatformID INT NOT NULL,
PRIMARY KEY (Name,PlatformID),
FOREIGN KEY (Name) REFERENCES WishListGame(Name),
FOREIGN KEY (PlatformID) REFERENCES Platform(PlatformID));


CREATE TABLE Friendship(
UserID1 INT NOT NULL,
UserID2 INT NOT NULL,
Status CHAR(50) DEFAULT 'Pending' NOT NULL CHECK (Status IN ('Pending','Accepted')),
PRIMARY KEY (UserID1, UserID2),
FOREIGN KEY (UserID1) REFERENCES Users(UserID),
FOREIGN KEY (UserID2) REFERENCES Users(UserID));


CREATE TABLE Has_wishlist(
userid INT NOT NULL,
Name CHAR(50) NOT NULL,
PRIMARY KEY (userid,Name),
FOREIGN KEY (userid) REFERENCES Users(UserID),
FOREIGN KEY (Name) REFERENCES WishListGame(Name));