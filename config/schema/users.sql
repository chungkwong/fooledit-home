
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    provider VARCHAR(31) DEFAULT 'fooledit',
    username VARCHAR(63) NOT NULL,
    access_token VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    created DATETIME,
    modified DATETIME,
    UNIQUE (provider,username)
);

CREATE TABLE IF NOT EXISTS permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT REFERENCES users(id),
    allow VARCHAR(31)
);