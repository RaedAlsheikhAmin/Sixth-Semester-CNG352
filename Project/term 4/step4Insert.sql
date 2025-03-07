INSERT INTO WishListGame VALUES ('Finals',NULL,'FPS','Base Game',12,'Epic Games', 'FIrst Person Shooting Spike Rush Game with Heros Having Special Abilities',0);
INSERT INTO WishListGame VALUES ('The Witcher 3: Wild Hunt', NULL, 'RPG', 'Open World', 18, 'Steam', 'A story-driven, open world role-playing game set in a dark fantasy universe.', 29);
INSERT INTO WishListGame VALUES ('Minecraft', NULL, 'Adventure', 'Sandbox', 7, 'Mojang', 'A game about placing blocks and going on adventures.', 20);
INSERT INTO WishListGame VALUES ('FIFA 22', NULL, 'Sports', 'Soccer', 3, 'Origin', 'The latest installment in the FIFA series, featuring updated teams and gameplay.', 60);
INSERT INTO WishListGame VALUES ('The Legend of Zelda: Breath of the Wild', NULL, 'Action-Adventure', 'Open World', 12, 'Nintendo eShop', 'An action-adventure game set in an open world environment.', 50);
INSERT INTO WishListGame VALUES ('Among Us', NULL, 'Casual', 'Social Deduction', 7, 'Steam', 'A multiplayer game where crewmates try to complete tasks while impostors try to eliminate them.', 5);

INSERT INTO Platform VALUES (1111,NULL,'XBOX');
INSERT INTO Platform VALUES (2222, NULL, 'PlayStation');
INSERT INTO Platform VALUES (3333, NULL, 'Nintendo Switch');
INSERT INTO Platform VALUES (4444, NULL, 'Android');
INSERT INTO Platform VALUES (5555, NULL, 'IOS');
INSERT INTO Platform VALUES (6666, NULL, 'PSP');

INSERT INTO Library VALUES (123, 'Letter');
INSERT INTO Library VALUES (456, 'Platform');
INSERT INTO Library VALUES (789, 'Letter');
INSERT INTO Library VALUES (012, 'Platform');
INSERT INTO Library VALUES (023, 'Letter');
INSERT INTO Library VALUES (056, 'Platform');

INSERT INTO Users VALUES (1234, 'Farnaz', 'Rezaee', 'farnazrzn', 'farnaz@gmail.com', 'farnaz123', '2001-07-22',123);
INSERT INTO Users VALUES (5678, 'Raed', 'Amin', 'raedamin', 'raed.amin@yahoo.com', 'raed456', '2001-05-25',456);
INSERT INTO Users VALUES (91011, 'Alice', 'Smith', 'alicesmith', 'alice.smith@gmail.com', '988Alic*', '1988-11-28',789);
INSERT INTO Users VALUES (121314, 'Michael', 'Johnson', 'michaelj', 'michael.j@gmail.com', 'MichJ76', '1976-09-15',012);
INSERT INTO Users VALUES (151617, 'Emily', 'Brown', 'emilyb', 'emily.b@yahoo.com', 'EBrown502', '1992-05-02',023);
INSERT INTO Users VALUES (181920, 'David', 'Wilson', 'davidw', 'david.w@gmail.com', '1218@Dwil', '2000-12-18',056);

INSERT INTO OwnedGame VALUES ('Valorant',NULL,'FPS','Base Game',12,'Epic Games', 'FIrst Person Shooting Spike Rush Game with Heros Having Special Abilities',12,1,1,'2024-05-14',123);
INSERT INTO OwnedGame VALUES ('Fortnite', NULL, 'Battle Royale', 'Action', 12, 'Epic Games', 'A battle royale game where you can build structures to defend yourself', 50, 0, 1, '2023-01-20',456);
INSERT INTO OwnedGame VALUES ('Counter-Strike: Global Offensive', NULL, 'FPS', 'Multiplayer', 16, 'Steam', 'A multiplayer first-person shooter game.', 500, 1, 1, '2022-08-12',789);
INSERT INTO OwnedGame VALUES ('Overwatch', NULL, 'FPS', 'Hero Shooter', 12, 'Blizzard', 'A team-based multiplayer hero shooter game.', 80, 1, 1, '2023-06-10',012);
INSERT INTO OwnedGame VALUES ('Red Dead Redemption 2', NULL, 'Action-Adventure', 'Open World', 18, 'Rockstar Games', 'An epic tale of life in America at the dawn of the modern age.', 120, 0, 1, '2023-09-25',023);
INSERT INTO OwnedGame VALUES ('Rocket League', NULL, 'Sports', 'Vehicular Soccer', 3, 'Epic Games', 'A high-powered hybrid of arcade-style soccer and vehicular mayhem.', 40, 1, 0, '2022-10-15',056);

