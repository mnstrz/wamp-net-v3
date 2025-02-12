��    ,      |  ;   �      �  E   �  0        @  :   S  E   �  I   �  L     s   k  K   �  =   +  B   i  i   �  G     J   ^  M   �  M   �  ?   E  G   �  >   �  6   	  <   C	  >   �	  F   �	  P   
  I   W
  4   �
  2   �
     	       *   -     X  	   r     |  &   �     �  &   �      �  (   	     2  %   M     s     �     �    �  n   �  s        �  f   �  f     c   x  m   �  �   J  l   �  h   [  m   �  �   2     �  k   y  n   �  n   T  s   �  h   7  o   �  f     g   w  v   �     V     �  �   V  A   �  M     +   j     �  L   �  *   �     '  ?   <  [   |     �  =   �  C   3  J   w  K   �  W     5   f     �     �            #                )   	          '      &   ,       
   $   %                                  +      (                                                           *         "   !                      
%s provides information about the installed version of PostgreSQL.

 
With no arguments, all known items are shown.

   %s [OPTION]...

   --bindir              show location of user executables
   --cc                  show CC value used when PostgreSQL was built
   --cflags              show CFLAGS value used when PostgreSQL was built
   --cflags_sl           show CFLAGS_SL value used when PostgreSQL was built
   --configure           show options given to "configure" script when
                        PostgreSQL was built
   --cppflags            show CPPFLAGS value used when PostgreSQL was built
   --docdir              show location of documentation files
   --htmldir             show location of HTML documentation files
   --includedir          show location of C header files of the client
                        interfaces
   --includedir-server   show location of C header files for the server
   --ldflags             show LDFLAGS value used when PostgreSQL was built
   --ldflags_ex          show LDFLAGS_EX value used when PostgreSQL was built
   --ldflags_sl          show LDFLAGS_SL value used when PostgreSQL was built
   --libdir              show location of object code libraries
   --libs                show LIBS value used when PostgreSQL was built
   --localedir           show location of locale support files
   --mandir              show location of manual pages
   --pgxs                show location of extension makefile
   --pkgincludedir       show location of other C header files
   --pkglibdir           show location of dynamically loadable modules
   --sharedir            show location of architecture-independent support files
   --sysconfdir          show location of system-wide configuration files
   --version             show the PostgreSQL version
   -?, --help            show this help, then exit
 %s home page: <%s>
 %s() failed: %m %s: could not find own program executable
 %s: invalid argument: %s
 Options:
 Report bugs to <%s>.
 Try "%s --help" for more information.
 Usage:
 could not change directory to "%s": %m could not find a "%s" to execute could not identify current directory: %m could not read binary "%s" could not read symbolic link "%s": %m invalid binary "%s" not recorded out of memory Project-Id-Version: pg_config (PostgreSQL current)
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2021-08-14 06:29+0300
PO-Revision-Date: 2021-09-04 12:15+0300
Last-Translator: Alexander Lakhin <exclusion@gmail.com>
Language-Team: Russian <pgsql-ru-general@postgresql.org>
Language: ru
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=3; plural=(n%10==1 && n%100!=11 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2);
 
%s предоставляет информацию об установленной версии PostgreSQL.

 
При запуске без аргументов выводятся все известные значения.

   %s [ПАРАМЕТР]...

   --bindir              показать расположение исполняемых файлов
   --cc                  показать, с каким значением CC собран PostgreSQL
   --cflags              показать, с какими флагами C собран PostgreSQL
   --cflags_sl           показать, с каким значением CFLAGS_SL собран PostgreSQL
   --configure           показать параметры скрипта "configure", с которыми
                        был собран PostgreSQL
   --cppflags            показать, с каким значением CPPFLAGS собран PostgreSQL
   --docdir              показать расположение файлов документации
   --htmldir             показать расположение HTML-файлов документации
   --includedir          показать расположение файлов-заголовков (.h) для
                        клиентских интерфейсов на языке C
   --includedir-server   показать расположение файлов-заголовков (.h) для сервера
   --ldflags             показать, с каким значением LDFLAGS собран PostgreSQL
   --ldflags_ex          показать, с каким значением LDFLAGS_EX собран PostgreSQL
   --ldflags_sl          показать, с каким значением LDFLAGS_SL собран PostgreSQL
   --libdir              показать расположение библиотек объектного кода
   --libs                показать, с каким значением LIBS собран PostgreSQL
   --localedir           показать расположение файлов описания локалей
   --mandir              показать расположение справочных страниц
   --pgxs                показать расположение makefile для расширений
   --pkgincludedir       показать расположение других файлов-заголовков (.h)
   --pkglibdir           показать расположение динамически загружаемых модулей
   --sharedir            показать расположение платформенно-независимых файлов
   --sysconfdir          показать расположение общесистемных файлов конфигурации
   --version             показать версию PostgreSQL
   -?, --help            показать эту справку и выйти
 Домашняя страница %s: <%s>
 ошибка в %s(): %m %s: не удалось найти свой исполняемый файл
 %s: неверный аргумент: %s
 Параметры:
 Об ошибках сообщайте по адресу <%s>.
 Для дополнительной информации попробуйте "%s --help".
 Использование:
 не удалось перейти в каталог "%s": %m не удалось найти запускаемый файл "%s" не удалось определить текущий каталог: %m не удалось прочитать исполняемый файл "%s" не удалось прочитать символическую ссылку "%s": %m неверный исполняемый файл "%s" не записано нехватка памяти 