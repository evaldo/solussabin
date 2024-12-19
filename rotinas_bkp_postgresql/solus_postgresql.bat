  @echo off

   echo %DATE%  
   
   set datestr=%date:~-4%_%date:~3,2%_%date:~0,2%
   echo datestr is %datestr%
    
   set BACKUP_FILE=%datestr%.backup   
   echo backup file name is %BACKUP_FILE%
   
   SET PGPASSWORD=so1uz!2e
   echo on
   
   pg_dump -h localhost -p 5432 -U postgres -F c -b -v -f C:\bkppostgresql\tr_%BACKUP_FILE% solussabin
   pg_dump -h localhost -p 5432 -U postgres -F c -b -v -f C:\bkppostgresql\dw_%BACKUP_FILE% solus_dwsabin
   pg_dumpall -h localhost -p 5432 -U postgres -v --globals-only > C:\bkppostgresql\useraccts.sql