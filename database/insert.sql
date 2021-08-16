DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id integer,
  name varchar(255),
  age integer
);
INSERT INTO users
VALUES
  (1, 'Alice', 20),
  (2, 'Bob', 30),
  (3, 'Carol', 40);