.open beautysaloon.db


DROP TABLE IF EXISTS master;
DROP TABLE IF EXISTS service;
DROP TABLE IF EXISTS masterspecialization;
DROP TABLE IF EXISTS schedule;
DROP TABLE IF EXISTS workinfo;
DROP TABLE IF EXISTS specialization;

PRAGMA foreign_keys=ON;

CREATE TABLE specialization (
  id INTEGER PRIMARY KEY,
  name CHAR
);

CREATE TABLE master (
  id INTEGER PRIMARY KEY,
  last_name VARCHAR(100),
  name VARCHAR(100),
  patronymic VARCHAR(100) NULL,
  DOB DATE NULL,
  phone_number VARCHAR(25) NULL,
  percent_ FLOAT,
  gender VARCHAR(1) NULL,
  dissmiss_date date NULL,
  specialization_id INTEGER,
  FOREIGN KEY (specialization_id) REFERENCES specialization (id) ON DELETE CASCADE,

  CHECK (gender = 'М' OR gender = 'Ж'),
  CHECK (percent_ >= 0.0 AND percent_ <= 100.0)
);
	
CREATE TABLE service (
  id INTEGER PRIMARY KEY,
  service_name VARCHAR,
  price FLOAT,
  lasting FLOAT
);

CREATE TABLE masterspecialization (
  id INTEGER PRIMARY KEY,
  master_id INTEGER,
  service_id INTEGER,
  
  FOREIGN KEY (master_id) REFERENCES master (id) ON DELETE CASCADE,
  FOREIGN KEY(service_id)  REFERENCES service(id) ON DELETE CASCADE
);

CREATE TABLE schedule (
  id INTEGER PRIMARY KEY,
  master_id INTEGER,
  work_date DATE,
  start_time TIME NULL DEFAULT '08:00',
  end_time TIME NULL DEFAULT '18:00',
  
  FOREIGN KEY (master_id) REFERENCES master (id) ON DELETE CASCADE
);

CREATE TABLE workinfo (
  id INTEGER PRIMARY KEY,
  master_id INTEGER,
  service_id INTEGER,
  work_date DATE,
  start_work_time TIME NULL,
  end_work_time TIME NULL,
  work_state VARCHAR(30) NULL DEFAULT 'Запись',
  client_last_name VARCHAR(100) NULL,
  client_name VARCHAR(100) NULL,
  client_patronymic VARCHAR(100) NULL,
  client_phone_number VARCHAR(25) NULL,
  
  FOREIGN KEY (master_id) REFERENCES master (id) ON DELETE CASCADE,
  FOREIGN KEY(service_id)  REFERENCES service(id) ON DELETE CASCADE,
  
  CHECK (work_state = 'В процессе' OR work_state = 'Запись' OR work_state = 'Завершено' OR work_state = 'Отмена')
);

 INSERT INTO specialization (id,name) VALUES
 (0, 'Мужской мастер'),
 (1, 'Женский мастер'),
 (2, 'Колорист'),
 (3, 'Парикмахер-универсал'),
 (4, 'специалист по плетению');


INSERT INTO master (id, last_name, name, patronymic, DOB, phone_number, percent_, gender, specialization_id) values

(0, 'Барсуков', 'Лев', 'Филиппович', '1997-02-12', '89647431028', 70,'М', 0),
(1,'Виноградова', 'София', 'Владимировна', '1995-01-23','89067135028', 65,'Ж', 1),
(2,'Беляев','Николай',  'Никитич', '1998-07-10','892797833428', 60,'М', 2),
(3,'Белова', 'Анастасия', 'Демидовна', '1999-11-17', '89567759148', 70, 'Ж', 3),
(4,'Макеев', 'Егор', 'Русланович', '1999-10-10', '89167589034', 65, 'М', 2),
(5,'Давыдова', 'Виктория', 'Михайловна', '1999-06-16','89567839028', 70,'Ж', 1),
(6,'Кузин', 'Алексадр', 'Михайлович', '1999-12-31','89627109029', 70,'М', 3),
(7,'Софронова', 'Алена', 'Андреевна','2001-06-18','89175893102', 55.5,'Ж', 4),
(8,'Яковлев', 'Максим', 'Матвеевич', '2000-02-20','89197392811', 65.5,'М', 1),
(9,'Пахомов', 'Вячеслав', 'Матвеевич', '1998-11-11','89061836289', 58, 'М', 4),
(10,'Ульянов', 'Алексей', 'Андреевич', '2000-08-15', '89277321581', 65,'М', 2);




INSERT INTO service (id, service_name, price, lasting) VALUES

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

INSERT INTO masterspecialization (id, master_id, service_id) VALUES
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


INSERT INTO schedule (id, master_id, work_date, start_time, end_time) VALUES
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



INSERT INTO workinfo (id, master_id, service_id, work_date, start_work_time, end_work_time, work_state, client_name, client_last_name, client_patronymic, client_phone_number) VALUES
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
