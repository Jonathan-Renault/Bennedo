REM SAUVEGARDE AUTOMATIQUE DE BASES DE DONNEES POSTGRESQL
SetLocal EnableDelayedExpansion
ECHO OFF
SET time_d=%time% 
REM Parametre de connections
SET PGPORT=5432
SET PGHOST=localhost
SET PGUSER=XXXXXXXX
SET PGPASSWORD=XXXXXXX

 REM  Recherche de toutes les bases de données à sauvegarder dans la table pg_database. Le résultat est envoyé dans un fichier temporaire databases.txt
"C:\Program Files\PostgreSQL\12\bin\psql.exe" -Atc "SELECT datname FROM pg_database WHERE datallowconn IS TRUE AND datname   IN('apibennedo' )" --username postgres > D:\Archives\databases.txt

REM  Itération dans les bases de données à sauvegarder
for /f "tokens=*" %%a in (D:\Archives\databases.txt) do (
       REM  Sauvegarde de la base de données en cours d'itération (format custom, compressé)
       "C:\Program Files\PostgreSQL\12\bin\pg_dump.exe" -C -Fc -U postgres %%a > D:\Archives\%%a-%date:/=-%.sql
)

REM  Suppression du fichier catalogue des bases de données
DEL databases.txt

REM Calculer les temps
SET time_e=%time%
SET hour_d=%time_d:~0,2%
SET min_d=%time_d:~3,2%
SET sec_d=%time_d:~6,2%
SET hour_e=%time_e:~0,2%
SET min_e=%time_e:~3,2%
SET sec_e=%time_e:~6,2%
SET /a total_d=(%hour_d%*3600)+(%min_d%*60)+%sec_d%
SET /a total_e=(%hour_e%*3600)+(%min_e%*60)+%sec_e%
SET /a time_run=%total_e%-%total_d%
ECHO.
ECHO heure de debut de l'execution: %time_d%
ECHO heure de fin de l'execution: %time_e%
ECHO temps d'execution: %time_run% s
ECHO --------------------------------------------------------------->>Logtemp.txt
ECHO ----------- Sauvegarde du %date:/=-% -------------------------->>Logtemp.txt
ECHO Debut de l'execution: %time_d%>>Logtemp.txt
ECHO Fin de l'execution:  %time_e%>>Logtemp.txt
ECHO Temps d'execution:  %time_run% s>>Logtemp.txt
ECHO --------------------------------------------------------------->>Logtemp.txt
ECHO --------------------------------------------------------------->>Logtemp.txt

REM Ouvrir notepad pour afficher le Logtemp.txt
notepad Logtemp.txt
REM PAUSE>nul