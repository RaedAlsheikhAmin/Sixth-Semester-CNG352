DELETE FROM Friendship
WHERE (UserID1 = 1234 AND UserID2 = 5678)
   OR (UserID1 = 5678 AND UserID2 = 1234);
   
UPDATE WishListGame
SET Price = 32
WHERE Name = 'FIFA 22';

DELETE FROM Has_wishlist
WHERE userid = 121314 AND Name = 'FIFA 22';

UPDATE OwnedGame
SET HoursPlayed = 40, isFavorite = 0, isInstalled = 0
WHERE Name = 'Valorant';

DELETE FROM Owns
WHERE userid = 1234 AND Name = 'Valorant';

UPDATE Question
SET Textt = 'How do I BUY the new agent Glove in Valorant?'
WHERE QID = 1;

DELETE FROM Response
WHERE Belongs_QID = 1;
DELETE FROM Question
WHERE QID = 1;

UPDATE Response
SET Textt = 'To BUY the new agent Glove in Valorant, you need to wait for the event to finish and after 11 days you can buy it with Valorant Points.'
WHERE ResponseID = 11;

DELETE FROM Response
WHERE ResponseID = 11;


SELECT Users.UserID, Users.Fname, Users.Lname
FROM Friendship
JOIN Users ON (Friendship.UserID1 = Users.UserID OR Friendship.UserID2 = Users.UserID)
WHERE (Friendship.UserID1 = 1234 OR Friendship.UserID2 = 1234)
AND Users.UserID != 1234;


SELECT *
FROM Users
WHERE Fname = 'Raed';


SELECT Users.UserID, Users.Fname, Users.Lname
FROM Friendship
JOIN Users ON Friendship.UserID2 = Users.UserID
WHERE Friendship.UserID1 = 5678
AND Friendship.Status = 'Pending';


SELECT * FROM OwnedGame 
WHERE Stored_LibraryID = (SELECT Manage_LibraryID FROM Users WHERE UserID = 1234);


SELECT * FROM OwnedGame 
WHERE isInstalled = 1 AND Stored_LibraryID = (SELECT Manage_LibraryID FROM Users WHERE UserID = 1234);


SELECT * FROM OwnedGame 
WHERE Typee = 'FPS' AND Stored_LibraryID = (SELECT Manage_LibraryID FROM Users WHERE UserID = 1234);


SELECT * FROM OwnedGame 
WHERE isFavorite = 1 AND Stored_LibraryID = (SELECT Manage_LibraryID FROM Users WHERE UserID = 1234);


SELECT * FROM OwnedGame 
WHERE Genre = 'Adventure' AND Stored_LibraryID = (SELECT Manage_LibraryID FROM Users WHERE UserID = 1234);


SELECT * FROM OwnedGame 
WHERE Age_rating = 12 AND Stored_LibraryID = (SELECT Manage_LibraryID FROM Users WHERE UserID = 1234);


SELECT Platform.Name AS PlatformName, GROUP_CONCAT(OwnedGame.Name) AS OwnedGames, GROUP_CONCAT(WishListGame.Name) AS WishListGames
FROM Platform
LEFT JOIN Belongs_game_platform ON Platform.PlatformID = Belongs_game_platform.PlatformID
LEFT JOIN OwnedGame ON Belongs_game_platform.Name = OwnedGame.Name
LEFT JOIN Belongs_platform_wishlist ON Platform.PlatformID = Belongs_platform_wishlist.PlatformID
LEFT JOIN WishListGame ON Belongs_platform_wishlist.Name = WishListGame.Name
GROUP BY PlatformName;


SELECT WishListGame.*
FROM Has_wishlist
JOIN WishListGame ON Has_wishlist.Name = WishListGame.Name
WHERE Has_wishlist.userid = 1234;


SELECT WishListGame.*
FROM Has_wishlist
JOIN WishListGame ON Has_wishlist.Name = WishListGame.Name
WHERE Has_wishlist.userid = 1234
ORDER BY WishListGame.Price
LIMIT 1;


SELECT FeedbackID AS ID, Title AS Text, Comments AS Detail, Rating AS Score, time_stamp AS Timestamp
FROM Feedback
WHERE userid = 1234
UNION ALL
SELECT QID AS ID, Textt AS Text, NULL AS Detail, NULL AS Score, NULL AS Timestamp
FROM Question
WHERE userid = 1234
UNION ALL
SELECT ResponseID AS ID, Textt AS Text, NULL AS Detail, NULL AS Score, NULL AS Timestamp
FROM Response
WHERE userid = 1234;




