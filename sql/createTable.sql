CREATE TABLE art_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    date_of_completion YEAR,
    width DECIMAL(5,2),
    height DECIMAL(5,2),
    price DECIMAL(15,2),
    description TEXT
);

