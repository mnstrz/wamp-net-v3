��    ^           �      �      �          0     A     X     r  S   �  H   �  V   !	  =   x	  A   �	  U   �	  Z   N
  K   �
  M   �
  I   C  I   �  T   �  T   ,     �  <   �  D   �  B     <   a  D   �  B   �  A   &  :   h  H   �  8   �  6   %  =   \  M   �  K   �  ;   4  U   p  7   �  =   �  ;   <  :   x  8   �  <   �  ,   )  0   V  7   �     �  <   �     �  +        ?     T  &   t     �     �  V   �  )     9   =     w     �     �  /   �     �             *   ?     j     r  :   z  ,   �  !   �       ;        X  :   p  :   �     �            '   +  /   S     �  %   �     �  .   �  #     *   (     S     d     r  0   �     �  /   �  	   �  �    J   �  ,   �  "     @   0  3   q  3   �     �  _   Y  �   �  c   Z  Y   �  �     �   �  �   "  �   �  t   S   �   �   x   I!  �   �!  )   I"  W   s"  w   �"  }   C#  Y   �#  �   $  y   �$  }   %  u   �%  N   &  B   Z&  E   �&  r   �&  o   V'  t   �'  x   ;(  �   �(  R   <)  |   �)  t   *  x   �*  a   �*  K   \+  @   �+  D   �+  K   .,     z,  v   },  +   �,  5    -  -   V-  B   �-  [   �-     #.     @.  �   `.  C   �.  n   1/  0   �/  9   �/     0  [   0     z0  F   �0  G   �0  >   (1     g1     v1  _   �1  L   �1  7   02  *   h2  T   �2  "   �2  ~   3  �   �3  ?   4  *   S4  ,   ~4  s   �4  �   5  4   �5  |   �5  >   [6  �   �6  q   7  \   �7  ;   �7     '8     88  `   J8  H   �8  c   �8     X9        *                 .   R   >      +             	       O       J                [      N   (   /   8   ,       $         )          I   -   A      7   3   G      D       
                W   C       Y       M          T   9         \   E              Q   0   '   @   &          !       P       ^   5          S   K           L   <      %          X   4       "   F              ?   Z   :   H   B       #           6       ]   2               U       ;   =   1          V    
B-tree index checking options:
 
Connection options:
 
Other options:
 
Report bugs to <%s>.
 
Table checking options:
 
Target options:
       --endblock=BLOCK            check table(s) only up to the given block number
       --exclude-toast-pointers    do NOT follow relation TOAST pointers
       --heapallindexed            check that all heap tuples are found within indexes
       --install-missing           install missing extensions
       --maintenance-db=DBNAME     alternate maintenance database
       --no-dependent-indexes      do NOT expand list of relations to include indexes
       --no-dependent-toast        do NOT expand list of relations to include TOAST tables
       --no-strict-names           do NOT require patterns to match objects
       --on-error-stop             stop checking at end of first corrupt page
       --parent-check              check index parent/child relationships
       --rootdescend               search from root page to refind tuples
       --skip=OPTION               do NOT check "all-frozen" or "all-visible" blocks
       --startblock=BLOCK          begin checking table(s) at the given block number
   %s [OPTION]... [DBNAME]
   -?, --help                      show this help, then exit
   -D, --exclude-database=PATTERN  do NOT check matching database(s)
   -I, --exclude-index=PATTERN     do NOT check matching index(es)
   -P, --progress                  show progress information
   -R, --exclude-relation=PATTERN  do NOT check matching relation(s)
   -S, --exclude-schema=PATTERN    do NOT check matching schema(s)
   -T, --exclude-table=PATTERN     do NOT check matching table(s)
   -U, --username=USERNAME         user name to connect as
   -V, --version                   output version information, then exit
   -W, --password                  force password prompt
   -a, --all                       check all databases
   -d, --database=PATTERN          check matching database(s)
   -e, --echo                      show the commands being sent to the server
   -h, --host=HOSTNAME             database server host or socket directory
   -i, --index=PATTERN             check matching index(es)
   -j, --jobs=NUM                  use this many concurrent connections to the server
   -p, --port=PORT                 database server port
   -r, --relation=PATTERN          check matching relation(s)
   -s, --schema=PATTERN            check matching schema(s)
   -t, --table=PATTERN             check matching table(s)
   -v, --verbose                   write a lot of output
   -w, --no-password               never prompt for password
 %*s/%s relations (%d%%), %*s/%s pages (%d%%) %*s/%s relations (%d%%), %*s/%s pages (%d%%) %*s %*s/%s relations (%d%%), %*s/%s pages (%d%%) (%s%-*.*s) %s %s checks objects in a PostgreSQL database for corruption.

 %s home page: <%s>
 Are %s's and amcheck's versions compatible? Cancel request sent
 Could not send cancel request:  Try "%s --help" for more information.
 Usage:
 btree index "%s.%s.%s":
 btree index "%s.%s.%s": btree checking function returned unexpected number of rows: %d cannot specify a database name with --all cannot specify both a database name and database patterns checking btree index "%s.%s.%s" checking heap table "%s.%s.%s" command was: %s could not connect to database %s: out of memory database "%s": %s end block out of bounds end block precedes start block error sending command to database "%s": %s error:  fatal:  heap table "%s.%s.%s", block %s, offset %s, attribute %s:
 heap table "%s.%s.%s", block %s, offset %s:
 heap table "%s.%s.%s", block %s:
 heap table "%s.%s.%s":
 in database "%s": using amcheck version "%s" in schema "%s" including database "%s" internal error: received unexpected database pattern_id %d internal error: received unexpected relation pattern_id %d invalid argument for option %s invalid end block invalid start block no btree indexes to check matching "%s" no connectable databases to check matching "%s" no databases to check no heap tables to check matching "%s" no relations to check no relations to check in schemas matching "%s" no relations to check matching "%s" number of parallel jobs must be at least 1 query failed: %s query was: %s query was: %s
 skipping database "%s": amcheck is not installed start block out of bounds too many command-line arguments (first is "%s") warning:  Project-Id-Version: pg_amcheck (PostgreSQL) 14
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2022-02-07 11:21+0300
PO-Revision-Date: 2021-09-06 10:51+0300
Last-Translator: Alexander Lakhin <exclusion@gmail.com>
Language-Team: Russian <pgsql-ru-general@postgresql.org>
Language: ru
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
 
Параметры проверки индексов-B-деревьев:
 
Параметры подключения:
 
Другие параметры:
 
Об ошибках сообщайте по адресу <%s>.
 
Параметры проверки таблиц:
 
Параметры выбора объектов:
       --endblock=БЛОК             проверить таблицы(у) до блока с заданным номером
       --exclude-toast-pointers    не переходить по указателям в TOAST
       --heapallindexed            проверить, что всем кортежам кучи находится соответствие в индексах
       --install-missing           установить недостающие расширения
       --maintenance-db=ИМЯ_БД     другая опорная база данных
       --no-dependent-indexes      не включать в список проверяемых отношений индексы
       --no-dependent-toast        не включать в список проверяемых отношений TOAST-таблицы
       --no-strict-names           не требовать наличия объектов, соответствующих шаблонам
       --on-error-stop             прекратить проверку по достижении конца первой повреждённой страницы
       --parent-check              проверить связи родитель/потомок в индексах
       --rootdescend               перепроверять поиск кортежей от корневой страницы
       --skip=ТИП_БЛОКА            не проверять блоки типа "all-frozen" или "all-visible"
       --startblock=БЛОК           начать проверку таблиц(ы) с блока с заданным номером
   %s [ПАРАМЕТР]... [ИМЯ_БД]
   -?, --help                      показать эту справку и выйти
   -D, --exclude-database=ШАБЛОН   не проверять соответствующие шаблону базы
   -I, --exclude-index=ШАБЛОН      не проверять соответствующие шаблону индексы
   -P, --progress                  показывать прогресс операции
   -R, --exclude-relation=ШАБЛОН   не проверять соответствующие шаблону отношения
   -S, --exclude-schema=ШАБЛОН     не проверять соответствующие шаблону схемы
   -T, --exclude-table=ШАБЛОН      не проверять соответствующие шаблону таблицы
   -U, --username=ИМЯ              имя пользователя для подключения к серверу
   -V, --version                   показать версию и выйти
   -W, --password                  запросить пароль
   -a, --all                       проверить все базы
   -d, --database=ШАБЛОН           проверить соответствующие шаблону базы
   -e, --echo                      отображать команды, отправляемые серверу
   -h, --host=ИМЯ                  имя сервера баз данных или каталог сокетов
   -i, --index=ШАБЛОН              проверить соответствующие шаблону индексы
   -j, --jobs=ЧИСЛО                устанавливать заданное число подключений к серверу
   -p, --port=ПОРТ                 порт сервера баз данных
   -r, --relation=ШАБЛОН           проверить соответствующие шаблону отношения
   -s, --schema=ШАБЛОН             проверить соответствующие шаблону схемы
   -t, --table=ШАБЛОН              проверить соответствующие шаблону таблицы
   -v, --verbose                   выводить исчерпывающие сообщения
   -w, --no-password               не запрашивать пароль
 отношений: %*s/%s (%d%%), страниц: %*s/%s (%d%%) отношений: %*s/%s (%d%%), страниц: %*s/%s (%d%%) %*s отношений: %*s/%s (%d%%), страниц: %*s/%s (%d%%) (%s%-*.*s) %s %s проверяет объекты в базе данных PostgreSQL на предмет повреждений.

 Домашняя страница %s: <%s>
 Совместимы ли версии %s и amcheck? Сигнал отмены отправлен
 Отправить сигнал отмены не удалось:  Для дополнительной информации попробуйте "%s --help".
 Использование:
 индекс btree "%s.%s.%s":
 индекс btree "%s.%s.%s": функция проверки btree выдала неожиданное количество строк: %d имя базы данных нельзя задавать с --all нельзя задавать одновременно имя базы данных и шаблоны имён проверка индекса btree "%s.%s.%s" проверка базовой таблицы "%s.%s.%s" команда: %s не удалось подключиться к базе %s (нехватка памяти) база данных "%s": %s конечный блок вне допустимых пределов конечный блок предшествует начальному ошибка передачи команды базе "%s": %s ошибка:  важно:  базовая таблица "%s.%s.%s", блок %s, смещение %s, атрибут %s:
 базовая таблица "%s.%s.%s", блок %s, смещение %s:
 базовая таблица "%s.%s.%s", блок %s:
 базовая таблица "%s.%s.%s":
 база "%s": используется amcheck версии "%s" в схеме "%s" выбирается база "%s" внутренняя ошибка: получен неожиданный идентификатор шаблона базы %d внутренняя ошибка: получен неожиданный идентификатор шаблона отношения %d недопустимый аргумент параметра %s неверный конечный блок неверный начальный блок не найдены подлежащие проверке индексы btree, соответствующие "%s" не найдены подлежащие проверке доступные базы, соответствующие шаблону "%s" не указаны базы для проверки не найдены подлежащие проверке базовые таблицы, соответствующие "%s" не найдены отношения для проверки не найдены подлежащие проверке отношения в схемах, соответствующих "%s" не найдены подлежащие проверке отношения, соответствующие "%s" число параллельных заданий должно быть не меньше 1 ошибка при выполнении запроса: %s запрос: %s запрос: %s
 база "%s" пропускается: расширение amcheck не установлено начальный блок вне допустимых пределов слишком много аргументов командной строки (первый: "%s") предупреждение:  