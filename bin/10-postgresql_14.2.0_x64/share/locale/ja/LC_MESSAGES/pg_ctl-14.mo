Þ             ß   
                 º  &   Ì     ó          2     I     _  /   r     ¢  "   Â  1   å       "   ³  j   Ö  o   A     ±  D   Ï  !     3   6  ?   j  H   ª  D   ó  C   8  E   |  ?   Â  ?     >   B  9     L   »  B     E   K       0     F   G  >     B   Í  I     %   Z  <     O   ½  7        E     L     U     g  M   {     É  -   Ù  !     >   )  E   h  C   ®  y   ò  9   l  D   ¦  C   ë  D   /  E   t  >   º  A   ù  '   ;  (   c  ,     7   ¹  2   ñ  6   $  >   [  *     /   Å  7   õ  4   -  %   b  %     1   ®  0   à  #        5  4   S  7     2   À  6   ó  1   *  0   \  ,     .   º  3   é  7         U   +   u   1   ¡   6   Ó   6   
!  1   A!  *   s!  "   !  7   Á!  "   ù!  $   "  J   A"     "     ¨"  3   ¿"  0   ó"     $#  #   7#  !   [#     }#  !   #  $   ¾#      ã#  -   $     2$  4   R$  %   $  $   ­$  "   Ò$  !   õ$  u   %  F   %     Ô%  7   è%  )    &  k   J&  `   ¶&  %   '  &   ='     d'  d   l'     Ñ'  /   ð'  &    (  0   G(  .   x(  -   §(     Õ(     ì(  &   þ(      %)  ,   F)  (   s)     )  %   ·)     Ý)     ñ)     ÿ)     *     *     1*     G*  #   X*     |*     *     *     ­*     Å*      ä*  "   +     (+  Ý  G+  1   %-     W-  *   s-  &   -  &   Å-  -   ì-  3   .  $   N.  /   s.     £.  "   Ã.  1   æ.     /  "   ´/  j   ×/  o   B0     ²0  D   Ð0  !   1  >   71  A   v1  M   ¸1  b   2  Y   i2  S   Ã2  D   3  8   \3  F   3  P   Ü3  e   -4  ]   4  N   ñ4  £   @5  )   ä5  k   6  R   z6  M   Í6  [   7  5   w7  D   ­7  b   ò7  ?   U8     8     8  &   ±8     Ø8  j   õ8     `9  [   9  *   Û9  a   :  p   h:  u   Ù:  ¯   O;  g   ÿ;  k   g<  r   Ó<  r   F=  o   ¹=  r   )>  u   >  5   ?  F   H?  G   ?  d   ×?  U   <@  V   @  `   é@  A   JA  ;   A  D   ÈA  P   B  C   ^B  F   ¢B  \   éB  Q   FC  D   C  ?   ÝC  K   D  X   iD  C   ÂD  V   E  G   ]E  O   ¥E  B   õE  I   8F  `   F  S   ãF  6   7G  G   nG  K   ¶G  Q   H  d   TH  U   ¹H  D   I  0   TI  c   I  ?   éI  0   )J  S   ZJ  2   ®J  ,   áJ  Q   K  O   `K     °K  ;   ÅK  ;   L  ,   =L  -   jL  ,   L  3   ÅL  E   ùL  $   ?M  B   dM  '   §M  0   ÏM  !    N  !   "N     DN  K   ßN  )   +O  ^   UO  =   ´O  ²   òO  »   ¥P  =   aQ  3   Q     ÓQ     âQ  4   R  ;   ·R  8   óR  J   ,S  1   wS  ?   ©S  6   éS  $    T  ;   ET  4   T  G   ¶T  C   þT  1   BU  >   tU     ³U     ÍU     ÝU  "   îU     V     1V  1   QV  C   V     ÇV  "   áV  "   W  1   'W  1   YW  -   W  9   ¹W  3   óW     a   2   *   B          ,   U      )   7       M          ;   L   <       R      W          &   b   G   8   4          }              -      6             O             ~   T               1   K   h                       P      {       X          0                           !   :   w   |      z       #         p   +       t       V      e           9   N               d          @   D            i   c   %      "                  r       _   f   s      .              E          /      ]   `      Q   >               Z      
           (       v              \   m   $   k      l       g          A                 =           x       J       n                 '   ^   [                 H   q      o      C          y       Y       S         ?                	   j                        u   F   I             3          5    
Allowed signal names for kill:
 
Common options:
 
Options for register and unregister:
 
Options for start or restart:
 
Options for stop or restart:
 
Report bugs to <%s>.
 
Shutdown modes are:
 
Start types are:
   %s init[db]   [-D DATADIR] [-s] [-o OPTIONS]
   %s kill       SIGNALNAME PID
   %s logrotate  [-D DATADIR] [-s]
   %s promote    [-D DATADIR] [-W] [-t SECS] [-s]
   %s register   [-D DATADIR] [-N SERVICENAME] [-U USERNAME] [-P PASSWORD]
                    [-S START-TYPE] [-e SOURCE] [-W] [-t SECS] [-s] [-o OPTIONS]
   %s reload     [-D DATADIR] [-s]
   %s restart    [-D DATADIR] [-m SHUTDOWN-MODE] [-W] [-t SECS] [-s]
                    [-o OPTIONS] [-c]
   %s start      [-D DATADIR] [-l FILENAME] [-W] [-t SECS] [-s]
                    [-o OPTIONS] [-p PATH] [-c]
   %s status     [-D DATADIR]
   %s stop       [-D DATADIR] [-m SHUTDOWN-MODE] [-W] [-t SECS] [-s]
   %s unregister [-N SERVICENAME]
   -?, --help             show this help, then exit
   -D, --pgdata=DATADIR   location of the database storage area
   -N SERVICENAME  service name with which to register PostgreSQL server
   -P PASSWORD     password of account to register PostgreSQL server
   -S START-TYPE   service start type to register PostgreSQL server
   -U USERNAME     user name of account to register PostgreSQL server
   -V, --version          output version information, then exit
   -W, --no-wait          do not wait until operation completes
   -c, --core-files       allow postgres to produce core files
   -c, --core-files       not applicable on this platform
   -e SOURCE              event source for logging when running as a service
   -l, --log=FILENAME     write (or append) server log to FILENAME
   -m, --mode=MODE        MODE can be "smart", "fast", or "immediate"
   -o, --options=OPTIONS  command line options to pass to postgres
                         (PostgreSQL server executable) or initdb
   -p PATH-TO-POSTGRES    normally not necessary
   -s, --silent           only print errors, no informational messages
   -t, --timeout=SECS     seconds to wait when using -w option
   -w, --wait             wait until operation completes (default)
   auto       start service automatically during system startup (default)
   demand     start service on demand
   fast        quit directly, with proper shutdown (default)
   immediate   quit without complete shutdown; will lead to recovery on restart
   smart       quit after all clients have disconnected
  done
  failed
  stopped waiting
 %s home page: <%s>
 %s is a utility to initialize, start, stop, or control a PostgreSQL server.

 %s() failed: %m %s: -S option not supported on this platform
 %s: PID file "%s" does not exist
 %s: WARNING: cannot create restricted tokens on this platform
 %s: WARNING: could not locate all job object functions in system API
 %s: another server might be running; trying to start server anyway
 %s: cannot be run as root
Please log in (using, e.g., "su") as the (unprivileged) user that will
own the server process.
 %s: cannot promote server; server is not in standby mode
 %s: cannot promote server; single-user server is running (PID: %ld)
 %s: cannot reload server; single-user server is running (PID: %ld)
 %s: cannot restart server; single-user server is running (PID: %ld)
 %s: cannot rotate log file; single-user server is running (PID: %ld)
 %s: cannot set core file size limit; disallowed by hard limit
 %s: cannot stop server; single-user server is running (PID: %ld)
 %s: control file appears to be corrupt
 %s: could not access directory "%s": %s
 %s: could not allocate SIDs: error code %lu
 %s: could not create log rotation signal file "%s": %s
 %s: could not create promote signal file "%s": %s
 %s: could not create restricted token: error code %lu
 %s: could not determine the data directory using command "%s"
 %s: could not find own program executable
 %s: could not find postgres program executable
 %s: could not get LUIDs for privileges: error code %lu
 %s: could not get token information: error code %lu
 %s: could not open PID file "%s": %s
 %s: could not open log file "%s": %s
 %s: could not open process token: error code %lu
 %s: could not open service "%s": error code %lu
 %s: could not open service manager
 %s: could not read file "%s"
 %s: could not register service "%s": error code %lu
 %s: could not remove log rotation signal file "%s": %s
 %s: could not remove promote signal file "%s": %s
 %s: could not send log rotation signal (PID: %ld): %s
 %s: could not send promote signal (PID: %ld): %s
 %s: could not send reload signal (PID: %ld): %s
 %s: could not send signal %d (PID: %ld): %s
 %s: could not send stop signal (PID: %ld): %s
 %s: could not start server
Examine the log output.
 %s: could not start server due to setsid() failure: %s
 %s: could not start server: %s
 %s: could not start server: error code %lu
 %s: could not start service "%s": error code %lu
 %s: could not unregister service "%s": error code %lu
 %s: could not write log rotation signal file "%s": %s
 %s: could not write promote signal file "%s": %s
 %s: database system initialization failed
 %s: directory "%s" does not exist
 %s: directory "%s" is not a database cluster directory
 %s: invalid data in PID file "%s"
 %s: missing arguments for kill mode
 %s: no database directory specified and environment variable PGDATA unset
 %s: no operation specified
 %s: no server running
 %s: old server process (PID: %ld) seems to be gone
 %s: option file "%s" must have exactly one line
 %s: out of memory
 %s: server did not promote in time
 %s: server did not start in time
 %s: server does not shut down
 %s: server is running (PID: %ld)
 %s: service "%s" already registered
 %s: service "%s" not registered
 %s: single-user server is running (PID: %ld)
 %s: the PID file "%s" is empty
 %s: too many command-line arguments (first is "%s")
 %s: unrecognized operation mode "%s"
 %s: unrecognized shutdown mode "%s"
 %s: unrecognized signal name "%s"
 %s: unrecognized start type "%s"
 HINT: The "-m fast" option immediately disconnects sessions rather than
waiting for session-initiated disconnection.
 If the -D option is omitted, the environment variable PGDATA is used.
 Is server running?
 Please terminate the single-user server and try again.
 Server started and accepting connections
 The program "%s" is needed by %s but was not found in the
same directory as "%s".
Check your installation.
 The program "%s" was found by "%s"
but was not the same version as %s.
Check your installation.
 Timed out waiting for server startup
 Try "%s --help" for more information.
 Usage:
 WARNING: online backup mode is active
Shutdown will not complete until pg_stop_backup() is called.

 Waiting for server startup...
 cannot duplicate null pointer (internal error)
 child process exited with exit code %d child process exited with unrecognized status %d child process was terminated by exception 0x%X child process was terminated by signal %d: %s command not executable command not found could not change directory to "%s": %m could not find a "%s" to execute could not get current working directory: %s
 could not identify current directory: %m could not read binary "%s" could not read symbolic link "%s": %m invalid binary "%s" out of memory out of memory
 server promoted
 server promoting
 server shutting down
 server signaled
 server signaled to rotate log file
 server started
 server starting
 server stopped
 starting server anyway
 trying to start server anyway
 waiting for server to promote... waiting for server to shut down... waiting for server to start... Project-Id-Version: pg_ctl (PostgreSQL 13)
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2021-08-25 17:21+0900
PO-Revision-Date: 2021-08-19 17:35+0900
Last-Translator: Kyotaro Horiguchi <horikyota.ntt@gmail.com>
Language-Team: Japan PostgreSQL Users Group <jpug-doc@ml.postgresql.jp>
Language: ja
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=1; plural=0;
X-Generator: Poedit 1.8.13
 
killã¢ã¼ãã§å©ç¨ã§ããã·ã°ãã«å:
 
å±éã®ãªãã·ã§ã³:
 
ç»é²ãç»é²è§£é¤ã®ãªãã·ã§ã³:
 
èµ·åãåèµ·åã®ãªãã·ã§ã³
 
åæ­¢ãåèµ·åã®ãªãã·ã§ã³
 
ãã°ã¯<%s>ã«å ±åãã¦ãã ããã
 
ã·ã£ãããã¦ã³ã¢ã¼ãã¯ä»¥ä¸ã®éã:
 
èµ·åã¿ã¤ãã¯ä»¥ä¸ã®éã:
   %s init[db]   [-D DATADIR] [-s] [-o OPTIONS]
   %s kill       SIGNALNAME PID
   %s logrotate  [-D DATADIR] [-s]
   %s promote    [-D DATADIR] [-W] [-t SECS] [-s]
   %s register   [-D DATADIR] [-N SERVICENAME] [-U USERNAME] [-P PASSWORD]
                    [-S START-TYPE] [-e SOURCE] [-W] [-t SECS] [-s] [-o OPTIONS]
   %s reload     [-D DATADIR] [-s]
   %s restart    [-D DATADIR] [-m SHUTDOWN-MODE] [-W] [-t SECS] [-s]
                    [-o OPTIONS] [-c]
   %s start      [-D DATADIR] [-l FILENAME] [-W] [-t SECS] [-s]
                    [-o OPTIONS] [-p PATH] [-c]
   %s status     [-D DATADIR]
   %s stop       [-D DATADIR] [-m SHUTDOWN-MODE] [-W] [-t SECS] [-s]
   %s unregister [-N SERVICENAME]
   -?, --help             ãã®ãã«ããè¡¨ç¤ºãã¦çµäº
   -D, --pgdata=DATADIR   ãã¼ã¿ãã¼ã¹æ ¼ç´é åã®å ´æ
   -N SERVICENAME  PostgreSQLãµã¼ãã¼ãç»é²ããéã®ãµã¼ãã¹å
   -P PASSWORD     PostgreSQLãµã¼ãã¼ãç»é²ããããã®ã¢ã«ã¦ã³ãã®ãã¹ã¯ã¼ã
   -S START-TYPE   PostgreSQLãµã¼ãã¼ãç»é²ããéã®ãµã¼ãã¹èµ·åã¿ã¤ã
   -U USERNAME     PostgreSQLãµã¼ãã¼ãç»é²ããããã®ã¢ã«ã¦ã³ãå
   -V, --version          ãã¼ã¸ã§ã³æå ±ãè¡¨ç¤ºãã¦çµäº
   -W, --no-wait          ä½æ¥­ã®å®äºãå¾ããªã
   -c, --core-files       postgresã®ã³ã¢ãã¡ã¤ã«çæãè¨±å¯
   -c, --core-files       ãã®ãã©ãããã©ã¼ã ã§ã¯é©ç¨ãããªã
   -e SOURCE              ãµã¼ãã¹ã¨ãã¦èµ·åãããã¨ãã®ã­ã°ã®ã¤ãã³ãã½ã¼ã¹
   -l, --log FILENAME     ãµã¼ãã¼ã­ã°ãFILENAMEã¸æ¸ãè¾¼ã(ã¾ãã¯è¿½å ãã)
   -m, --mode=MODE        MODEã¯"smart"ã"fast"ã"immediate"ã®ãããã
   -o, --options=OPTIONS  postgres(PostgreSQLãµã¼ãã¼å®è¡ãã¡ã¤ã«)ã¾ãã¯
                         initdb ã«æ¸¡ãã³ãã³ãã©ã¤ã³ãªãã·ã§ã³
   -p PATH-TO-POSTGRES    éå¸¸ã¯ä¸è¦
   -s, --silent           ã¨ã©ã¼ã¡ãã»ã¼ã¸ã®ã¿ãè¡¨ç¤ºãæå ±ã¡ãã»ã¼ã¸ã¯è¡¨ç¤ºããªã
   -t, --timeout=SECS     -wãªãã·ã§ã³ãä½¿ç¨ããæã«å¾æ©ããç§æ°
   -w, --wait             æä½ãå®äºããã¾ã§å¾æ© (ããã©ã«ã)
   auto       ã·ã¹ãã ã®èµ·åæã«ãµã¼ãã¹ãèªåçã«éå§(ããã©ã«ã)
   demand     è¦æ±ã«å¿ãã¦ãµã¼ãã¹ãéå§
   fast        é©åãªæç¶ãã§ç´ã¡ã«åæ­¢(ããã©ã«ã)
   immediate   é©åãªæç¶ãæãã§åæ­¢; åèµ·åæã«ã¯ãªã«ããªãå®è¡ããã
   smart       å¨ã¯ã©ã¤ã¢ã³ãã®æ¥ç¶åæ­å¾ã«åæ­¢
 å®äº
 å¤±æãã¾ãã
  å¾æ©å¦çãåæ­¢ããã¾ãã
 %s ãã¼ã ãã¼ã¸: <%s>
 %sã¯PostgreSQLãµã¼ãã¼ã®åæåãèµ·åãåæ­¢ãå¶å¾¡ãè¡ãã¦ã¼ãã£ãªãã£ã§ãã
 %s() ãå¤±æãã¾ãã: %m %s: -Sãªãã·ã§ã³ã¯ãã®ãã©ãããã©ã¼ã ã§ãµãã¼ãããã¦ãã¾ãã
 %s: PIDãã¡ã¤ã«"%s"ãããã¾ãã
 %s: è­¦å: ãã®ãã©ãããã©ã¼ã ã§ã¯å¶éä»ããã¼ã¯ã³ãä½æã§ãã¾ãã
 %s: è­¦å: ã·ã¹ãã APIåã«ãã¹ã¦ã®ã¸ã§ããªãã¸ã§ã¯ãé¢æ°ãæ ¼ç´ã§ãã¾ããã§ãã
 %s: ä»ã®ãµã¼ãã¼ãåä½ä¸­ã®å¯è½æ§ãããã¾ãããã¨ã«ããpostmasterã®èµ·åãè©¦ã¿ã¾ãã
 %s: rootã§ã¯å®è¡ã§ãã¾ãã
ãµã¼ãã¼ãã­ã»ã¹ã®ææèã¨ãªã(éç¹æ¨©)ã¦ã¼ã¶ã¼ã¨ãã¦("su"ãªã©ãä½¿ç¨ãã¦)
ã­ã°ã¤ã³ãã¦ãã ããã
 %s: ãµã¼ãã¼ãææ ¼ã§ãã¾ãã; ãµã¼ãã¼ã¯ã¹ã¿ã³ãã¤ã¢ã¼ãã§ã¯ããã¾ãã
 %s: ãµã¼ãã¼ãææ ¼ã§ãã¾ãã; ã·ã³ã°ã«ã¦ã¼ã¶ã¼ãµã¼ãã¼(PID: %ld)ãåä½ä¸­ã§ã
 %s: ãµã¼ãã¼ããªã­ã¼ãã§ãã¾ãããã·ã³ã°ã«ã¦ã¼ã¶ã¼ãµã¼ãã¼(PID: %ld)ãåä½ä¸­ã§ã
 %s: ãµã¼ãã¼ãåèµ·åã§ãã¾ãããã·ã³ã°ã«ã¦ã¼ã¶ã¼ãµã¼ãã¼(PID: %ld)ãåä½ä¸­ã§ãã
 %s: ã­ã°ãã­ã¼ãã¼ãã§ãã¾ãã; ã·ã³ã°ã«ã¦ã¼ã¶ã¼ãµã¼ãã¼ãåä½ä¸­ã§ã (PID: %ld)
 %s: ã³ã¢ãã¡ã¤ã«ã®ãµã¤ãºå¶éãè¨­å®ã§ãã¾ãã:åºå®ã®å¶éã«ããè¨±ããã¦ãã¾ãã
 %s: ãµã¼ãã¼ãåæ­¢ã§ãã¾ãããã·ã³ã°ã«ã¦ã¼ã¶ã¼ãµã¼ãã¼(PID: %ld)ãåä½ãã¦ãã¾ãã
 %s: å¶å¾¡ãã¡ã¤ã«ãå£ãã¦ããããã§ã
 %s: ãã£ã¬ã¯ããª"%s"ã«ã¢ã¯ã»ã¹ã§ãã¾ããã§ãã: %s
 %s: SIDãå²ãå½ã¦ããã¾ããã§ãã: ã¨ã©ã¼ã³ã¼ã %lu
 %s: ã­ã°ã­ã¼ãã¼ãæç¤ºãã¡ã¤ã«"%s"ãä½æãããã¨ãã§ãã¾ããã§ãã: %s
 %s: ææ ¼æç¤ºãã¡ã¤ã«"%s"ãä½æãããã¨ãã§ãã¾ããã§ãã: %s
 %s: å¶éä»ããã¼ã¯ã³ãä½æã§ãã¾ããã§ãã: ã¨ã©ã¼ã³ã¼ã %lu
 %s: ã³ãã³ã"%s"ãä½¿ç¨ãããã¼ã¿ãã£ã¬ã¯ããªãæ±ºå®ã§ãã¾ããã§ãã
 %s: èªèº«ã®å®è¡ãã¡ã¤ã«ãè¦ã¤ããã¾ããã§ãã
 %s: postgres ã®å®è¡ãã¡ã¤ã«ãè¦ã¤ããã¾ãã
 %s: æ¨©éã® LUID ãåå¾ã§ãã¾ãã: ã¨ã©ã¼ã³ã¼ã %lu
 %s: ãã¼ã¯ã³æå ±ãåå¾ã§ãã¾ããã§ãã: ã¨ã©ã¼ã³ã¼ã %lu
 %s: PIDãã¡ã¤ã«"%s"ããªã¼ãã³ã§ãã¾ããã§ãã: %s
 %s: ã­ã°ãã¡ã¤ã«"%s"ããªã¼ãã³ã§ãã¾ããã§ãã: %s
 %s: ãã­ã»ã¹ãã¼ã¯ã³ããªã¼ãã³ã§ãã¾ããã§ãã: ã¨ã©ã¼ã³ã¼ã %lu
 %s: ãµã¼ãã¹"%s"ã®ãªã¼ãã³ã«å¤±æãã¾ãã: ã¨ã©ã¼ã³ã¼ã %lu
 %s: ãµã¼ãã¹ããã¼ã¸ã£ã®ãªã¼ãã³ã«å¤±æãã¾ãã
 %s: ãã¡ã¤ã«"%s"ãèª­ã¿åããã¨ã«å¤±æãã¾ãã
 %s: ãµã¼ãã¹"%s"ã®ç»é²ã«å¤±æãã¾ãã: ã¨ã©ã¼ã³ã¼ã %lu
 %s: ã­ã°ã­ã¼ãã¼ã·ã§ã³æç¤ºãã¡ã¤ã«"%s"ã®åé¤ã«å¤±æãã¾ãã: %s
 %s: ææ ¼æç¤ºãã¡ã¤ã«"%s"ã®åé¤ã«å¤±æãã¾ãã: %s
 %s: ã­ã°ã­ã¼ãã¼ãã·ã°ãã«ãéä¿¡ã§ãã¾ããã§ãã (PID: %ld): %s
 %s: ææ ¼ã·ã°ãã«ãéä¿¡ã§ãã¾ããã§ãã (PID: %ld): %s
 %s: ãªã­ã¼ãã·ã°ãã«ãéä¿¡ã§ãã¾ããã§ããã(PID: %ld): %s
 %s: ã·ã°ãã«%dãéä¿¡ã§ãã¾ããã§ãã(PID: %ld): %s
 %s: åæ­¢ã·ã°ãã«ãéä¿¡ã§ãã¾ããã§ããã(PID: %ld): %s
 %s: ãµã¼ãã¼ãèµ·åã§ãã¾ããã§ããã
ã­ã°åºåãç¢ºèªãã¦ãã ããã
 %s: setsid()ã«å¤±æãããããµã¼ãã¼ã«æ¥ç¶ã§ãã¾ããã§ãã: %s
 %s: ãµã¼ãã¼ã«æ¥ç¶ã§ãã¾ããã§ãã: %s
 %s: ãµã¼ãã¼ã®èµ·åã«å¤±æãã¾ãã: ã¨ã©ã¼ã³ã¼ã %lu
 %s: ãµã¼ãã¹"%s"ã®èµ·åã«å¤±æãã¾ãã: ã¨ã©ã¼ã³ã¼ã %lu
 %s: ãµã¼ãã¹"%s"ã®ç»é²åé¤ã«å¤±æãã¾ãã: ã¨ã©ã¼ã³ã¼ã %lu
 %s: ã­ã°ã­ã¼ãã¼ãæç¤ºãã¡ã¤ã«"%s"ã«æ¸ãåºããã¨ãã§ãã¾ããã§ãã: %s
 %s: ææ ¼æç¤ºãã¡ã¤ã«"%s"ã«æ¸ãåºããã¨ãã§ãã¾ããã§ãã: %s
 %s: ãã¼ã¿ãã¼ã¹ã·ã¹ãã ãåæåã«å¤±æãã¾ãã
 %s: ãã£ã¬ã¯ããª"%s"ã¯å­å¨ãã¾ãã
 %s: ãã£ã¬ã¯ããª"%s"ã¯ãã¼ã¿ãã¼ã¹ã¯ã©ã¹ã¿ãã£ã¬ã¯ããªã§ã¯ããã¾ãã
 %s: PIDãã¡ã¤ã«"%s"åã«ç¡å¹ãªãã¼ã¿ãããã¾ã
 %s: killã¢ã¼ãç¨ã®å¼æ°ãããã¾ãã
 %s: ãã¼ã¿ãã¼ã¹ã®æå®ããPGDATAç°å¢å¤æ°ã®è¨­å®ãããã¾ãã
 %s: æä½ã¢ã¼ããæå®ããã¦ãã¾ãã
 %s: ãµã¼ãã¼ãåä½ãã¦ãã¾ãã
 %s: å¤ããµã¼ãã¼ãã­ã»ã¹(PID: %ld)ãåä½ãã¦ããªãããã§ã
 %s: ãªãã·ã§ã³ãã¡ã¤ã«"%s"ã¯1è¡ã®ã¿ã§ãªããã°ãªãã¾ãã
 %s: ã¡ã¢ãªä¸è¶³
 %s: ãµã¼ãã¼ã¯æéåã«ææ ¼ãã¾ããã§ãã
 %s: ãµã¼ãã¼ã¯æéåã«åæ­¢ãã¾ããã§ãã
 %s: ãµã¼ãã¼ã¯åæ­¢ãã¦ãã¾ãã
 %s: ãµã¼ãã¼ãåä½ä¸­ã§ã(PID: %ld)
 %s: ãµã¼ãã¹\"%s\"ã¯ç»é²æ¸ã¿ã§ã
 %s: ãµã¼ãã¹"%s"ã¯ç»é²ããã¦ãã¾ãã
 %s: ã·ã³ã°ã«ã¦ã¼ã¶ã¼ãµã¼ãã¼ãåä½ä¸­ã§ã(PID: %ld)
 %s: PIDãã¡ã¤ã«"%s"ãç©ºã§ã
 %s: ã³ãã³ãã©ã¤ã³å¼æ°ãå¤ããã¾ã (åé ­ã¯"%s")
 %s: æä½ã¢ã¼ã"%s"ã¯ä¸æã§ã
 %s: ä¸æ­£ãªã·ã£ãããã¦ã³ã¢ã¼ã"%s"
 %s: ä¸æ­£ãªã·ã°ãã«å"%s"
 %s: ä¸æ­£ãªèµ·åã¿ã¤ã"%s"
 ãã³ã: "-m fast"ãªãã·ã§ã³ã¯ãã»ãã·ã§ã³åæ­ãå§ã¾ãã¾ã§å¾æ©ããã®ã§ã¯ãªã
å³åº§ã«ã»ãã·ã§ã³ãåæ­ãã¾ãã
 -Dãªãã·ã§ã³ã®çç¥æã¯PGDATAç°å¢å¤æ°ãä½¿ç¨ããã¾ãã
 ãµã¼ãã¼ãåä½ãã¦ãã¾ãã?
 ã·ã³ã°ã«ã¦ã¼ã¶ã¼ãµã¼ãã¼ãçµäºããã¦ãããååº¦å®è¡ãã¦ãã ãã
 ãµã¼ãã¼ã¯èµ·åããæ¥ç¶ãåãä»ãã¦ãã¾ã
 %2$sã«ã¯ãã­ã°ã©ã "%1$s"ãå¿è¦ã§ããã"%3$s"ã¨åããã£ã¬ã¯ããª
ã«ã¯ããã¾ããã§ããã
ã¤ã³ã¹ãã¼ã«ã®ç¶æãç¢ºèªãã¦ãã ããã
 "%2$s"ããã­ã°ã©ã "%1$s"ãè¦ã¤ãã¾ããããããã¯%3$sã¨åã
ãã¼ã¸ã§ã³ã§ã¯ããã¾ããã§ããã
ã¤ã³ã¹ãã¼ã«ã®ç¶æãç¢ºèªãã¦ãã ããã
 ãµã¼ãã¼ã®èµ·åå¾æ©ãã¿ã¤ã ã¢ã¦ããã¾ãã
 è©³ç´°ã¯"%s --help"ã§ç¢ºèªãã¦ãã ããã
 ä½¿ç¨æ¹æ³:
 è­¦å: ãªã³ã©ã¤ã³ããã¯ã¢ããã¢ã¼ããå®è¡ä¸­ã§ãã
pg_stop_backup()ãå¼ã³åºãããã¾ã§ã·ã£ãããã¦ã³ã¯å®äºãã¾ãã

 ãµã¼ãã¼ã®èµ·åå®äºãå¾ã£ã¦ãã¾ã...
 nullãã¤ã³ã¿ã¯è¤è£½ã§ãã¾ãã (åé¨ã¨ã©ã¼)
 å­ãã­ã»ã¹ãçµäºã³ã¼ã%dã§çµäºãã¾ãã å­ãã­ã»ã¹ã¯èªè­ã§ããªãã¹ãã¼ã¿ã¹%dã§çµäºãã¾ãã å­ãã­ã»ã¹ãä¾å¤0x%Xã§çµäºãã¾ãã å­ãã­ã»ã¹ã¯ã·ã°ãã«%dã«ããçµäºãã¾ãã: %s ã³ãã³ãã¯å®è¡å¯è½å½¢å¼ã§ã¯ããã¾ãã ã³ãã³ããè¦ã¤ããã¾ãã ãã£ã¬ã¯ããª"%s"ã«ç§»åã§ãã¾ããã§ãã: %m å®è¡å¯¾è±¡ã®"%s"ãè¦ã¤ããã¾ããã§ãã ç¾å¨ã®ä½æ¥­ãã£ã¬ã¯ããªãåå¾ã§ãã¾ããã§ãã: %s
 ã«ã¬ã³ããã£ã¬ã¯ããªãç¢ºèªã§ãã¾ããã§ãã: %m ãã¤ããª"%s"ãèª­ã¿åãã¾ããã§ãã ã·ã³ããªãã¯ãªã³ã¯"%s"ãèª­ãã¾ããã§ãã: %m ä¸æ­£ãªãã¤ããª"%s" ã¡ã¢ãªä¸è¶³ ã¡ã¢ãªä¸è¶³
 ãµã¼ãã¼ã¯ææ ¼ãã¾ãã
 ãµã¼ãã¼ãææ ¼ä¸­ã§ã
 ãµã¼ãã¼ã®åæ­¢ä¸­ã§ã
 ãµã¼ãã¼ã«ã·ã°ãã«ãéä¿¡ãã¾ãã
 ãµã¼ãã¼ãã­ã°ã­ã¼ãã¼ããã·ã°ãã«ããã¾ãã
 ãµã¼ãã¼èµ·åå®äº
 ãµã¼ãã¼ã¯èµ·åä¸­ã§ãã
 ãµã¼ãã¼ã¯åæ­¢ãã¾ãã
 ã¨ã«ãããµã¼ãã¼ãèµ·åãã¦ãã¾ã
 ã¨ã«ãããµã¼ãã¼ã®èµ·åãè©¦ã¿ã¾ã
 ãµã¼ãã¼ã®ææ ¼ãå¾ã£ã¦ãã¾ã... ãµã¼ãã¼åæ­¢å¦çã®å®äºãå¾ã£ã¦ãã¾ã... ãµã¼ãã¼ã®èµ·åå®äºãå¾ã£ã¦ãã¾ã... 