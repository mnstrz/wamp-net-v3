��    ^           �      �      �          0     A     X     r  S   �  H   �  V   !	  =   x	  A   �	  U   �	  Z   N
  K   �
  M   �
  I   C  I   �  T   �  T   ,     �  <   �  D   �  B     <   a  D   �  B   �  A   &  :   h  H   �  8   �  6   %  =   \  M   �  K   �  ;   4  U   p  7   �  =   �  ;   <  :   x  8   �  <   �  ,   )  0   V  7   �     �  <   �     �  +        ?     T  &   t     �     �  V   �  )     9   =     w     �     �  /   �     �             *   ?     j     r  :   z  ,   �  !   �       ;        X  :   p  :   �     �            '   +  /   S     �  %   �     �  .   �  #     *   (     S     d     r  0   �     �  /   �  	   �  W    ,   ^     �     �     �  '   �     �  x     D   �  �   �  D   l  ?   �  }   �  }   o  }   �  ~   k  w   �  {   b  �   �  �   a      �   @   �   K   ?!  J   �!  8   �!  O   "  M   _"  L   �"  E   �"  @   @#  C   �#  ;   �#  D   $  M   F$  O   �$  C   �$  z   (%  F   �%  H   �%  F   3&  E   z&  /   �&  C   �&  ,   4'  0   a'  7   �'     �'  b   �'     0(  =   M(     �(  .   �(  2   �(     )  /   )  w   F)  <   �)  ]   �)  -   Y*  -   �*     �*  D   �*     +     1+  *   N+  E   y+  	   �+     �+  @   �+  3   ,  %   G,     m,  i   �,  *   �,  >   -  B   ^-  "   �-     �-     �-  8   �-  J   *.  $   u.  8   �.     �.  H   �.  6   9/  @   p/     �/     �/     �/  5   �/     30  B   S0     �0        *                 .   R   >      +             	       O       J                [      N   (   /   8   ,       $         )          I   -   A      7   3   G      D       
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
POT-Creation-Date: 2021-08-30 20:48+0000
PO-Revision-Date: 2021-08-31 17:05+0200
Last-Translator: 
Language-Team: 
Language: fr
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Generator: Poedit 3.0
 
Options de vérification des index Btree :
 
Options de connexion :
 
Autres options :
 
Rapporter les bogues à <%s>.
 
Options de vérification des tables :
 
Options de la cible :
       --endblock=BLOC            vérifie les tables jusqu'au numéro de bloc
                                 indiqué
       --exclude-toast-pointers   ne suit PAS les pointeurs de TOAST
       --heapallindexed           vérifie que tous les enregistrements de la
                                 table sont référencés dans les index
       --install-missing          installe les extensions manquantes
       --maintenance-db=BASE      change la base de maintenance
       --no-dependent-indexes     n'étend PAS la liste des relations pour inclure
                                 les index
       --no-dependent-toast       n'étend PAS la liste des relations pour inclure
                                 les TOAST
       --no-strict-names          ne requiert PAS que les motifs correspondent à
                                 des objets
       --on-error-stop            arrête la vérification à la fin du premier bloc
                                 corrompu
       --parent-check             vérifie les relations parent/enfants dans les
                                 index
       --rootdescend              recherche à partir de la racine pour trouver
                                 les lignes
       --skip=OPTION              ne vérifie PAS les blocs « all-frozen » et
                                 « all-visible »
       --startblock=BLOC          commence la vérification des tables au numéro
                                 de bloc indiqué
   %s [OPTION]... [BASE]
   -?, --help                     affiche cette aide puis quitte
   -D, --exclude-database=MOTIF   ne vérifie PAS les bases correspondantes
   -I, --exclude-index=MOTIF      ne vérifie PAS les index correspondants
   -P, --progress                 affiche la progression
   -R, --exclude-relation=MOTIF   ne vérifie PAS les relations correspondantes
   -S, --exclude-schema=MOTIF     ne vérifie PAS les schémas correspondants
   -T, --exclude-table=MOTIF      ne vérifie PAS les tables correspondantes
   -U, --username=UTILISATEUR     nom d'utilisateur pour la connexion
   -V, --version                  affiche la version puis quitte
   -W, --password                 force la saisie d'un mot de passe
   -a, --all                      vérifie toutes les bases
   -d, --database=MOTIF           vérifie les bases correspondantes
   -e, --echo                      affiche les commandes envoyées au serveur
   -h, --host=HÔTE                IP/alias du serveur ou répertoire du socket
   -i, --index=MOTIF              vérifie les index correspondants
   -j, --jobs=NOMBRE              utilise ce nombre de connexions simultanées au
                                 serveur
   -p, --port=PORT                port du serveur de bases de données
   -r, --relation=MOTIF           vérifie les relations correspondantes
   -s, --schema=MOTIF             vérifie les schémas correspondants
   -t, --table=MOTIF              vérifie les tables correspondantes
   -v, --verbose                   mode verbeux
   -w, --no-password              ne demande jamais un mot de passe
 relations %*s/%s (%d%%), blocs %*s/%s (%d%%) relations %*s/%s (%d%%), blocs %*s/%s (%d%%) %*s relations %*s/%s (%d%%), blocs %*s/%s (%d%%) (%s%-*.*s) %s %s utilise le module amcheck pour vérifier si les objets d' une base
PostgreSQL sont corrompus.

 Page d'accueil de %s : <%s>
 est-ce que les versions de %s et d'amcheck sont compatibles ? Requête d'annulation envoyée
 N'a pas pu envoyer la requête d'annulation :  Essayez « %s --help » pour plus d'informations.
 Usage :
 vérification de l'index btree« %s %s.%s » :
 index btree « %s.%s.%s » : la fonction de vérification des index btree a renvoyé un nombre de lignes inattendu : %d ne peut pas spécifier un nom de base de données avec --all ne peut pas spécifier à la fois le nom d'une base de données et des motifs de noms de base vérification de l'index btree « %s %s.%s » vérification de la table heap « %s %s.%s » la commande était : %s n'a pas pu se connecter à la base de données %s : plus de mémoire base de données « %s » : %s bloc de fin hors des limites le bloc de fin précède le bloc de début erreur de l'envoi d'une commande à la base de données « %s » : %s erreur :  fatal :  table heap « %s.%s.%s », bloc %s, décalage %s, attribut %s :
 table heap « %s.%s.%s », bloc %s, décalage %s :
 table heap « %s %s.%s », bloc %s :
 table heap « %s %s.%s » :
 dans la base de données « %s » : utilisation de la version « %s » d'amcheck dans le schéma « %s » en incluant la base de données : « %s » erreur interne : a reçu un pattern_id %d inattendu de la base erreur interne : a reçu un pattern_id %d inattendu de la relation argument invalide pour l'option %s bloc de fin invalide bloc de début invalide aucun index btree à vérifier correspondant à « %s » aucune base de données connectable à vérifier correspondant à « %s » aucune base de données à vérifier aucune table heap à vérifier correspondant à « %s » aucune relation à vérifier aucune relation à vérifier dans les schémas correspondant à « %s » aucune relation à vérifier correspondant à « %s » le nombre maximum de jobs en parallèle doit être au moins de 1 échec de la requête : %s la requête était : %s la requête était : %s
 ignore la base « %s » : amcheck n'est pas installé bloc de début hors des limites trop d'arguments en ligne de commande (le premier étant « %s ») attention :  