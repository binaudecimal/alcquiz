CREATE TABLE users(
  user_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
  first varchar(255) not null,
  last varchar(255) not null,
  username varchar(255) not null UNIQUE,
  password varchar(255) not null,
  type varchar(20) not null
);

CREATE TABLE questions(
    question_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    question varchar(255) not null,
    region varchar(25) not null,
    answer_correct varchar(255) not null,
    answer_wrong1 varchar(255) not null,
    answer_wrong2 varchar(255) not null,
    answer_wrong3 varchar(255) not null,
    active_status boolean
);

CREATE TABLE quiz_instance(
	qinstance_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    date_activated datetime,
    date_finished datetime,
    items int(5) not null,
    duration int(5) not null,
    user_id int(11) not null,
    region varchar(25),
    total_score float(10),
    FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE answer_instance(
	ainstance_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    user_id int(11) not null,
    question_id int(11) not null,
    qinstance_id int(11) not null,
    weighted_score float(10),
    FOREIGN KEY(user_id) REFERENCES users(user_id),
    FOREIGN KEY(question_id) REFERENCES questions(question_id),
    FOREIGN KEY(qinstance_id) REFERENCES quiz_instance(qinstance_id)
);
