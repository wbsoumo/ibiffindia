-- Migration: Create site_settings table and seed default values for IBIFF India Homepage

CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(255) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type VARCHAR(50) DEFAULT 'text', -- 'text', 'textarea', 'image', 'url'
    setting_label VARCHAR(255) NOT NULL,
    setting_section VARCHAR(100) NOT NULL, -- 'Hero', 'Welcome', 'Highlights', 'Mission', 'Why Join', 'CineBridge'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Seed defaults

-- Hero Section Settings
INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_label, setting_section) VALUES
('hero_edition_tag', 'Official 2026 Edition', 'text', 'Edition Tag (Top)', 'Hero'),
('hero_title', 'IBIFF INDIA', 'text', 'Main Title', 'Hero'),
('hero_subtitle', 'Celebrating Cinematic Excellence Across Borders', 'text', 'Subtitle Under Title', 'Hero'),
('hero_bg_image', 'assets/images/hero-bg.png', 'image', 'Hero Background Image', 'Hero'),
('hero_cta_text_1', 'EXPLORE FESTIVAL', 'text', 'CTA Button 1 Text', 'Hero'),
('hero_cta_url_1', 'films.php', 'text', 'CTA Button 1 URL', 'Hero'),
('hero_cta_text_2', 'SUBMIT YOUR FILM', 'text', 'CTA Button 2 Text', 'Hero'),
('hero_cta_url_2', 'https://filmfreeway.com', 'text', 'CTA Button 2 URL', 'Hero');

-- Welcome Section Settings
INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_label, setting_section) VALUES
('welcome_tag', 'Welcome to', 'text', 'Welcome Section Tagline', 'Welcome'),
('welcome_title', 'THE INTERNATIONAL INDO-BANGLA FILM FESTIVAL IBIFF INDIA', 'textarea', 'Welcome Section Main Title', 'Welcome'),
('welcome_bullet_1', 'An internationally acclaimed platform celebrating independent cinema', 'text', 'Bullet Point 1', 'Welcome'),
('welcome_bullet_2', 'A vibrant hybrid ecosystem connecting filmmakers, cinephiles, and creators', 'text', 'Bullet Point 2', 'Welcome'),
('welcome_bullet_3', 'Diverse genres, formats, and storytelling styles encouraged', 'text', 'Bullet Point 3', 'Welcome'),
('welcome_bullet_4', 'A festival rooted in creativity, collaboration, and cultural exchange', 'text', 'Bullet Point 4', 'Welcome'),
('welcome_subheading', '8th International Indo-Bangla Film Festival (IBIFF) 2026!', 'text', 'Edition Subheading', 'Welcome'),
('welcome_text', 'The International Indo-Bangla Film Festival (IBIFF) 2024 concluded successfully, marking yet another milestone in our journey of celebrating cinema from across the globe. We now look forward to the next edition — IBIFF 2026.', 'textarea', 'Welcome Description Text', 'Welcome'),
('welcome_poster_title', 'IBIFF 2026 EDITION', 'text', 'Poster Card Title', 'Welcome'),
('welcome_poster_image', 'assets/images/poster1.jpg', 'image', 'Welcome Poster Image', 'Welcome'),
('welcome_stat_1_val', '50+', 'text', 'Stat 1 Value (e.g. 50+)', 'Welcome'),
('welcome_stat_1_lbl', 'Categories', 'text', 'Stat 1 Label', 'Welcome'),
('welcome_stat_2_val', '200+', 'text', 'Stat 2 Value (e.g. 200+)', 'Welcome'),
('welcome_stat_2_lbl', 'Selections', 'text', 'Stat 2 Label', 'Welcome');

