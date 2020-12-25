# xhprof-custem

项目目的：

```
 1. 为了方便在项目中引入xhprof，只需要在项目入口文件包含这里的auto_prepend_xhprof.php.
 2. 对xhprof的一些个性化修改.
```

使用步骤：

```
 1. 安装配置xhprof.
 2. 从github下载xhprof-custem代码
 3. 在自己的项目中引入xhprof-custem代码
 4. 访问站点，测试xhprof是否成功
```

下载代码：

```
git clone https://github.com/cooldaniel/xhprof-custem.git
```

假设目录：

```
~/code/myproject/web/index.php	// 项目入口文件
~/code/xhprof-custem			// git下载的代码
```

具体修改:

```
// 在index.php开头加入代码，即可在项目中引用xhprof
require __DIR__ .'/../../xhprof-custem/auto_prepend_xhprof.php';

// 替换文件，路径和安装的xhprof一样
// 如有需要，可以先备份原文件
/xhprof-custem/xhprof/xhprof_lib/utils/xhprof_lib.php
```

xhprof安装调试参考：

```
https://www.showdoc.com.cn/p/971ec56990de0edb7cbd511a073afea2
```