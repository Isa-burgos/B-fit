CREATE TABLE users(  
    user_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    profile_picture VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at DATETIME NOT NULL,
    last_login DATETIME DEFAULT NULL
);

USE burgos_bfit;
CREATE TABLE training_programs(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT(500),
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    user_id INT NOT NULL, 
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE sessions(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    duration INT NOT NULL,
    completed BOOLEAN,
    completed_at TIMESTAMP,
    training_programs_id INT NOT NULL,
    FOREIGN KEY (training_programs_id) REFERENCES training_programs(id)
);

CREATE TABLE exercises(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255)
);

USE burgos_bfit

CREATE TABLE sessions_execises(
    sessions_id INT NOT NULL,
    exercises_id INT NOT NULL,
    repetitions INT(2) NOT NULL,
    duration INT NOT NULL,
    FOREIGN KEY (sessions_id) REFERENCES sessions(id),
    FOREIGN KEY (exercises_id) REFERENCES exercises(id),
    PRIMARY KEY (sessions_id, exercises_id)
);