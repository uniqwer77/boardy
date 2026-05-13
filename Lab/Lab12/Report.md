![composer --version и php -m | grep -E "mbstring|xml|bcmath|curl|mysql|zip"](screenshots/01-composer-php.png)
![ls /var/www/ (видны boardy и boardy-legacy)](screenshots/02-folders.png)
![cd /var/www/boardy && php artisan --version (Laravel 11.x.x)](screenshots/03-laravel-version.png)

3. Структура Laravel
app/ - код приложения; routes/ - маршруты; resources/views/ - blade-шаблоны; database/ - содержит миграции, сидеры; public/ - единственная точка входа.
Если указать на корень, может произойти утечка секретных данных(файл .env), пользователи могут получить доступ к исходному коду.

![cat /etc/nginx/sites-available/boardy](screenshots/04-nginx-config.png)
![приветственная страница Laravel в браузере](screenshots/05-laravel-welcome.png)
Директива try_files пытается найти физический файл или папку, а если их нет - перенаправляет запрос на index.php. Без неё при заходе на /posts/3 сервер выдаст ошибку 404, так как такой папки не существует на диске.

![mysql -e "SHOW DATABASES" (видны boardy и boardy_main)](screenshots/06-databases.png)
Новая БД создаётся для чистого старта по стандартам Laravel (автоматические временные метки created_at, названия таблиц во множественном числе). В старой схеме мешает отсутствие необходимых фреймворку полей и связей.

![php artisan tinker → DB::connection()->getPdo() (объект PDO без ошибки](screenshots/07-tinker-pdo.png)
![php artisan migrate:status](screenshots/08-migrate-status.png)
![mysql -u boardy -p boardy_main -e "SHOW TABLES"](screenshots/09-show-tables.png)
![php artisan tinker с проверкой Post::first()->author (вернётся User-объект) и Post::first()->comments (Collection](screenshots/10-model-relations.png)
![tinker → User::count(), Post::count(), Comment::count()](screenshots/11-seed-counts.png)
![php artisan route:list](screenshots/12-route-list.png)
![лента /posts](screenshots/13-posts-index.png)
![/posts/3 с постом, комментариями и формой](screenshots/14-post-show.png)
![форма /posts/create](screenshots/15-post-create.png)
![страница созданного постлями](screenshots/16-post-after-create.png)
![кнопки «Редактировать» и «Удалить» под СВОИМ постом](screenshots/17-edit-own.png)

![попытка открыть /posts/X/edit чужого поста → 403 Forbidden](screenshots/18-edit-foreign-403.png)
В сравнении с Lab 10–11, использование Policy сокращает количество кода в контроллере до одной строки authorize(), так как вся логика прав доступа вынесена в отдельный класс.

![пост удалён, в ленте его нет](screenshots/19-post-deleted.png)
![комментарий после отправки виден на странице пост](screenshots/20-comment-created.png)
![страница /register](screenshots/21-register.png)
![страница /login](screenshots/22-login.png)
![состояние после регистрации](screenshots/23-after-register.png)
![страница вашего OAuth App на GitHub](screenshots/24-github-app.png)
![страница /login с кнопкой «Войти через GitHub»](screenshots/25-login-with-github.png)
![страница GitHub Authorize](screenshots/26-github-authorize.png)
![состояние после успешного OAuth-вход](screenshots/27-after-github-login.png)

![SELECT id, name, email, github_id FROM users WHERE github_id IS NOT NULL](screenshots/28-mysql-github-id.png)
В Socialite количество строк сократилось в разы по сравнению с ручной реализацией, так как фреймворк берет на себя всю работу с HTTP-запросами к API провайдера и обработку токенов.

22. Что осталось от прошлых практик
Старые файлы и БД оставлены для возможности сверки данных или отката. При попытке открыть login.php через домен Laravel, сервер выдаст 404, так как корень Nginx теперь указывает на public/, где этого файла нет.

23. FastAPI и React
На текущем этапе (Lab 12) интеграции React и FastAPI мешает отсутствие единого механизма авторизации и общих сессий между Laravel-бэкендом и сервисом на FastAPI.  
В следующей работе (Lab 13) эта архитектурная проблема будет решена следующим образом:
— Поставим Passport — Laravel становится OAuth Authorization Server.
— Перепишем FastAPI под BFF: валидация Bearer-токенов от Passport (RS256), проксирование запросов в Laravel.
— Поставим Redis, Laravel начнёт publish-ить события (под Lab14).
— Вернём React на страницу поста — комменты теперь через FastAPI с Bearer.

24. Реалтайм
Для появления комментариев без перезагрузки необходимо внедрение технологии WebSockets