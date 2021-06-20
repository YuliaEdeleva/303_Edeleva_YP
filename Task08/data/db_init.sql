.open beautysaloon.db

DROP TABLE IF EXISTS employee;
DROP TABLE IF EXISTS service;
DROP TABLE IF EXISTS employee_specialization;
DROP TABLE IF EXISTS work_schedule;
DROP TABLE IF EXISTS work_track;

PRAGMA foreign_keys=ON;

CREATE TABLE employee (
  id INTEGER PRIMARY KEY,
  last_name VARCHAR(100),
  name VARCHAR(100),
  second_name VARCHAR(100) NULL,
  birth_date DATE NULL,
  phone_number VARCHAR(25) NULL,
  cost_percent FLOAT,
  gender VARCHAR(1) NULL,
  dissmiss_date date NULL,

  CHECK (gender = 'М' OR gender = 'Ж'),
  CHECK (cost_percent >= 0.0 AND cost_percent <= 100.0)
);
	
CREATE TABLE service (
  id INTEGER PRIMARY KEY,
  name VARCHAR,
  price FLOAT,
  duration_hour FLOAT
);

CREATE TABLE employee_specialization (
  id INTEGER PRIMARY KEY,
  id_employee INTEGER,
  id_service INTEGER,
  
  FOREIGN KEY (id_employee) REFERENCES employee (id),
  FOREIGN KEY(id_service)  REFERENCES service(id)
);

CREATE TABLE work_schedule (
  id INTEGER PRIMARY KEY,
  id_employee INTEGER,
  work_date DATE,
  start_time TIME NULL DEFAULT '08:00',
  end_time TIME NULL DEFAULT '18:00',
  
  FOREIGN KEY (id_employee) REFERENCES employee (id)
);

CREATE TABLE work_track (
  id INTEGER PRIMARY KEY,
  id_employee INTEGER,
  id_service INTEGER,
  work_date DATE,
  start_work_time TIME NULL,
  end_work_time TIME NULL,
  work_state VARCHAR(30) NULL DEFAULT 'Запись',
  client_last_name VARCHAR(100) NULL,
  client_name VARCHAR(100) NULL,
  client_second_name VARCHAR(100) NULL,
  client_phone_number VARCHAR(25) NULL,
  
  FOREIGN KEY (id_employee) REFERENCES employee (id),
  FOREIGN KEY(id_service)  REFERENCES service(id),
  
  CHECK (work_state = 'В работе' OR work_state = 'Запись' OR work_state = 'Завершено' OR work_state = 'Отмена')
);

INSERT INTO employee (id, last_name, name, second_name, birth_date, phone_number, cost_percent, gender) values
(0, 'Барсуков', 'Лев', 'Филиппович', '1997-02-12', '89647431028', 70,'М'),
(1,'Виноградова', 'София', 'Владимировна', '1995-01-23','89067135028', 65,'Ж'),
(2,'Беляев','Николай',  'Никитич', '1998-07-10','892797833428', 60,'М'),
(3,'Белова', 'Анастасия', 'Демидовна', '1999-11-17', '89567759148', 70, 'Ж'),
(4,'Макеев', 'Егор', 'Русланович', '1999-10-10', '89167589034', 65, 'М'),
(5,'Давыдова', 'Виктория', 'Михайловна', '1999-06-16','89567839028', 70,'Ж'),
(6,'Кузин', 'Алексадр', 'Михайлович', '1999-12-31','89627109029', 70,'М'),
(7,'Софронова', 'Алена', 'Андреевна','2001-06-18','89175893102', 55.5,'Ж'),
(8,'Яковлев', 'Максим', 'Матвеевич', '2000-02-20','89197392811', 65.5,'М'),
(9,'Пахомов', 'Вячеслав', 'Матвеевич', '1998-11-11','89061836289', 58, 'М'),
(10,'Ульянов', 'Алексей', 'Андреевич', '2000-08-15', '89277321581', 65,'М');

INSERT INTO service (id, name, price, duration_hour) VALUES
(0, 'Окрашиание средняя длина', 120 , 2000),
(1, 'Мелирование средняя длина', 180 , 2500),
(2, 'Омбре средняя длина', 60, 1500),
(3, 'Стрижка каре', 30 , 500),
(4, 'Стрижка каскад',40 , 700),
(5, 'Стрижка боб', 35 , 400),
(6, 'Стрижка пикси', 30 , 400),
(7, 'Стрижка полубокс', 35 , 400),
(8, 'Стрижка бокс', 30 , 450),
(9, 'Андекарт', 35 , 400),
(10, 'Оформление бороды и усов', 30 , 400);

