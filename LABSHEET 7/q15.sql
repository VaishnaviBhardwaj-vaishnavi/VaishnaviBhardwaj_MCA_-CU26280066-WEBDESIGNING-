CREATE TABLE reviews (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    book_id INT NOT NULL,

    rating INT NOT NULL,

    comment TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id),

    FOREIGN KEY (book_id) REFERENCES books(id),

    UNIQUE KEY unique_review (user_id, book_id),

    CHECK (rating BETWEEN 1 AND 5)

);
