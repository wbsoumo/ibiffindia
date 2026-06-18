-- Run this SQL script in your MySQL / phpMyAdmin interface to update the `films` table with the new IMDb-style fields without losing existing data.

ALTER TABLE films 
ADD COLUMN age_rating VARCHAR(50) AFTER festival_status,
ADD COLUMN rating_score DECIMAL(3,1) AFTER age_rating,
ADD COLUMN rating_count VARCHAR(50) AFTER rating_score,
ADD COLUMN popularity_score INT AFTER rating_count,
ADD COLUMN writers VARCHAR(255) AFTER popularity_score,
ADD COLUMN tagline VARCHAR(255) AFTER writers;
