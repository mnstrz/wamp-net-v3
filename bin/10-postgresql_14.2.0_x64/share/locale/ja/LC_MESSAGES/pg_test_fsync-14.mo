Þ          ì   %   ¼      P  1   Q  2     /   ¶     æ  8        :     T     o          ¥  (   Å  U   î  [   D  K      c   ì     P  .   k  E     &   à  +        3     N     [     _     d  §  q  M     M   g  @   µ     ö  t   	     	     ¨	     Å	     â	  &   ÿ	     &
      C
     ä
  P   q  ­   Â     p  ^     w   ì  3   d  D     9   Ý          &     3     A                      
              	                                                                                         
Compare file sync methods using one %dkB write:
 
Compare file sync methods using two %dkB writes:
 
Compare open_sync with different write sizes:
 
Non-sync'ed %dkB writes:
 
Test if fsync on non-write file descriptor is honored:
  1 * 16kB open_sync write  2 *  8kB open_sync writes  4 *  4kB open_sync writes  8 *  2kB open_sync writes %13.3f ops/sec  %6.0f usecs/op
 %u second per test
 %u seconds per test
 (If the times are similar, fsync() can sync data written on a different
descriptor.)
 (This is designed to compare the cost of writing 16kB in different write
open_sync sizes.)
 (in wal_sync_method preference order, except fdatasync is Linux's default)
 * This file system and its mount options do not support direct
  I/O, e.g. ext4 in journaled mode.
 16 *  1kB open_sync writes Direct I/O is not supported on this platform.
 O_DIRECT supported on this platform for open_datasync and open_sync.
 Try "%s --help" for more information.
 Usage: %s [-f FILENAME] [-s SECS-PER-TEST]
 could not open output file fsync failed n/a n/a* write failed Project-Id-Version: pg_test_fsync (PostgreSQL) 10
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2021-08-25 17:22+0900
PO-Revision-Date: 2021-05-17 14:56+0900
Last-Translator: Michihide Hotta <hotta@net-newbie.com>
Language-Team: 
Language: ja
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=1; plural=0;
X-Generator: Poedit 1.8.13
 
%dkBã®æ¸è¾¼ã¿ã1åè¡ã£ã¦ãã¡ã¤ã«åææ¹æ³ãæ¯è¼ãã¾ã:
 
%dkBã®æ¸è¾¼ã¿ã2åè¡ã£ã¦ãã¡ã¤ã«åææ¹æ³ãæ¯è¼ãã¾ã:
 
open_sync ãç°ãªã£ãæ¸è¾¼ã¿ãµã¤ãºã§æ¯è¼ãã¾ã:
 
%dkBã®åæãªãæ¸è¾¼ã¿:
 
æ¸ãè¾¼ã¿ã®ãªãã®ãã¡ã¤ã«ãã£ã¹ã¯ãªãã¿ä¸ã®fsyncãç¡è¦ãããªããããã¹ããã¾ã:
  1 * 16kB open_syncæ¸è¾¼ã¿  2 *  8kB open_syncæ¸è¾¼ã¿  4 *  4kB open_syncæ¸è¾¼ã¿  8 *  2kB open_syncæ¸è¾¼ã¿ %13.3f æä½/ç§  %6.0f Î¼ç§/æä½
 ãã¹ã1ä»¶ããã%uç§
 ï¼ããå®è¡æéãåç­ã§ããã°ãfsync()ã¯ç°ãªã£ããã¡ã¤ã«ãã£ã¹ã¯ãªãã¿ä¸ã§
ãã¼ã¿ãsyncã§ãããã¨ã«ãªãã¾ããï¼
 (ããã¯open_syncã®æ¸è¾¼ã¿ãµã¤ãºãå¤ããªããã16kBã®æ¸è¾¼ã¿ã®ã³ã¹ããæ¯è¼ãã
ããæå®ããã¦ãã¾ãã)
 (Linuxã®ããã©ã«ãã§ããfdatasyncãé¤ãwal_sync_methodã®åªåé )
 * ãã®ãã¡ã¤ã«ã·ã¹ãã ã¨ãã®ãã¦ã³ããªãã·ã§ã³ã§ã¯ãã¤ã¬ã¯ãI/Oããµãã¼ã
  ãã¦ãã¾ãããä¾ï¼ã¸ã£ã¼ãã«ã¢ã¼ãã® ext4ã
 16 *  1kB open_syncæ¸è¾¼ã¿ ãã®ãã©ãããã©ã¼ã ã§ã¯ãã¤ã¬ã¯ãI/Oããµãã¼ãããã¦ãã¾ããã
 ãã®ãã©ãããã©ã¼ã ã§ã¯open_datasyncã¨open_syncã«ã¤ãã¦O_DIRECTã
ãµãã¼ãããã¦ãã¾ãã
 è©³ç´°ã¯"%s --help"ã§ç¢ºèªãã¦ãã ããã
 ä½¿ç¨æ³: %s [-f ãã¡ã¤ã«å] [-s ãã¹ããããã®ç§æ°]
 åºåãã¡ã¤ã«ããªã¼ãã³ã§ãã¾ããã§ãã fsyncã«å¤±æ å©ç¨ä¸å¯ å©ç¨ä¸å¯* æ¸ãè¾¼ã¿ã«å¤±æ 