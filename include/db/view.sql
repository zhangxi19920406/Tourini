create view friend_circle_full_info as
select Friend.id, Friend.user_id, Friend.friend_id, User.user_name as friend_name, Circle.circle_id, Circle.circle_name, Friend.request_time, Friend.status
from User, Friend Left join Circle on Friend.circle_id = Circle.circle_id
where Friend.friend_id = User.user_id;


CREATE VIEW current_location_full_info AS
SELECT User.user_id, user_name, profile, Currentlocation.cl_id, Currentlocation.location_id, city, attraction, see_status, CurrentLocation.post_time, CurrentLocation.status
FROM User 
INNER JOIN Currentlocation ON User.user_id = Currentlocation.user_id
INNER JOIN Location ON Currentlocation.location_id = Location.location_id
WHERE status = 4 
ORDER BY CurrentLocation.post_time DESC;

CREATE VIEW photo_full_info AS
SELECT Photo.photo_id, photo, time, Photo.location_id, longitude, latitude, city, attraction, caption, post_id, User.user_id, user_name, see_status, post_time
FROM Photo
LEFT JOIN Postphoto ON Photo.photo_id = Postphoto.photo_id
LEFT JOIN User ON Postphoto.user_id = User.user_id
LEFT JOIN Location ON Photo.location_id = Location.location_id
ORDER BY post_time DESC;  

CREATE VIEW message_full_info AS
SELECT Message.message_id, text, Message.location_id, longitude, latitude, city, attraction, post_id, User.user_id, user_name, see_status, post_time
FROM Message
LEFT JOIN Postmessage ON Message.message_id = Postmessage.message_id
LEFT JOIN User ON Postmessage.user_id = User.user_id
LEFT JOIN Location ON Message.location_id = Location.location_id
ORDER BY post_time DESC ;