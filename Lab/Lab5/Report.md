![вывод certbot --version](screenshots/01-certbot-installed.png)
![вывод certbot (Successfully received certificate)](screenshots/02-certbot-success.png)
![браузер с замочком (домен виден в адресной строке)](screenshots/03-browser-lock.png)
![информация о сертификате (кому, кто выдал, срок)](screenshots/04-certificate-info.png)
![вывод curl -v с 301](screenshots/05-redirect.png)
![Конфиг после certbot с подписями](screenshots/06-nginx-ssl-config.png)
![Успешное получение сертификата для api-поддомена](screenshots/07-api-certbot.png)
![Проверка обоих доменов оба ответа 200 с заголовками](screenshots/08-both-https.png)

![TLS handshake вывод с подписями](screenshots/09-tls-handshake.png)
версию: TLS TLSv1.3
алгоритм шифрования: TLS_AES_256_GCM_SHA384
subject: CN=tlop.ai-info.ru
issuer: C=US; O=Let's Encrypt; CN=R13
срок действия: start date: Mar 18 09:20:36 2026 GMT expire date: Jun 16 09:20:35 2026 GMT

![вывод openssl](screenshots/10-chain.png)
Цепочка доверия:
tlop.ai-info.ru → промежуточный Let's Encrypt R13 → корневой ISRG Root X1 (Internet Security Research Group)
Браузер получает от сервера сертификат сайта и промежуточные сертификаты, затем выстраивает цепочку до доверенного корневого сертификата из своего хранилища. Далее он последовательно проверяет цифровые подписи каждого сертификата в цепочке с использованием открытого ключа следующего сертификата, а также контролирует срок действия и соответствие имени домена.

![вывод сертификатов для обоих доменов](screenshots/11-compare-certs.png)
Сравнение сертификатов 
Общее: издатель(issuer), срок действия, алгоритм и тип
Различия: Common Name(CN) tlop.ai-info.ru и api.tlop.ai-info.ru, точные даты начала и окончания
Это два отдельных сертификата, каждый для своего поддомена

![заголовок Strict-Transport-Security в ответе](screenshots/12-hsts.png)
HSTS (HTTP Strict Transport Security) - это механизм безопасности, который заставляет браузер взаимодействовать с сайтом только по HTTPS, автоматически преобразуя все HTTP-ссылки в HTTPS ещё до отправки запроса. Он защищает от атак типа SSL stripping (понижение протокола до незащищённого HTTP) и предотвращает перехват конфиденциальных данных, включая cookie, через незашифрованные соединения.

![два заголовка (Cache-Control и Content-Encoding: gzip)](screenshots/13-cache-gzip.png)
![Автообновление Congratulations, all simulated renewals succeeded](screenshots/14-renew.png)
![созданный PR на GitHub](screenshots/15-pull-request.png)
