# Nessus-EN-2-CN

安装步骤

# Step 1

创建 mysql 数据库，将 `nessus_db.sql` 导入。数据库中是 nessus 插件的 id 对应的中文名称、描述和解决方案的译文。

# Step 2

安装 `php7 + apache/nginx`，将其他文件全部放在 web 根目录下。

修改 `dbconfig.php` 中的数据库信息。

修改 `updatetrans.php` 中的密码 md5 。

# Step 3

访问 http：//ip/index.php

导入一个英文版的 csv 文件，需要包含 `Plugin ID,CVE,CVSS,Risk,Host,Protocol,Port,Name,Synopsis,Description,Solution,See Also` 这几列。

**强烈不建议**导出`Plugin Output`，对于某些扫描报告中此字段过长，包含大量html代码的情况，会导致网站写库时出错，无法正常呈现。

成功导入后页面会显示翻译后的内容，如果数据库中查找不带对应的译名，会显示原文。

# Step 4

对于没有译文的项目，可以点击页面上方 `没有翻译的`，筛选未翻译的内容。

点击 `手动输入翻译数据` 跳转到 `insert.php`，用户可以手动添加译文。

# Step 5

手动添加时，所有输入框都需要填写，其中密码框为前文计算 md5 时所指定的密码。

# 注意

网站不提供文件保存的功能，上传的csv文件仅用于读取，翻译处理完以后程序会将内容写入到数据库的表`en`中，不会保存在服务器上，所以不要删除原始文件。

数据表 `en` 中的内容会在任意用户访问 `index.php` 时删除，一定程度上避免数据泄露，建议翻译完成后手动访问 `index.php` 以清理数据。
