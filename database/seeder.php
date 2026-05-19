<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$config = require __DIR__ . '/../config/config.php';
$db     = $config['db'];

$pdo = new PDO(
    "mysql:host={$db['host']};port={$db['port']};dbname={$db['name']};charset=utf8mb4",
    $db['user'],
    $db['password'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Очищаем
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE article_categories');
$pdo->exec('TRUNCATE TABLE articles');
$pdo->exec('TRUNCATE TABLE categories');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

// Категории
$categories = [
    ['Технологии',   'Статьи о разработке, IT и современных технологиях'],
    ['Наука',        'Научные открытия, исследования и эксперименты'],
    ['Дизайн',       'UI/UX, графика, типографика и визуальные тренды'],
];

$stmtCat = $pdo->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
foreach ($categories as $cat) {
    $stmtCat->execute($cat);
}

// Статьи
$articles = [
    // Технологии (category_id = 1)
    ['PHP 8.3: что нового',             'Обзор новых фич и улучшений в PHP 8.3',                  1],
    ['Docker для разработчиков',         'Как настроить окружение с Docker Compose',               1],
    ['Git: продвинутые техники',         'Rebase, cherry-pick и работа с историей',                1],
    ['REST API на чистом PHP',           'Строим API без фреймворков с нуля',                      1],
    ['PostgreSQL vs MySQL',              'Сравниваем две популярные СУБД',                         1],
    ['CI/CD с GitHub Actions',           'Автоматизируем деплой за 30 минут',                      1],
    ['Smarty 5: шаблоны в PHP',          'Используем Smarty как движок шаблонов',                  1],
    ['PDO и подготовленные запросы',     'Безопасная работа с базой данных',                       1],
    ['SCSS в 2024 году',                 'Стоит ли ещё использовать препроцессоры',                1],

    // Наука (category_id = 2)
    ['Квантовые компьютеры сегодня',     'Где мы находимся и что нас ждёт',                        2],
    ['CRISPR: редактирование генома',    'Как работает технология и её последствия',               2],
    ['Тёмная материя: новые данные',     'Последние открытия астрофизиков',                        2],
    ['Мозг и искусственный интеллект',   'Чем отличается нейросеть от нейрона',                    2],
    ['Климат и наука',                   'Что говорят учёные об изменении климата',                2],
    ['Марс: итоги экспедиций',           'Что мы узнали от марсоходов за 10 лет',                  2],
    ['Вакцины нового поколения',         'мРНК-технология и её перспективы',                       2],

    // Дизайн (category_id = 3)
    ['Минимализм в UI 2024',             'Тренды минималистичного интерфейса',                     3],
    ['Типографика для веба',             'Как подобрать шрифты и размеры',                         3],
    ['Цветовые схемы в продуктах',       'Теория цвета для дизайнеров интерфейсов',                3],
    ['Figma против Sketch',              'Сравниваем инструменты для UI-дизайна',                  3],
    ['Анимация в интерфейсах',           'Когда анимация помогает, а когда мешает',                3],
    ['Адаптивная вёрстка в 2024',        'Подходы к мобильной адаптации',                          3],
];

$image   = '/assets/img/placeholder.svg';

$stmtArt = $pdo->prepare(
    'INSERT INTO articles (title, description, text, image, views, created_at) VALUES (?, ?, ?, ?, ?, ?)'
);
$stmtRel = $pdo->prepare(
    'INSERT INTO article_categories (article_id, category_id) VALUES (?, ?)'
);

foreach ($articles as $i => [$title, $desc, $catId]) {
    $text      = "<p>{$desc}. Подробный разбор темы с примерами и объяснениями.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>";
    $views     = random_int(10, 500);
    $createdAt = date('Y-m-d H:i:s', strtotime("-{$i} days"));

    $stmtArt->execute([$title, $desc, $text, $image, $views, $createdAt]);
    $articleId = (int) $pdo->lastInsertId();
    $stmtRel->execute([$articleId, $catId]);
}

echo "Сидер выполнен: " . count($categories) . " категории, " . count($articles) . " статей.\n";
