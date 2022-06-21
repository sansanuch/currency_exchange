----------------------------
composer install
----------------------------

---------------------------
//start migrations

php yii migrate
---------------------------

---------------------------
//start server

php yii serve
---------------------------

---------------------------
//generate data: currency, users, wallets

http://localhost:8080/index.php?r=generate/generate
---------------------------

---------------------------
go -> http://localhost:8080/login  

user = test1 password = 12345678
---------------------------
