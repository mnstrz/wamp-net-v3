��    8      �  O   �      �  X   �  
   2     =  5   Y  P   �  5   �  A     :   X  2   �  1   �  G   �  3   @  *   t     �  T   �          "     6     J     h     �     �     �     �  k   �  &   V	     }	  a   �	     �	     
  ;   &
     b
  !   |
     �
  (   �
  3   �
       )   5  5   _  .   �  -   �  )   �  "        ?     G  3   O  +   �     �  2   �  !   �  )         J  /   a     �  	   �  �  �  I   C  	   �     �  9   �  @   �  .   .  <   ]  =   �  1   �  1   
  ?   <  1   |  (   �     �  K   �     =     N     a     s     �     �     �     �     �  Z     *   i     �  V   �     �  "     -   =     k     ~     �  +   �  C   �  "   &  ,   I  J   v  !   �  !   �  !        '     @     I  *   U  %   �     �  0   �     �  +        :  )   M     w     �     8          .   )                   !   #               /          4   (   *             ,       0       3      &                               7   6          1            2   '       $                          +              "              
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
 checksum verification failed in file "%s", block %u: calculated checksum %X but block contains %X checksums enabled in file "%s" checksums verified in file "%s" cluster is not compatible with this version of pg_checksums cluster must be shut down could not open directory "%s": %m could not open file "%s": %m could not read block %u in file "%s": %m could not read block %u in file "%s": read %d of %d could not stat file "%s": %m could not write block %u in file "%s": %m could not write block %u in file "%s": wrote %d of %d data checksums are already disabled in cluster data checksums are already enabled in cluster data checksums are not enabled in cluster database cluster is not compatible error:  fatal:  invalid filenode specification, must be numeric: %s invalid segment number %d in file name "%s" no data directory specified option -f/--filenode can only be used with --check pg_control CRC value is incorrect seek failed for block %u in file "%s": %m syncing data directory too many command-line arguments (first is "%s") updating control file warning:  Project-Id-Version: pg_checksums (PostgreSQL) 14
Report-Msgid-Bugs-To: pgsql-bugs@lists.postgresql.org
POT-Creation-Date: 2021-08-14 05:49+0000
PO-Revision-Date: 2021-08-14 16:00+0800
Last-Translator: Jie Zhang <zhangjie2@fujitsu.com>
Language-Team: Chinese (Simplified) <zhangjie2@fujitsu.com>
Language: zh_CN
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
 
如果没有指定数据目录(DATADIR), 将使用
环境变量PGDATA.

 
选项:
   %s [选项]... [DATADIR]
   -?, --help               显示此帮助, 然后退出
   -N, --no-sync            不用等待变化安全写入磁盘
   -P, --progress           显示进度信息
   -V, --version            输出版本信息, 然后退出
   -c, --check              检查数据校验和（默认）
   -d, --disable            禁用数据校验和
   -e, --enable             启用数据校验和
   -f, --filenode=FILENODE  仅检查与指定filenode的关系
   -v, --verbose            输出详细的消息
  [-D, --pgdata=]DATADIR    数据目录
 已计算%*s/%s MB (%d%%) %s启用、禁用或验证PostgreSQL数据库群集中的数据校验和.

 %s 主页: <%s>
 坏校验和:  %s
 扫描的块: %s
 校验和操作已完成
 在群集中禁用校验和
 群集中启用的校验和
 数据校验和版本: %u
 扫描的文件:  %s
 臭虫报告至<%s>.
 数据库群集是用块大小%u初始化的，但pg_checksums是用块大小%u编译的.
 请用 "%s --help" 获取更多的信息.
 使用方法:
 校验和验证在文件"%s"中失败，块%u:计算的校验和 %X ，但块包含 %X 文件"%s"中启用的校验和 在文件"%s"中验证的校验和 群集与此版本的pg_checksums不兼容” 必须关闭群集 无法打开目录 "%s": %m 无法打开文件 "%s": %m 无法在文件"%2$s"中读取块%1$u: %3$m 无法读取文件"%2$s"中的块%1$u:读取第%3$d个，共%4$d个 无法取文件 "%s" 的状态: %m 无法在文件 "%2$s"中写入块%1$u: %3$m 无法对文件"%2$s"写操作数据块%1$u: 已写入%3$d个，共%4$d个 群集中已禁用数据校验和 群集中已启用数据校验和 群集中未启用数据校验和 数据库群集不兼容 错误:  致命的:  filenode指定无效，必须是数字: %s 文件名"%2$s"中的无效段号%1$d 没有指定数据目录  -f/--filenode选项只能与--check一起使用 pg_control的CRC值不正确  在文件"%2$s"中查找块%1$u失败: %3$m 同步数据目录 命令行参数太多 (第一个是 "%s") 正在更新控制文件 警告:  