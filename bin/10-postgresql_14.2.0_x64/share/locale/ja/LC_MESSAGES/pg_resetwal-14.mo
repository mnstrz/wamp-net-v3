Þ    v      Ì     |      ð	     ñ	  9   
     E
  F   \
  =   £
  D   á
  I   &  ¾   p  A   /  ;   q  M   ­  K   û  K   G  0     =   Ä  ;     2   >     q  +        ±  )   Á  )   ë  )        ?  )   \  )     +   °  )   Ü  R     )   Y  )        ­  U   Ê  A      )   b  )     )   ¶  ,   à  )     )   7  )   a  )     )   µ  )   ß  )   	  )   3  )   ]  )     )   ±  )   Û  )     )   /  )   Y  )     )   ­  )   ×       )     )   B  )   l  )     	   À  )   Ê      ô  &     !   ¼  )   Þ       ,     *   L  A   w     ¹     Æ     Ï  @   ì  '   -  &   U  "   |  1        Ñ  7   ð  +   (  !   T  (   v       ,   ¼  :   é  !   $     F  0   c  8        Í  "   ë                    .     M  &   c  +     )   ¶     à     ü  -      >   .  )   m       ;     =   Ö       )   ±  /   Û  B     7   N  (        ¯  	   Ê  â  Ô     ·   p   Ï   -   @!  \   n!  G   Ë!  b   "  M   v"  é   Ä"  U   ®#  >   $  S   C$  d   $  \   ü$  5   Y%  O   %  L   ß%  >   ,&     k&  G   &     Ð&  F   â&  =   )'  ;   g'     £'  B   À'  >   (  ?   B(  :   (     ½(  ?   B)  6   )     ¹)  u   Ó)     I*  ;   Ê*  ;   +  ;   B+  >   ~+  >   ½+  ;   ü+  ;   8,  ;   t,  ;   °,  <   ì,  ;   )-  <   e-  ;   ¢-  <   Þ-  <   .  7   X.  :   .  0   Ë.  0   ü.  0   -/  2   ^/  0   /      Â/  1   ã/  0   0  1   F0  0   x0     ©0  A   »0    ý0  3   2  (   H2  8   q2  7   ª2  Q   â2  >   43  V   s3     Ê3  	   ×3  !   á3  l   4  B   p4  ;   ³4  A   ï4  Q   15  5   5  ]   ¹5  O   6  A   g6  M   ©6  ;   ÷6  W   37  A   7  ;   Í7  8   	8  D   B8  X   8  5   à8  <   9     S9     _9     t9  )   9  +   ±9  @   Ý9  N   :  0   m:  9   :     Ø:  I   ß:  P   );  0   z;     «;  Z   ²;  f   <  m   t<  7   â<  =   =  S   X=  G   ¬=  A   ô=  "   6>     Y>     <      j   Z       [   ]   T   8   o           i   m           ,       1   L   0             +   A   N   -   l   H   u      '      O                 7   &          V   S      n                 /           W   >   G   (   4   g   D              #   6           \   b       q   s      %   9       M       3   r          .   	   )   h   @      d           5   *       p   !   $   f                Y   
      ?           =   2                   t   J       B       P   k      e   X   ^       c   C   F           a   Q   I         :   ;   v   R   U                      E          K   `   _       "    

Values to be changed:

 
If these values seem acceptable, use -f to force reset.
 
Report bugs to <%s>.
       --wal-segsize=SIZE           size of WAL segments, in megabytes
   -?, --help                       show this help, then exit
   -O, --multixact-offset=OFFSET    set next multitransaction offset
   -V, --version                    output version information, then exit
   -c, --commit-timestamp-ids=XID,XID
                                   set oldest and newest transactions bearing
                                   commit timestamp (zero means no change)
   -e, --epoch=XIDEPOCH             set next transaction ID epoch
   -f, --force                      force update to be done
   -l, --next-wal-file=WALFILE      set minimum starting location for new WAL
   -m, --multixact-ids=MXID,MXID    set next and oldest multitransaction ID
   -n, --dry-run                    no update, just show what would be done
   -o, --next-oid=OID               set next OID
   -u, --oldest-transaction-id=XID  set oldest transaction ID
   -x, --next-transaction-id=XID    set next transaction ID
  [-D, --pgdata=]DATADIR            data directory
 %s home page: <%s>
 %s resets the PostgreSQL write-ahead log.

 64-bit integers Blocks per segment of large relation: %u
 Bytes per WAL segment:                %u
 Catalog version number:               %u
 Current pg_control values:

 Data page checksum version:           %u
 Database block size:                  %u
 Database system identifier:           %llu
 Date/time type storage:               %s
 File "%s" contains "%s", which is not compatible with this program's version "%s". First log segment after reset:        %s
 Float8 argument passing:              %s
 Guessed pg_control values:

 If you are sure the data directory path is correct, execute
  touch %s
and try again. Is a server running?  If not, delete the lock file and try again. Latest checkpoint's NextMultiOffset:  %u
 Latest checkpoint's NextMultiXactId:  %u
 Latest checkpoint's NextOID:          %u
 Latest checkpoint's NextXID:          %u:%u
 Latest checkpoint's TimeLineID:       %u
 Latest checkpoint's full_page_writes: %s
 Latest checkpoint's newestCommitTsXid:%u
 Latest checkpoint's oldestActiveXID:  %u
 Latest checkpoint's oldestCommitTsXid:%u
 Latest checkpoint's oldestMulti's DB: %u
 Latest checkpoint's oldestMultiXid:   %u
 Latest checkpoint's oldestXID's DB:   %u
 Latest checkpoint's oldestXID:        %u
 Maximum columns in an index:          %u
 Maximum data alignment:               %u
 Maximum length of identifiers:        %u
 Maximum size of a TOAST chunk:        %u
 NextMultiOffset:                      %u
 NextMultiXactId:                      %u
 NextOID:                              %u
 NextXID epoch:                        %u
 NextXID:                              %u
 OID (-o) must not be 0 OldestMulti's DB:                     %u
 OldestMultiXid:                       %u
 OldestXID's DB:                       %u
 OldestXID:                            %u
 Options:
 Size of a large-object chunk:         %u
 The database server was not shut down cleanly.
Resetting the write-ahead log might cause data to be lost.
If you want to proceed anyway, use -f to force reset.
 Try "%s --help" for more information.
 Usage:
  %s [OPTION]... DATADIR

 WAL block size:                       %u
 Write-ahead log reset
 You must run %s as the PostgreSQL superuser. argument of --wal-segsize must be a number argument of --wal-segsize must be a power of 2 between 1 and 1024 by reference by value cannot be executed by "root" cannot create restricted tokens on this platform: error code %lu could not allocate SIDs: error code %lu could not change directory to "%s": %m could not close directory "%s": %m could not create restricted token: error code %lu could not delete file "%s": %m could not get exit code from subprocess: error code %lu could not load library "%s": error code %lu could not open directory "%s": %m could not open file "%s" for reading: %m could not open file "%s": %m could not open process token: error code %lu could not re-execute with restricted token: error code %lu could not read directory "%s": %m could not read file "%s": %m could not read permissions of directory "%s": %m could not start process for command "%s": error code %lu could not write file "%s": %m data directory is of wrong version error:  fatal:  fsync error: %m invalid argument for option %s lock file "%s" exists multitransaction ID (-m) must not be 0 multitransaction offset (-O) must not be -1 newestCommitTsXid:                    %u
 no data directory specified off oldest multitransaction ID (-m) must not be 0 oldest transaction ID (-u) must be greater than or equal to %u oldestCommitTsXid:                    %u
 on pg_control exists but has invalid CRC; proceed with caution pg_control exists but is broken or wrong version; ignoring it pg_control specifies invalid WAL segment size (%d byte); proceed with caution pg_control specifies invalid WAL segment size (%d bytes); proceed with caution pg_control version number:            %u
 too many command-line arguments (first is "%s") transaction ID (-c) must be either 0 or greater than or equal to 2 transaction ID (-x) must be greater than or equal to %u transaction ID epoch (-e) must not be -1 unexpected empty file "%s" warning:  Project-Id-Version: pg_resetwal (PostgreSQL 13)
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2021-08-25 17:22+0900
PO-Revision-Date: 2021-08-25 11:21+0900
Last-Translator: Kyotaro Horiguchi <horikyota.ntt@gmail.com>
Language-Team: Japan PostgreSQL Users Group <jpug-doc@ml.postgresql.jp>
Language: ja
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=1; plural=0;
X-Generator: Poedit 1.8.13
 

å¤æ´ãããå¤:

 
ãã®å¤ãé©åã ã¨æãããã®ã§ããã°ã-fãä½¿ç¨ãã¦å¼·å¶ãªã»ãããã¦ãã ããã
 
ãã°ã¯<%s>ã«å ±åãã¦ãã ããã
       --wal-segsize=SIZE          WALã»ã°ã¡ã³ãã®ãµã¤ãºãåä½ã¯ã¡ã¬ãã¤ã
   -?, --help                      ãã®ãã«ããè¡¨ç¤ºãã¦çµäº
   -O, --multixact-offset=OFFSET   æ¬¡ã®ãã«ããã©ã³ã¶ã¯ã·ã§ã³ãªãã»ãããè¨­å®
   -V, --version                   ãã¼ã¸ã§ã³æå ±ãè¡¨ç¤ºãã¦çµäº
   -c, --commit-timestamp-ids=XID,XID
                                  ã³ãããã¿ã¤ã ã¹ã¿ã³ããæã¤æå¤ã¨ææ°ã®
                                  ãã©ã³ã¶ã¯ã·ã§ã³(0ã¯å¤æ´ããªããã¨ãæå³ãã)
   -e, --epoch=XIDEPOCH            æ¬¡ã®ãã©ã³ã¶ã¯ã·ã§ã³IDã®åºç¹ãè¨­å®
   -f, --force                     å¼·å¶çã«æ´æ°ãå®æ½
   -l, --next-wal-file=WALFILE     æ°ããWALã®æå°éå§ãã¤ã³ããè¨­å®
   -m, --multixact-ids=MXID,MXID   æ¬¡ããã³æå¤ã®ãã«ããã©ã³ã¶ã¯ã·ã§ã³IDãè¨­å®
   -n, --dry-run                   æ´æ°ããããåã«ä½ãè¡ãªãããããè¡¨ç¤º
   -o, --next-oid=OID              æ¬¡ã®OIDãè¨­å®
   -u, --oldest-transaction-id=XID æå¤ã®ãã©ã³ã¶ã¯ã·ã§ã³IDãè¨­å®
   -x, --next-transaction-id=XID   æ¬¡ã®ãã©ã³ã¶ã¯ã·ã§ã³IDãè¨­å®
  [-D, --pgdata=]DATADIR           ãã¼ã¿ãã£ã¬ã¯ããª
 %s ãã¼ã ãã¼ã¸: <%s>
 %sã¯PostgreSQLã®åè¡æ¸ãè¾¼ã¿ã­ã°ããªã»ãããã¾ãã

 64ãããæ´æ° å¤§ããªãªã¬ã¼ã·ã§ã³ã®ã»ã°ã¡ã³ãæ¯ã®ãã­ãã¯æ°:%u
 WALã»ã°ã¡ã³ãå½ããã®ãã¤ãæ°:               %u
 ã«ã¿ã­ã°ãã¼ã¸ã§ã³çªå·:                      %u
 ç¾å¨ã®pg_controlã®å¤:

 ãã¼ã¿ãã¼ã¸ãã§ãã¯ãµã ã®ãã¼ã¸ã§ã³:        %u
 ãã¼ã¿ãã¼ã¹ã®ãã­ãã¯ãµã¤ãº:                %u
 ãã¼ã¿ãã¼ã¹ã·ã¹ãã è­å¥å­:                  %llu
 æ¥ä»/æå»åã®æ ¼ç´æ¹å¼:                       %s
 ãã¡ã¤ã«"%s"ã§ã¯"%s"ã¨ãªã£ã¦ãã¾ããããã¯ãã®ãã­ã°ã©ã ã®ãã¼ã¸ã§ã³"%s"ã¨äºææ§ãããã¾ãã ãªã»ããå¾æåã®ã­ã°ã»ã°ã¡ã³ã:              %s
 Float8å¼æ°ã®æ¸¡ãæ¹:                          %s
 pg_controlã®æ¨æ¸¬å¤:

 ç¢ºå®ã«ãã¼ã¿ãã£ã¬ã¯ããªã®ãã¹ãæ­£ãããã°ã
  touch %s
ã®å¾ã«åå®è¡ãã¦ãã ããã ãµã¼ãã¼ãç¨¼åãã¦ãã¾ããã? ããã§ãªããã°ã­ãã¯ãã¡ã¤ã«ãåé¤ãåå®è¡ãã¦ãã ããã æçµãã§ãã¯ãã¤ã³ãã®NextMultiOffset:       %u
 æçµãã§ãã¯ãã¤ã³ãã®NextMultiXactId:       %u
 æçµãã§ãã¯ãã¤ã³ãã®NextOID:               %u
 æçµãã§ãã¯ãã¤ã³ãã®NextXID:               %u:%u
 æçµãã§ãã¯ãã¤ã³ãã®æç³»åID:              %u
 æçµãã§ãã¯ãã¤ã³ãã®full_page_writes:      %s
 æçµãã§ãã¯ãã¤ã³ãã®newestCommitTsXid:     %u
 æçµãã§ãã¯ãã¤ã³ãã®oldestActiveXID:       %u
 æçµãã§ãã¯ãã¤ã³ãã®oldestCommitTsXid:     %u
 æçµãã§ãã¯ãã¤ã³ãã®oldestMultiã®DB:       %u
 æçµãã§ãã¯ãã¤ã³ãã®oldestMultiXid:        %u
 æçµãã§ãã¯ãã¤ã³ãã®oldestXIDã®DB:         %u
 æçµãã§ãã¯ãã¤ã³ãã®oldestXID:             %u
 ã¤ã³ããã¯ã¹åã®æå¤§åæ°:                    %u
 æå¤§ãã¼ã¿ã¢ã©ã¤ã³ã¡ã³ã:                    %u
 è­å¥å­ã®æå¤§é·:                              %u
 TOASTãã£ã³ã¯ã®æå¤§ãµã¤ãº:                   %u
 NextMultiOffset:                             %u
 NextMultiXactId:                             %u
 NextOID:                                     %u
 NextXIDåºç¹:                                 %u
 NextXID:                                     %u
 OID(-o)ã¯0ã«ã¯ã§ãã¾ãã OldestMultiã®DB:                             %u
 OldestMultiXid:                              %u
 OldestXIDã®DB:                               %u
 OldestXID:                                   %u
 ãªãã·ã§ã³:
 ã©ã¼ã¸ãªãã¸ã§ã¯ããã£ã³ã¯ã®ãµã¤ãº:          %u
 ãã¼ã¿ãã¼ã¹ãµã¼ãã¼ãæ­£ããã·ã£ãããã¦ã³ããã¦ãã¾ããã§ããã
åè¡æ¸ãè¾¼ã¿ã­ã°ã®ãªã»ããã«ã¯ãã¼ã¿æå¤±ã®æããããã¾ãã
ã¨ã«ããå¦çãããã®ã§ããã°ã-fã§ãªã»ãããå¼·å¶ãã¦ãã ããã
 è©³ç´°ã¯"%s --help"ã§ç¢ºèªãã¦ãã ããã
 ä½¿ç¨æ¹æ³:
  %s [OPTION]... DATADIR

 WALã®ãã­ãã¯ãµã¤ãº:                         %u
 åè¡æ¸ãè¾¼ã¿ã­ã°ããªã»ããããã¾ãã
 PostgreSQLã®ã¹ã¼ãã¼ã¦ã¼ã¶ã¼ã§%sãå®è¡ããªããã°ãªãã¾ãã --wal-segsize ã®å¼æ°ã¯æ°å¤ã§ãªããã°ãªãã¾ãã --wal-segsize ã®å¼æ°ã¯1ãã1024ã®éã®2ã®åæ°ã§ãªããã°ãªãã¾ãã åç§æ¸¡ã å¤æ¸¡ã "root"ã§ã¯å®è¡ã§ãã¾ãã ãã®ãã©ãããã©ã¼ã ã§ã¯å¶éä»ããã¼ã¯ã³ãçæã§ãã¾ãã: ã¨ã©ã¼ã³ã¼ã %lu SIDãå²ãå½ã¦ããã¾ããã§ãã: ã¨ã©ã¼ã³ã¼ã %lu ãã£ã¬ã¯ããª"%s"ã«ç§»åã§ãã¾ããã§ãã: %m ãã£ã¬ã¯ããª"%s"ãã¯ã­ã¼ãºã§ãã¾ããã§ãã: %m å¶éä»ããã¼ã¯ã³ãçæã§ãã¾ããã§ãã: ã¨ã©ã¼ã³ã¼ã %lu ãã¡ã¤ã«"%s"ãåé¤ã§ãã¾ããã§ãã: %m ãµããã­ã»ã¹ã®çµäºã³ã¼ããåå¾ã§ãã¾ããã§ãã: ã¨ã©ã¼ã³ã¼ã %lu ã©ã¤ãã©ãª"%s"ãã­ã¼ãã§ãã¾ããã§ãã: ã¨ã©ã¼ã³ã¼ã %lu ãã£ã¬ã¯ããª"%s"ããªã¼ãã³ã§ãã¾ããã§ãã: %m ãã¡ã¤ã«"%s"ãèª­ã¿åãç¨ã«ãªã¼ãã³ã§ãã¾ããã§ãã: %m ãã¡ã¤ã«"%s"ããªã¼ãã³ã§ãã¾ããã§ãã: %m ãã­ã»ã¹ãã¼ã¯ã³ããªã¼ãã³ã§ãã¾ããã§ãã: ã¨ã©ã¼ã³ã¼ã %lu å¶éä»ããã¼ã¯ã³ã§åå®è¡ã§ãã¾ããã§ãã: %lu ãã£ã¬ã¯ããª"%s"ãèª­ã¿åãã¾ããã§ãã: %m ãã¡ã¤ã«"%s"ã®èª­ã¿åãã«å¤±æãã¾ãã: %m ãã£ã¬ã¯ããª"%s"ã®æ¨©éãèª­ã¿åãã¾ããã§ãã: %m ã³ãã³ã"%s"ã®ãã­ã»ã¹ãèµ·åã§ãã¾ããã§ãã: ã¨ã©ã¼ã³ã¼ã %lu ãã¡ã¤ã«"%s"ãæ¸ãåºãã¾ããã§ãã: %m ãã¼ã¿ãã£ã¬ã¯ããªã®ãã¼ã¸ã§ã³ãéãã¾ã ã¨ã©ã¼:  è´å½çã¨ã©ã¼:  fsyncã¨ã©ã¼: %m ãªãã·ã§ã³%sã®å¼æ°ãä¸æ­£ã§ã ã­ãã¯ãã¡ã¤ã«"%s"ãå­å¨ãã¾ã ãã«ããã©ã³ã¶ã¯ã·ã§ã³ID(-m)ã¯0ã«ã¯ã§ãã¾ãã ãã«ããã©ã³ã¶ã¯ã·ã§ã³ãªãã»ãã(-O)ã¯-1ã«ã¯ã§ãã¾ãã newestCommitTsXid:                           %u
 ãã¼ã¿ãã£ã¬ã¯ããªãæå®ããã¦ãã¾ãã ãªã æå¤ã®ãã«ããã©ã³ã¶ã¯ã·ã§ã³ID(-m)ã¯0ã«ã¯ã§ãã¾ãã æå¤ã®ãã©ã³ã¶ã¯ã·ã§ã³ID(-u)ã¯%uä»¥ä¸ã§ãªããã°ãªãã¾ãã oldestCommitTsXid:                           %u
 ãªã³ pg_controlãããã¾ããããCRCãä¸æ­£ã§ãã; æ³¨æãã¦é²ãã¦ãã ãã pg_controlãããã¾ããããç ´æãããã¯ééã£ããã¼ã¸ã§ã³ã§ã; ç¡è¦ãã¾ã pg_controlã«ããWALã»ã°ã¡ã³ããµã¤ãº(%dãã¤ã)ã¯ä¸æ­£ã§ã; æ³¨æãã¦é²ãã¦ãã ãã pg_controlãã¼ã¸ã§ã³çªå·:                    %u
 ã³ãã³ãã©ã¤ã³å¼æ°ãå¤ããã¾ã (åé ­ã¯"%s") ãã©ã³ã¶ã¯ã·ã§ã³ID(-c)ã¯0ãããã¯2ä»¥ä¸ã§ãªããã°ãªãã¾ãã ãã©ã³ã¶ã¯ã·ã§ã³ID(-x)ã¯%uä»¥ä¸ã§ãªããã°ãªãã¾ãã ãã©ã³ã¶ã¯ã·ã§ã³IDã®åºç¹(-e)ã¯-1ã«ã¯ã§ãã¾ãã æ³å®å¤ã®ç©ºã®ãã¡ã¤ã«"%s" è­¦å:  