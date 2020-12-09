-- ЗАДАЧА #2 (SQL ЗАПРОСЫ)
SELECT * FROM users
        INNER JOIN objects
ON objects.id = users.object_id;