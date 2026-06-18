<?php
require_once __DIR__ . '/../includes/config.php';

try {
    // 1. Create database and tables using the SQL file
    $sqlFile = __DIR__ . '/ibiff_india.sql';
    
    // Connect without database selected first
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO("mysql:host=" . DB_HOST . ";charset=utf8mb4", DB_USER, DB_PASS, $options);
    
    // Execute SQL file
    $sql = file_get_contents($sqlFile);
    $pdo->exec($sql);
    echo "Database schema imported successfully.\n";
    
    // Connect to the specific database now
    $pdo->exec("USE " . DB_NAME);

    // 2. Seed Films Table
    $pdo->exec("TRUNCATE TABLE films");
    $films = [
        [
            'year' => 2024,
            'title' => 'The Last Frame',
            'slug' => 'the-last-frame',
            'poster' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800',
            'director' => 'Arjun Das',
            'genre' => 'Drama',
            'duration' => '120 mins',
            'synopsis' => 'A gripping tale of a photographer discovering the truth.',
            'age_rating' => '15+',
            'rating_score' => 7.5,
            'rating_count' => '10K',
            'popularity_score' => 120,
            'writers' => 'Arjun Das, Maya Sen',
            'tagline' => 'Every picture tells a lie.'
        ],
        [
            'year' => 2024,
            'title' => 'Urban Pulse',
            'slug' => 'urban-pulse',
            'poster' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800',
            'director' => 'Sarah Jenkins',
            'genre' => 'Documentary',
            'duration' => '90 mins',
            'synopsis' => 'Exploring the hidden rhythm of the city.',
            'age_rating' => 'U',
            'rating_score' => 8.2,
            'rating_count' => '5K',
            'popularity_score' => 85,
            'writers' => 'Sarah Jenkins',
            'tagline' => 'The heartbeat of the streets.'
        ],
        [
            'year' => 2024,
            'title' => 'Silent Echoes',
            'slug' => 'silent-echoes',
            'poster' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=800',
            'director' => 'Kenji Tanaka',
            'genre' => 'Short Film',
            'duration' => '25 mins',
            'synopsis' => 'A visually stunning silent journey.',
            'age_rating' => '12+',
            'rating_score' => 9.0,
            'rating_count' => '2K',
            'popularity_score' => 45,
            'writers' => 'Kenji Tanaka',
            'tagline' => 'Silence speaks volumes.'
        ],
        [
            'year' => 2024,
            'title' => 'Neon Rhythms',
            'slug' => 'neon-rhythms',
            'poster' => 'https://images.unsplash.com/photo-1514525253361-bee8718a300a?q=80&w=800',
            'director' => 'DJ X',
            'genre' => 'Music Video',
            'duration' => '5 mins',
            'synopsis' => 'A vibrant explosion of sound and light.',
            'age_rating' => '18+',
            'rating_score' => 6.8,
            'rating_count' => '50K',
            'popularity_score' => 300,
            'writers' => 'DJ X',
            'tagline' => 'Feel the beat.'
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO films (year, title, slug, poster, director, genre, duration, synopsis, age_rating, rating_score, rating_count, popularity_score, writers, tagline) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($films as $film) {
        $stmt->execute([$film['year'], $film['title'], $film['slug'], $film['poster'], $film['director'], $film['genre'], $film['duration'], $film['synopsis'], $film['age_rating'], $film['rating_score'], $film['rating_count'], $film['popularity_score'], $film['writers'], $film['tagline']]);
    }
    echo "Films seeded successfully.\n";

    // 3. Seed Gallery Table
    $pdo->exec("TRUNCATE TABLE gallery");
    $gallery = [
        ['year' => 2024, 'title' => 'Award Ceremony', 'image' => 'https://images.unsplash.com/photo-1514525253361-bee8718a300a?q=80&w=800'],
        ['year' => 2024, 'title' => 'Red Carpet Moments', 'image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=800'],
        ['year' => 2024, 'title' => 'Director Talk', 'image' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=800'],
        ['year' => 2024, 'title' => 'Panel Discussion', 'image' => 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=800'],
        ['year' => 2024, 'title' => 'Film Screening', 'image' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=800'],
        ['year' => 2024, 'title' => 'Closing Ceremony', 'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?q=80&w=800']
    ];
    $stmt = $pdo->prepare("INSERT INTO gallery (year, title, image) VALUES (?, ?, ?)");
    foreach ($gallery as $img) {
        $stmt->execute([$img['year'], $img['title'], $img['image']]);
    }
    echo "Gallery seeded successfully.\n";
    
    // 4. Seed Festival Schedule
    $pdo->exec("TRUNCATE TABLE festival_schedule");
    $schedule = [
        ['event_date' => '2024-11-15', 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'title' => 'Opening Ceremony', 'venue' => 'Main Hall', 'hall' => 'Hall A', 'description' => 'Kickoff event for the festival.'],
        ['event_date' => '2024-11-15', 'start_time' => '13:00:00', 'end_time' => '15:00:00', 'title' => 'Screening: The Last Frame', 'venue' => 'Cinema 1', 'hall' => 'Hall B', 'description' => 'Premiere screening followed by Q&A.'],
        ['event_date' => '2024-11-16', 'start_time' => '11:00:00', 'end_time' => '12:30:00', 'title' => 'Masterclass: Cinematography', 'venue' => 'Workshop Room', 'hall' => 'Room 101', 'description' => 'Learn from industry experts.'],
        ['event_date' => '2024-11-16', 'start_time' => '18:00:00', 'end_time' => '20:00:00', 'title' => 'Awards Gala', 'venue' => 'Main Hall', 'hall' => 'Hall A', 'description' => 'The grand finale and awards distribution.']
    ];
    $stmt = $pdo->prepare("INSERT INTO festival_schedule (event_date, start_time, end_time, title, venue, hall, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($schedule as $evt) {
        $stmt->execute([$evt['event_date'], $evt['start_time'], $evt['end_time'], $evt['title'], $evt['venue'], $evt['hall'], $evt['description']]);
    }
    echo "Festival Schedule seeded successfully.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