INSERT INTO employee_specialization (id, id_employee, id_service) VALUES
(0, 0, 5),
(1, 0, 6),
(2, 1, 1),
(3, 1, 5),
(4, 1, 6),
(5, 2, 0),
(6, 2, 3),
(7, 3, 1),
(8, 3, 6),
(9, 4, 1),
(10, 4, 5),
(11, 4, 6),
(12, 5, 2),
(13, 5, 3),
(14, 5, 7),
(15, 6, 4),
(16, 6, 1),
(17, 7, 8),
(18, 7, 9),
(19, 8, 10),
(20, 8, 3),
(21, 9, 4),
(22, 10, 1),
(23, 10, 6);

INSERT INTO work_schedule (id, id_employee, work_date, start_time, end_time) VALUES
(0, 0, '2021-04-05', '08:00', '14:00'),
(1, 2, '2021-04-05', '09:00', '19:00'),
(2, 4, '2021-04-05', '14:00', '20:00'),
(3, 5, '2021-04-05', '10:00', '14:00'),
(4, 6, '2021-04-05', '13:00', '17:00'),
(5, 8, '2021-04-05', '08:00', '13:00'),
(6, 9, '2021-04-05', '08:00', '18:00'),

(7, 1, '2021-04-06', '09:00', '13:00'),
(8, 3, '2021-04-06', '07:00', '17:00'),
(9, 4, '2021-04-06', '11:00', '18:00'),
(10, 5, '2021-04-06', '09:00', '19:00'),
(11, 7, '2021-04-06', '12:00', '18:00'),
(12, 8, '2021-04-06', '08:00', '13:00'),
(13, 10, '2021-04-06', '08:00', '18:00'),

(14, 0, '2021-04-07', '10:00', '13:00'),
(15, 2, '2021-04-07', '08:00', '12:00'),
(16, 4, '2021-04-07', '12:00', '19:00'),
(17, 5, '2021-04-07', '08:00', '11:00'),
(18, 6, '2021-04-07', '12:00', '18:00'),
(19, 8, '2021-04-07', '11:00', '16:00');

INSERT INTO work_track (id, id_employee, id_service, work_date, start_work_time, end_work_time, work_state, client_name, client_last_name, client_second_name, client_phone_number) VALUES
(1, 8, 3, '2021-04-06', '11:00', '13:00', 'Запись', 'Алексеев', 'Николай', 'Викторович', '89631450430'),
(2, 0, 5, '2021-04-05', '08:00', '08:30', 'Отмена', 'Наумова', 'Лилия', 'Павловна', '89174465483'),
(3, 3, 1, '2021-04-06', '09:00', '10:00', 'Завершено', 'Зеленский', 'Владимир', 'Александрович', '89134556722'),
(4, 4, 5, '2021-04-05', '12:00', '12:30', 'Завершено', 'Уткина', 'Карина', 'Эдуардовна', '89510573444'),
(5, 6, 4, '2021-05-07', '14:00', '15:00', 'Завершено', 'Миролюбов', 'Олег', 'Демидович', '89172263389'),
(6, 9, 4, '2021-06-05', '10:00', '11:00', 'Отмена', 'Утин', 'Владимир', 'Владимирович', '89276943515'),
(7, 5, 7, '2021-04-06', '14:00', '15:00', 'Завершено', 'Махачкян', 'Эрамид', NULL, '89524553672'),
(8, 2, 3, '2021-04-05', '11:00', '13:00', 'Завершено', 'Микола', 'Адель', 'Салаватович', '89157726354'),
(9, 4, 1, '2021-04-05', '13:00', '14:00', 'Завершено', 'Ныркова', 'Диана', 'Евгеньевна', '89150073608'),
(10, 3, 1, '2021-06-01', '12:00', '13:00', 'Запись', 'Демидович', 'Борис', 'Павлович', '89630473607'),
(11, 7, 8, '2021-04-06', '12:00', '13:00', 'Отмена', 'Коши', 'Огнюстен Луи', NULL, '89625134492'),
(12, 10, 6, '2021-04-06', '17:00', '18:00', 'Завершено', 'Арнольд', 'Владимир', 'Игоревич', '89271354672'),
(13, 0, 5, '2021-04-07', '09:30', '10:00', 'Отмена', 'Ковалевская', 'София', 'Васильевна', '89992361125'),
(14, 1, 1, '2021-06-06', '08:00', '09:00', 'Запись', 'Игайкина', 'Ирина', 'Николаевна', '89941627187');