-- Festival Highlights (IKSFF-like) Settings
INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_label, setting_section) VALUES
('highlights_dates_title', 'Festival Dates', 'text', 'Dates Box Title', 'Highlights'),
('highlights_dates_subtitle', 'This seven-day hybrid festival will be held from:', 'textarea', 'Dates Box Subtitle', 'Highlights'),
('highlights_dates_range', '18th January to 24th January, 2026', 'text', 'Dates Range Display', 'Highlights'),
('highlights_venue_title', 'Physical Venues', 'text', 'Venues Box Title', 'Highlights'),
('highlights_venue_1', 'Rabindranath Tagore Auditorium, Adamas University, Barasat', 'text', 'Venue 1 Name & Address', 'Highlights'),
('highlights_venue_2', 'Rotary Sadan, Kolkata', 'text', 'Venue 2 Name & Address', 'Highlights'),
('highlights_online_title', 'Online Festival', 'text', 'Online Stream Title', 'Highlights'),
('highlights_online_subtitle', 'Streaming on', 'text', 'Online Stream Subtitle', 'Highlights'),
('highlights_online_logo', 'https://static.wixstatic.com/media/584de3_f17a9184e1e64b9fbfdf59972cbce195~mv2.png/v1/crop/x_0,y_80,w_175,h_44/fill/w_189,h_52,al_c,lg_1,q_85,enc_avif,quality_auto/06.png', 'image', 'Online Stream Provider Logo', 'Highlights'),
('highlights_online_url', 'http://www.efilmzone.in', 'text', 'Online Stream URL', 'Highlights'),
('highlights_categories_title', 'Festival Categories', 'text', 'Categories Section Title', 'Highlights'),
('highlights_categories_list', 'Short Film, Long Short Film, Short Documentary, Music Video, PSA/Commercials', 'textarea', 'Categories List (Comma Separated)', 'Highlights');

-- Mission & Features Section Settings
INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_label, setting_section) VALUES
('mission_tag', 'Our Vision', 'text', 'Mission Section Tagline', 'Mission'),
('mission_title', 'BRIDGING CULTURES THROUGH CINEMA', 'text', 'Mission Section Title', 'Mission'),
('mission_subtitle', 'The Indo-Bangla International Film Festival (IBIFF) is dedicated to fostering creative exchange and celebrating the art of storytelling.', 'textarea', 'Mission Subtitle', 'Mission'),
('mission_text', 'Over the years, IBIFF has evolved into a trusted international platform for short films, documentaries, and experimental cinema. We bring together a diverse community of filmmakers and audiences to celebrate the power of the moving image.', 'textarea', 'Mission Long Description', 'Mission'),
('mission_image', 'assets/images/poster.jpg', 'image', 'Mission Section Image', 'Mission'),
('why_tag', 'Why Join Us?', 'text', 'Why Join Section Tagline', 'Why Join'),
('why_title', 'A PLATFORM FOR VISIONARIES', 'text', 'Why Join Section Title', 'Why Join'),
('why_subtitle', 'Join the fastest growing film festival network in the Indo-Bangla region. We offer more than just a screening; we offer a career-defining ecosystem.', 'textarea', 'Why Join Section Subtitle', 'Why Join'),
('why_item_1_title', 'Global Exposure', 'text', 'Feature 1 Title', 'Why Join'),
('why_item_1_desc', 'Reach audiences across 30+ countries.', 'text', 'Feature 1 Description', 'Why Join'),
('why_item_2_title', 'CineBridge', 'text', 'Feature 2 Title', 'Why Join'),
('why_item_2_desc', 'Direct access to industry investors.', 'text', 'Feature 2 Description', 'Why Join'),
('why_item_3_title', 'Masterclasses', 'text', 'Feature 3 Title', 'Why Join'),
('why_item_3_desc', 'Learn from award-winning directors.', 'text', 'Feature 3 Description', 'Why Join'),
('why_item_4_title', '50+ Awards', 'text', 'Feature 4 Title', 'Why Join'),
('why_item_4_desc', 'Prestigious laurels for your work.', 'text', 'Feature 4 Description', 'Why Join');

-- CineBridge Section Settings
INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_label, setting_section) VALUES
('cinebridge_tag', 'Film Marketplace', 'text', 'CineBridge Section Tagline', 'CineBridge'),
('cinebridge_title', 'CINEBRIDGE INDIA', 'text', 'CineBridge Section Title', 'CineBridge'),
('cinebridge_bg_image', 'assets/images/cinebridge-bg.png', 'image', 'CineBridge Background Image', 'CineBridge'),
('cinebridge_subtitle', 'Where creators meet collaborators. Connect with international producers, distributors, and investors to take your project to the global stage.', 'textarea', 'CineBridge Subtitle', 'CineBridge'),
('cinebridge_cta_text_1', 'JOIN AS FILMMAKER', 'text', 'CineBridge CTA Button 1 Text', 'CineBridge'),
('cinebridge_cta_url_1', 'about.php#cinebridge', 'text', 'CineBridge CTA Button 1 URL', 'CineBridge'),
('cinebridge_cta_text_2', 'JOIN AS INVESTOR', 'text', 'CineBridge CTA Button 2 Text', 'CineBridge'),
('cinebridge_cta_url_2', 'contact.php', 'text', 'CineBridge CTA Button 2 URL', 'CineBridge');
