-- Fix typo and set environment
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Create table `user`
CREATE TABLE `user` (
    `user_id` VARCHAR(100) PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `user`
INSERT INTO `user` (user_id, username, password, email) VALUES
('u001', 'alpha', 'abcdefgh', 'alpha@gmail.com'),
('u002', 'beta', 'ijklmnopq', 'beta@gmail.com'),
('u003', 'charlie', 'rstuvwxy', 'charlie@gmail.com');

-- Create table `toyItem`
CREATE TABLE `toyItem` (
    `item_id` VARCHAR(100) PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `brand` VARCHAR(100) NOT NULL,
    `category` VARCHAR(100) NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `toyItem`
INSERT INTO `toyItem` (item_id, name, description, brand, category) VALUES
('item001', 'Teddy Bear', 'A soft and cuddly teddy bear.', 'SnuggleToys', 'Stuffed Toys'),
('item002', 'Lego Set', 'A 500-piece building block set.', 'BrickMakers', 'Blocks'),
('item003', 'Race Car', 'A fast toy race car for kids.', 'ZoomWheels', 'Cars');

-- Create table `toyImage`
CREATE TABLE `toyImage` (
    `image_id` VARCHAR(100) PRIMARY KEY,
    `image_url` VARCHAR(100),
    `description` TEXT,
    `is_primary_image` BOOLEAN
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `toyImage`
INSERT INTO `toyImage` (image_id, image_url, description, is_primary_image) VALUES
('img001', 'http://example.com/teddy.jpg', 'Front view of teddy bear', 1),
('img002', 'http://example.com/lego.jpg', 'Box image of lego set', 1),
('img003', 'http://example.com/racecar.jpg', 'Side view of race car', 0);

-- Create table `manufacturer`
CREATE TABLE `manufacturer` (
    `manufacturer_id` VARCHAR(100) PRIMARY KEY,
    `manufacturer_name` VARCHAR(100) NOT NULL,
    `location` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `manufacturer`
INSERT INTO `manufacturer` (manufacturer_id, manufacturer_name, location) VALUES
('m001', 'SnuggleToys Inc.', 'Japan'),
('m002', 'BrickMakers Ltd.', 'Germany'),
('m003', 'ZoomWheels Corp.', 'USA');

-- Create table `supplier`
CREATE TABLE `supplier` (
    `supplier_id` VARCHAR(100) PRIMARY KEY,
    `supplier_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `supplier`
INSERT INTO `supplier` (supplier_id, supplier_name, email) VALUES
('s001', 'ToyDistributor A', 'distA@example.com'),
('s002', 'ToyWarehouse B', 'warehouseB@example.com');

-- Create table `likedBy`
CREATE TABLE `likedBy` (
    `user_id` VARCHAR(100),
    `item_id` VARCHAR(100),
    FOREIGN KEY (`user_id`) REFERENCES user(`user_id`),
    FOREIGN KEY (`item_id`) REFERENCES toyItem(`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `likedBy`
INSERT INTO `likedBy` (user_id, item_id) VALUES
('u001', 'item001'),
('u002', 'item002');

-- Create table `ownedBy`
CREATE TABLE `ownedBy` (
    `user_id` VARCHAR(100),
    `item_id` VARCHAR(100),
    FOREIGN KEY (`user_id`) REFERENCES user(`user_id`),
    FOREIGN KEY (`item_id`) REFERENCES toyItem(`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `ownedBy`
INSERT INTO `ownedBy` (user_id, item_id) VALUES
('u003', 'item001'),
('u001', 'item003');

-- Create table `commentedBy`
CREATE TABLE `commentedBy` (
    `user_id`  VARCHAR(100),
    `item_id`  VARCHAR(100),
    `date_time_of_comment` DATETIME,
    `content` TEXT,
    PRIMARY KEY (`user_id`, `item_id`, `date_time_of_comment`),
    FOREIGN KEY (`user_id`) REFERENCES user(`user_id`),
    FOREIGN KEY (`item_id`) REFERENCES toyItem(`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `commentedBy`
INSERT INTO `commentedBy` (user_id, item_id, date_time_of_comment, content) VALUES
('u001', 'item001', '2025-05-15 10:00:00', 'This teddy bear is so cute!'),
('u002', 'item002', '2025-05-15 11:30:00', 'Really fun lego set.');

-- Create table `purchasedThrough`
CREATE TABLE `purchasedThrough` (
    `item_id` VARCHAR(100),
    `supplier_id` VARCHAR(100),
    `purchase_price` DECIMAL(10,2),
    `date_ordered` DATE,
    `date_acquired` DATE,
    FOREIGN KEY (`item_id`) REFERENCES toyItem(`item_id`),
    FOREIGN KEY (`supplier_id`) REFERENCES supplier(`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `purchasedThrough`
INSERT INTO `purchasedThrough` (item_id, supplier_id, purchase_price, date_ordered, date_acquired) VALUES
('item001', 's001', 15.99, '2025-04-01', '2025-04-05'),
('item002', 's002', 35.00, '2025-04-02', '2025-04-06');

-- Create table `manufactures`
CREATE TABLE `manufactures`(
    `manufacturer_id` VARCHAR(100),
    `item_id` VARCHAR(100),
    `batch_num` VARCHAR(50),
    `manufactured_quantity` INT,
    FOREIGN KEY (`manufacturer_id`) REFERENCES manufacturer(`manufacturer_id`),
    FOREIGN KEY (`item_id`) REFERENCES toyItem(`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `manufactures`
INSERT INTO `manufactures` (manufacturer_id, item_id, batch_num, manufactured_quantity) VALUES
('m001', 'item001', 'B202504', 500),
('m002', 'item002', 'B202505', 1000);

-- Create table `provides`
CREATE TABLE `provides` (
    `manufacturer_id` VARCHAR(100),
    `supplier_id` VARCHAR(100),
    FOREIGN KEY (`manufacturer_id`) REFERENCES manufacturer(`manufacturer_id`),
    FOREIGN KEY (`supplier_id`) REFERENCES supplier(`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `provides`
INSERT INTO `provides` (manufacturer_id, supplier_id) VALUES
('m001', 's001'),
('m002', 's002');

-- Create table `has`
CREATE TABLE `has` (
    `item_id` VARCHAR(100),
    `image_id` VARCHAR(100),
    FOREIGN KEY (`item_id`) REFERENCES toyItem(`item_id`),
    FOREIGN KEY (`image_id`) REFERENCES toyImage(`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `Has`
INSERT INTO `has` (item_id, image_id) VALUES
('item001', 'img001'),
('item002', 'img002'),
('item003', 'img003');

