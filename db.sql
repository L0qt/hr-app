CREATE DATABASE hr_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hr_db;

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) not NULL,
    birth_date DATE not NULL,
    passport VARCHAR(11) not NULL,
    phone VARCHAR(20) not NULL,
    address VARCHAR(255) not NULL,
    department VARCHAR(100) not NULL,
    position VARCHAR(100) not NULL,
    salary DECIMAL(12,2) not NULL,
    hire_date DATE not NULL,
    is_fired TINYINT(1) not NULL DEFAULT 0
);

INSERT INTO employees (full_name, birth_date, passport, phone, address, department, position, salary, hire_date)
VALUES
('Иванов Иван Иванович', '1990-05-14', '4512 345678', '+7 (912) 345-67-89', 'г. Москва, ул. Ленина, д. 1', 'IT', 'Разработчик', 120000, '2021-03-01'),
('Петрова Анна Сергеевна', '1988-11-22', '4513 654321', '+7 (903) 111-22-33', 'г. Москва, ул. Пушкина, д. 10', 'HR', 'HR-специалист', 80000, '2020-07-15'),
('Сидоров Пётр Алексеевич', '1995-02-08', '4514 112233', '+7 (925) 999-88-77', 'г. Санкт-Петербург, пр. Мира, д. 5', 'Отдел продаж', 'Менеджер', 90000, '2022-09-12');
