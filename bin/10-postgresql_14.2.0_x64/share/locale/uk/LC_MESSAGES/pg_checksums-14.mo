��    8      �  O   �      �  X   �  
   2     =  5   Y  P   �  5   �  A     :   X  2   �  1   �  G   �  3   @  *   t     �  T   �          "     6     J     h     �     �     �     �  k   �  &   V	     }	  a   �	     �	     
  ;   &
     b
  !   |
     �
  (   �
  3   �
       )   5  5   _  .   �  -   �  )   �  "        ?     G  3   O  +   �     �  2   �  !   �  )         J  /   a     �  	   �  �  �  �   N     �     �  W     e   h  W   �  j   &  {   �  U     Y   c  p   �  T   .  :   �  #   �  �   �  )   �  9   �  *   �  D     C   U  G   �  :   �  *     8   G  �   �  Q   H     �  �   �  E   m  E   �  K   �  7   E  <   }  6   �  I   �  b   ;  T   �  E   �  ^   9  Q   �  M   �  J   8  8   �     �  
   �  h   �  W   A  -   �  a   �  6   )  G   `  6   �  \   �  6   <      s      8          .   )                   !   #               /          4   (   *             ,       0       3      &                               7   6          1            2   '       $                          +              "              
          %             5      -   	        
If no data directory (DATADIR) is specified, the environment variable PGDATA
is used.

 
Options:
   %s [OPTION]... [DATADIR]
   -?, --help               show this help, then exit
   -N, --no-sync            do not wait for changes to be written safely to disk
   -P, --progress           show progress information
   -V, --version            output version information, then exit
   -c, --check              check data checksums (default)
   -d, --disable            disable data checksums
   -e, --enable             enable data checksums
   -f, --filenode=FILENODE  check only relation with specified filenode
   -v, --verbose            output verbose messages
  [-D, --pgdata=]DATADIR    data directory
 %*s/%s MB (%d%%) computed %s enables, disables, or verifies data checksums in a PostgreSQL database cluster.

 %s home page: <%s>
 Bad checksums:  %s
 Blocks scanned: %s
 Checksum operation completed
 Checksums disabled in cluster
 Checksums enabled in cluster
 Data checksum version: %u
 Files scanned:  %s
 Report bugs to <%s>.
 The database cluster was initialized with block size %u, but pg_checksums was compiled with block size %u.
 Try "%s --help" for more information.
 Usage:
 checksum verification failed in file "%s", block %u: calculated checksum %X but block contains %X checksums enabled in file "%s" checksums verified in file "%s" cluster is not compatible with this version of pg_checksums cluster must be shut down could not open directory "%s": %m could not open file "%s": %m could not read block %u in file "%s": %m could not read block %u in file "%s": read %d of %d could not stat file "%s": %m could not write block %u in file "%s": %m could not write block %u in file "%s": wrote %d of %d data checksums are already disabled in cluster data checksums are already enabled in cluster data checksums are not enabled in cluster database cluster is not compatible error:  fatal:  invalid filenode specification, must be numeric: %s invalid segment number %d in file name "%s" no data directory specified option -f/--filenode can only be used with --check pg_control CRC value is incorrect seek failed for block %u in file "%s": %m syncing data directory too many command-line arguments (first is "%s") updating control file warning:  Project-Id-Version: postgresql
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2021-06-10 08:49+0000
PO-Revision-Date: 2021-08-17 10:54
Last-Translator: 
Language-Team: Ukrainian
Language: uk_UA
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=4; plural=((n%10==1 && n%100!=11) ? 0 : ((n%10 >= 2 && n%10 <=4 && (n%100 < 12 || n%100 > 14)) ? 1 : ((n%10 == 0 || (n%10 >= 5 && n%10 <=9)) || (n%100 >= 11 && n%100 <= 14)) ? 2 : 3));
X-Crowdin-Project: postgresql
X-Crowdin-Project-ID: 324573
X-Crowdin-Language: uk
X-Crowdin-File: /REL_14_DEV/pg_checksums.pot
X-Crowdin-File-ID: 764
 
Якщо каталог даних не вказано (DATADIR), використовується змінна середовища PGDATA.

 
Параметри:
   %s [OPTION]... [DATADIR]
   -?, --help               показати цю довідку, потім вийти
   -N, --no-sync          не чекати на безпечний запис змін на диск
   -P, --progress           показати інформацію про прогрес
   -V, --version            вивести інформацію про версію, потім вийти
   -c, --check              перевірити контрольні суми даних (за замовчуванням)
   -d, --disable            вимкнути контрольні суми даних
   -e, --enable             активувати контрольні суми даних
   -f, --filenode=FILENODE перевіряти відношення лише із вказаним файлом
   -v, --verbose          виводити детальні повідомлення
  [-D, --pgdata=]DATADIR         каталог даних
 %*s/%s MB (%d%%) обчислено %s активує, деактивує або перевіряє контрольні суми даних в кластері бази даних PostgreSQL.

 Домашня сторінка %s: <%s>
 Неправильні контрольні суми: %s
 Блоків відскановано: %s
 Операція контрольної суми завершена
 Контрольні суми вимкнені у кластері
 Контрольні суми активовані в кластері
 Версія контрольних сум даних: %u
 Файлів відскановано: %s
 Повідомляти про помилки на <%s>.
 Кластер бази даних було ініціалізовано з розміром блоку %u, але pg_checksums було скомпільовано з розміром блоку %u.
 Спробуйте "%s --help" для додаткової інформації.
 Використання:
 помилка перевірки контрольних сум у файлі "%s", блок %u: обчислена контрольна сума %X, але блок містить %X контрольні суми у файлі "%s" активовані контрольні суми у файлі "%s" перевірені кластер не сумісний з цією версією pg_checksum кластер повинен бути закритий не вдалося відкрити каталог "%s": %m не можливо відкрити файл "%s": %m не вдалося прочитати блок %u в файлі "%s": %m не вдалося прочитати блок %u у файлі "%s": прочитано %d з %d не вдалося отримати інформацію від файлу "%s": %m не вдалося записати блок %u у файл "%s": %m не вдалося записати блок %u у файлі "%s": записано %d з %d контрольні суми вже неактивовані в кластері контрольні суми вже активовані в кластері контрольні суми в кластері неактивовані кластер бази даних не сумісний помилка:  збій:  неприпустима специфікація filenode, повинна бути числовою: %s неприпустимий номер сегменту %d в імені файлу "%s" каталог даних не вказано параметр -f/--filenode може бути використаний тільки з --check значення CRC pg_control неправильне помилка пошуку для блоку %u у файлі "%s": %m синхронізація даних каталогу забагато аргументів у командному рядку (перший "%s") оновлення контрольного файлу попередження:  