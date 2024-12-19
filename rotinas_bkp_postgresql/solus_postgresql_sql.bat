echo %DATE%
echo %TIME%
set datetimef=%date:~-4%_%date:~3,2%_%date:~0,2%__%time:~0,2%_%time:~3,2%_%time:~6,2%

pg_dump postgresql://postgres:so1uz!2e@localhost:5432/solussabin > c:\bkppostgresql\bkp_solus_%datetimef%.sql