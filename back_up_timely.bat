cd "C:\wamp64\bin\mysql\mysql5.7.19\bin"

mysqldump -h localhost -uroot -pRottman3 loginsystem > "C:\Users\Michael\Desktop\backup\backup_%date:~-4,4%%date:~-10,2%%date:~-7,2%_%time:~0,2%%time:~3,2%%time:~6,2%.sql"
