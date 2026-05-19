<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:'BBlog'}</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="/" class="header__logo">BBlog</a>
        </div>
    </header>

    <main class="main">
        <div class="container">
            {block name="content"}{/block}
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {$smarty.now|date_format:"%Y"} BBlog</p>
        </div>
    </footer>
</body>
</html>
