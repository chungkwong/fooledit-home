
CREATE TABLE IF NOT EXISTS files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(31) NOT NULL,
    filename VARCHAR(191) NOT NULL,
    filesize INT UNSIGNED NOT NULL DEFAULT 0,
    mimetype VARCHAR(31) NOT NULL DEFAULT 'text/plain',
    description TEXT,
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (filename),
    FOREIGN KEY (user_id) REFERENCES users(id)
);