echo %DATE%
echo %HOUR%
echo %TIME%
set datetimef=%date:~-4%_%date:~3,2%_%date:~0,2%__%time%
set datetimef=%datetimef: =%
set datetimef=%datetimef:,=%
set datetimef=%datetimef::=%


pg_dump postgresql://postgres:so1uz!2e@localhost:5432/solussabin > c:\bkppostgresql\bkp_solus_%datetimef%.sql
pg_dump postgresql://postgres:so1uz!2e@localhost:5432/solus_dwsabin > c:\bkppostgresql\bkp_solus_dw_%datetimef%.sql