INSERT INTO Feedback VALUES (1, 'Great Game', 'I really enjoyed playing this game. The graphics are amazing and the gameplay is smooth.', 5, NOW(), 1234, 'Valorant');
INSERT INTO Feedback VALUES (2, 'Needs Improvement', 'This game has potential but needs some bug fixes and balancing.', 3, NOW(), 5678, 'Fortnite');
INSERT INTO Feedback VALUES (3, 'Awesome Gameplay', 'Counter-Strike: Global Offensive is a classic. The gameplay is intense and keeps you coming back for more.', 5, NOW(), 91011, 'Counter-Strike: Global Offensive');
INSERT INTO Feedback VALUES (4, 'Fun with Friends', 'Overwatch is a blast to play with friends. The different heroes and abilities make each match unique.', 4, NOW(), 121314, 'Overwatch');
INSERT INTO Feedback VALUES (5, 'Amazing Story', 'Red Dead Redemption 2 has one of the best stories in a video game. The open world is beautifully crafted.', 5, NOW(), 151617, 'Red Dead Redemption 2');
INSERT INTO Feedback VALUES (6, 'Addictive Gameplay', 'Rocket League is so much fun. The fast-paced matches make it hard to put down.', 5, NOW(), 181920, 'Rocket League');

INSERT INTO Question VALUES (1, 'How do I unlock new agents in Valorant?', 1234);
INSERT INTO Question VALUES (2, 'What are some tips for building in Fortnite?', 5678);
INSERT INTO Question VALUES (3, 'How do I improve my aim in Counter-Strike: Global Offensive?', 91011);
INSERT INTO Question VALUES (4, 'What are the best heroes for beginners in Overwatch?', 121314);
INSERT INTO Question VALUES (5, 'How long is the main story in Red Dead Redemption 2?', 151617);
INSERT INTO Question VALUES (6, 'What are some advanced strategies in Rocket League?', 181920);

INSERT INTO Response VALUES (11, 'To unlock new agents in Valorant, you need to earn enough Valorant Points (VP) to unlock them from the in-game store.', 1234, 1);
INSERT INTO Response VALUES (22, 'In Fortnite, try to land in less populated areas at the start to gather resources and avoid early fights. Use the resources to build structures for defense later in the game.', 5678, 2);
INSERT INTO Response VALUES (33, 'To improve your aim in Counter-Strike: Global Offensive, practice aiming for headshots in deathmatch and use aim training maps to improve your reflexes.', 91011, 3);
INSERT INTO Response VALUES (44, 'For beginners in Overwatch, heroes like Soldier: 76, Mercy, and Reinhardt are good choices as they have straightforward abilities and are easy to learn.', 121314, 4);
INSERT INTO Response VALUES (55, 'The main story in Red Dead Redemption 2 can take around 50-60 hours to complete if you focus on the main missions and skip some of the side content.', 151617, 5);
INSERT INTO Response VALUES (66, 'In Rocket League, practice aerial shots and learn to use boost efficiently. Positioning and teamwork are also key to success in matches.', 181920, 6);

INSERT INTO Belongs_game_platform VALUES ('Valorant', 1111);
INSERT INTO Belongs_game_platform VALUES ('Fortnite', 2222);
INSERT INTO Belongs_game_platform VALUES ('Counter-Strike: Global Offensive', 3333);
INSERT INTO Belongs_game_platform VALUES ('Overwatch', 4444);
INSERT INTO Belongs_game_platform VALUES ('Red Dead Redemption 2', 5555);
INSERT INTO Belongs_game_platform VALUES ('Rocket League', 6666);

INSERT INTO Owns VALUES (1234, 'Valorant');
INSERT INTO Owns VALUES (5678, 'Fortnite');
INSERT INTO Owns VALUES (91011, 'Counter-Strike: Global Offensive');
INSERT INTO Owns VALUES (121314, 'Overwatch');
INSERT INTO Owns VALUES (151617, 'Red Dead Redemption 2');
INSERT INTO Owns VALUES (181920, 'Rocket League');

INSERT INTO Belongs_platform_wishlist VALUES ('Finals', 1111);
INSERT INTO Belongs_platform_wishlist VALUES ('The Witcher 3: Wild Hunt', 2222);
INSERT INTO Belongs_platform_wishlist VALUES ('Minecraft', 3333);
INSERT INTO Belongs_platform_wishlist VALUES ('FIFA 22', 4444);
INSERT INTO Belongs_platform_wishlist VALUES ('The Legend of Zelda: Breath of the Wild', 5555);
INSERT INTO Belongs_platform_wishlist VALUES ('Among Us', 6666);

INSERT INTO Friendship VALUES (1234, 5678,'Accepted');
INSERT INTO Friendship VALUES (1234, 91011,'Accepted');
INSERT INTO Friendship VALUES (5678, 91011,'Pending');
INSERT INTO Friendship VALUES (121314, 151617,'Accepted');
INSERT INTO Friendship VALUES (121314, 181920,'Pending');
INSERT INTO Friendship VALUES (151617, 181920,'Accepted');

INSERT INTO Has_wishlist VALUES (1234, 'Finals');
INSERT INTO Has_wishlist VALUES (5678, 'The Witcher 3: Wild Hunt');
INSERT INTO Has_wishlist VALUES (91011, 'Minecraft');
INSERT INTO Has_wishlist VALUES (121314, 'FIFA 22');
INSERT INTO Has_wishlist VALUES (151617, 'The Legend of Zelda: Breath of the Wild');
INSERT INTO Has_wishlist VALUES (181920, 'Among Us');