![systemctl status mysql + mysql --version](screenshots/01-mysql-status.png)

![SELECT @@character_set_database, @@collation_database;](screenshots/02-db-charset.png)
utf8 в MySQL — исторический костыль, поддерживает только 3 байта (нет эмодзи). utf8mb4 — настоящий UTF-8.
Кодировка (charset) — какие символы можно хранить. Collation — как их сравнивать и сортировать.
unicode_ci значит, что используется официальный алгоритм стандарта Unicode для сортировки, который нечувствителен к регистру.

![главная страница phpMyAdmin с базой boardy](screenshots/03-phpmyadmin.png)
![SHOW TABLES; + DESCRIBE posts;](screenshots/04-tables-cli.png)

![структура таблицы posts в phpMyAdmin (столбцы, типы, ключи)](screenshots/05-tables-pma.png)
FOREIGN KEY - это связь между таблицами, которая гарантирует, что в базе не появится «мусорных» записей с несуществующими ID.
ON DELETE CASCADE - это правило автоматической очистки: если вы удалите пользователя, база сама мгновенно удалит все его посты и комментарии.
Движок InnoDB используется потому, что только он в MySQL полноценно поддерживает эти связи (внешние ключи) и обеспечивает надежность данных при сбоях.

![содержимое schema.sql](screenshots/06-schema-sql.png)
![SELECT * FROM users; + SELECT * FROM posts;](screenshots/07-data-cli.png)
![вкладка «Обзор» таблицы posts в phpMyAdmin](screenshots/08-data-pma.png)

![результат SELECT + JOIN](screenshots/09-join.png)
JOIN используется для объединения данных из нескольких таблиц в одном запросе.
Без использования JOIN получить имя автора можно двумя отдельными запросами: сначала выбрать пост, а затем вторым запросом найти имя пользователя по полученному ID. Это медленно и создает лишнюю нагрузку на сервер.

![Foreign Key — защита целостности, ошибка (Cannot add or update a child row)](screenshots/10-fk-error.png)
![COUNT до и после DELETE](screenshots/11-cascade.png)

![SQL-инъекция результат (все пользователи)](screenshots/12-injection.png)
SQL-инъекция - это метод взлома, при котором вредоносный SQL-код внедряется в поля ввода, изменяя логику запроса к базе данных. Это происходит из-за прямой конкатенации строк, когда данные пользователя смешиваются с кодом SQL. Prepared Statements (подготовленные запросы) защищают, разделяя структуру SQL-запроса и данные, отправляя их в БД по отдельности.

![содержимое db.php](screenshots/13-db-php.png)
![submit.php через MySQL, отправка формы, «Спасибо»](screenshots/14-submit.png)
![submit.php через MySQL, новая запись в posts](screenshots/15-submit-pma.png)
![messages.php через MySQL, страница с данными из MySQL](screenshots/16-messages.png)
![curl .../api/messages (JSON из MySQL)](screenshots/17-api-messages.png)
![curl .../api/users (JSON)](screenshots/18-api-users.png)

aiomysql - асинхронный драйвер MySQL. await — не блокирует event loop при запросе к БД. Обычный mysql-connector заблокировал бы, как например time.sleep

![PR на GitHub](screenshots/19-pull-request.png)
