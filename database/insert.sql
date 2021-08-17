DROP TABLE IF EXISTS grades;
CREATE TABLE grades (
  id integer,
  type varchar(255),
);
INSERT INTO grades
VALUES
  (1, 'rootUser'),
  (2, 'commonUser');