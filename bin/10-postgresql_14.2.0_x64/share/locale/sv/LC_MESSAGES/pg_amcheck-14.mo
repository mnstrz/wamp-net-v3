��    ^           �      �      �          0     A     X     r  S   �  H   �  V   !	  =   x	  A   �	  U   �	  Z   N
  K   �
  M   �
  I   C  I   �  T   �  T   ,     �  <   �  D   �  B     <   a  D   �  B   �  A   &  :   h  H   �  8   �  6   %  =   \  M   �  K   �  ;   4  U   p  7   �  =   �  ;   <  :   x  8   �  <   �  ,   )  0   V  7   �     �  <   �     �  +        ?     T  &   t     �     �  V   �  )     9   =     w     �     �  /   �     �             *   ?     j     r  :   z  ,   �  !   �       ;        X  :   p  :   �     �            '   +  /   S     �  %   �     �  .   �  #     *   (     S     d     r  0   �     �  /   �  	   �  �    (   �     �     �     �  $        )  W   G  F   �  R   �  D   9  <   ~  `   �  h     G   �  Q   �  \     S   |  b   �  W   3     �  C   �  I   �  C   4   <   x   J   �   G    !  G   H!  B   �!  J   �!  ?   "  =   ^"  D   �"  J   �"  L   ,#  >   y#  L   �#  7   $  E   =$  B   �$  B   �$  :   	%  <   D%  -   �%  1   �%  8   �%     &  L   &     j&  .   �&  "   �&  -   �&  /   '     1'     ?'  X   X'  /   �'  ;   �'  #   (  #   A(     e(  2   w(     �(  "   �(  %   �(  3   )     8)     >)  :   G)  -   �)  "   �)     �)  <   �)     )*  9   @*  :   z*  !   �*     �*     �*  9   �*  E   8+     ~+  <   �+  %   �+  <    ,  7   =,  +   u,     �,     �,     �,  7   �,  #   -  3   6-  	   j-        *                 .   R   >      +             	       O       J                [      N   (   /   8   ,       $         )          I   -   A      7   3   G      D       
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
POT-Creation-Date: 2021-11-06 21:17+0000
PO-Revision-Date: 2021-11-07 06:41+0100
Last-Translator: Dennis Björklund <db@zigo.dhs.org>
Language-Team: Swedish <pgsql-translators@postgresql.org>
Language: sv
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
 
Flaggor för kontroll av B-tree-index:
 
Flaggor för anslutning:
 
Andra flaggor:
 
Rapportera fel till <%s>.
 
Flaggor för kontroll av tabeller:
 
Flaggor för destinationen:
       --endblock=BLOCK            kontrollera tabell(er) fram till angivet blocknummer
       --exclude-toast-pointers    följ INTE relationers TOAST-pekare
       --heapallindexed            kontrollera att alla heap-tupler hittas i index
       --install-missing           installera utökningar som saknas
       --maintenance-db=DBNAMN     val av underhållsdatabas
       --no-dependent-indexes      expandera INTE listan med relationer för att inkludera index
       --no-dependent-toast        expandera inte listan av relationer för att inkludera TOAST-tabeller
       --no-strict-names           kräv INTE mallar för matcha objekt
       --on-error-stop             sluta kontrollera efter första korrupta sidan
       --parent-check              kontrollera förhållandet mellan barn/förälder i index
       --rootdescend               sök från root-sidan för att återfinna tupler
       --skip=FLAGGA               kontrollera INTE block som är "all-frozen" eller "all-visible"
       --startblock=BLOCK          börja kontollera tabell(er) vid angivet blocknummer
   %s [FLAGGA]... [DBNAMN]
   -?, --help                      visa denna hjälp, avsluta sedan
   -D, --exclude-database=MALL     kontrollera INTE matchande databas(er)
   -I, --exclude-index=MALL        kontrollera INTE matchande index
   -P, --progress                  visa förloppsinformation
   -R, --exclude-relation=MALL     kontrollera INTE matchande relation(er)
   -S, --exclude-schema=MALL       kontrollera INTE matchande schema(n)
   -T, --exclude-table=MALL        kontollera INTE matchande tabell(er)
   -U, --username=ANVÄNDARE         användarnamn att ansluta som
   -V, --version                   visa versionsinformation, avsluta sedan
   -W, --password                  tvinga fram lösenordsfråga
   -a, --all                       kontrollera alla databaser
   -d, --database=MALL             kontrollera matchande databas(er)
   -e, --echo                      visa kommandon som skickas till servern
   -h, --host=VÄRDNAMN             databasens värdnamn eller socketkatalog
   -i, --index=MALL                kontrollera matchande index
   -j, --jobs=NUM                  antal samtidiga anslutningar till servern
   -p, --port=PORT                 databasserverns port
   -r, --relation=MALL             kontrollera matchande relation(er)
   -s, --schema=MALL               kontrollera matchande schema(n)
   -t, --table=MALL                kontollera matchande tabell(er)
   -v, --verbose                   skriv massor med utdata
   -w, --no-password               fråga ej efter lösenord
 %*s/%s relationer (%d%%), %*s/%s sidor (%d%%) %*s/%s relationer (%d%%), %*s/%s sidor (%d%%) %*s %*s/%s relationer (%d%%), %*s/%s sidor (%d%%) (%s%-*.*s) %s %s kontrollerar objekt i en PostgreSQL-database för att hitta korruption.

 hemsida för %s: <%s>
 Är versionerna på %s och amcheck kompatibla? Förfrågan om avbrytning skickad
 Kunde inte skicka förfrågan om avbrytning:  Försök med "%s --help" för mer information.
 Användning:
 btree-index "%s.%s.%s":
 btree-index "%s.%s.%s": kontrollfunktion för btree returnerade oväntat antal rader: %d kan inte ange databasnamn tillsammans med --all kan inte ange både ett databasnamn och ett databasmönster kontrollerar btree-index "%s.%s.%s" kontrollerar heap-tabell "%s.%s.%s" kommandot var: %s kunde inte ansluta till databas %s: slut på minne databas "%s": %s slutblocket utanför giltig gräns slutblocket kommer före startblocket fel vid skickande av kommando till databas "%s": %s fel:  fatalt:  heap-tabell "%s.%s.%s", block %s, offset %s, attribut %s:
 heap-tabell "%s.%s.%s", block %s, offset %s:
 heap-tabell "%s.%s.%s", block %s:
 heap-tabell "%s.%s.%s":
 i databas "%s": använder amcheck version "%s" i schema "%s" inkludera databas "%s" internt fel: tog emot oväntat pattern_id %d för databas internt fel: tog emot oväntat pattern_id %d för relation ogiltigt argument för flaggan %s ogiltigt slutblock ogiltigt startblock finns inga btree-index för att kontrollera matching "%s" finns inga anslutningsbara databaser att kontrollera som matchar "%s" inga databaser att kontrollera finns inga heap-tabeller för att kontrollera matchning "%s" finns inga relationer att kontrollera finns inga relationer att kontrollera i schemamatchning "%s" finns inga relations för att kontrollera matching "%s" antalet parallella jobb måste vara minst 1 fråga misslyckades: %s frågan var: %s frågan var: %s
 hoppar över databas "%s": amcheck är inte installerad startblocket utanför giltig gräns för många kommandoradsargument (första är "%s") varning:  