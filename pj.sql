CREATE DATABASE study_notes_clone;

USE study_notes_clone;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Notes Table
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    file_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- -- Transactions Table
-- CREATE TABLE transactions (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     note_id INT,
--     buyer_id INT,
--     seller_id INT,
--     amount DECIMAL(10, 2),
--     transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (note_id) REFERENCES notes(id),
--     FOREIGN KEY (buyer_id) REFERENCES users(id),
--     FOREIGN KEY (seller_id) REFERENCES users(id)
-- );
