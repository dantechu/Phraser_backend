-- Create regions table
CREATE TABLE IF NOT EXISTS `tbl_regions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `region_name` varchar(255) NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `region_name` (`region_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create phraser-region junction table
CREATE TABLE IF NOT EXISTS `tbl_phraser_regions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `phraser_id` int(11) NOT NULL,
    `region_id` int(11) NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `phraser_id` (`phraser_id`),
    KEY `region_id` (`region_id`),
    UNIQUE KEY `unique_phraser_region` (`phraser_id`, `region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default regions
INSERT INTO `tbl_regions` (`region_name`) VALUES
('Eastern'),
('Western');