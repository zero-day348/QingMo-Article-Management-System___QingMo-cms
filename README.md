# 轻墨文章管理系统
轻墨CMS是一款基于 ThinkPHP 6 框架的多应用模式开发的文章管理系统，适用于中小型企业、个人站长快速搭建网站并进行内容运营。系统分为前台展示和后台管理两大部分。  
前台：面向普通访客，提供文章浏览、分类查看、内容搜索等功能，界面友好，响应式设计适配多种设备。  
后台：面向网站管理员，提供文章管理、分类管理、用户管理、数据统计等功能，操作便捷，安全可靠。  
后台：127.0.0.1:8000/admin/login    测试账号admin/123456  
前台：127.0.0.1:8000    			 测试账号test1/123456  
Web 服务器：	Nginx 1.16+/Apache 2.4+  
PHP 版本：	  PHP 7.4+（需开启 PDO、MBstring、JSON、GD 扩展）  
数据库：	    MySQL 5.7+/MariaDB 10.2+  
# 系统部署指南：  
## 上传系统源码
   CMS 系统源码包解压后，通过 FTP 工具或服务器文件管理工具，上传至 Web 服务器的网站根目录。composer creat-project topthink/think tp6创建一个tp6项目，用仓库中提供的代码文件替换原项目中的文件。
## 配置数据库
登录 MySQL 数据库管理工具（如 Navicat、PhpMyAdmin），创建新数据库（建议编码格式为 UTF-8）；导入系统提供的数据库脚本（tp6_cms.sql），完成数据表初始化；编辑系统配置文件 config/database.php，修改数据库连接信息。
## 权限配置
设置系统目录权限，确保 PHP 进程可读写以下目录：  
runtime/（运行时缓存目录）  
public/（静态资源目录）  
config/（配置文件目录）  
## 部署验证
在项目根目录运行cmd，输入命令composer require topthink/think-multi-app配置多应用模式，输入命令composer require topthink/think-captcha配置验证码，输入命令php phpthink run运行thinkphp项目。打开浏览器，输入系统访问地址（如127.0.0.1:8000/admin/login），若能正常显示登录页面，则说明部署成功。 
# 系统前台主要功能（用户）
## 网站首页
首页是网站的门户，展示网站的核心内容和导航结构。网站标题与 Logo，位于页面顶部，点击可返回首页。主导航菜单，包含首页、文章分类、所有文章、搜索文章、前台登录等核心栏目链接。主要展示展示重要或热门的文章。
<img width="419" height="224" alt="image" src="https://github.com/user-attachments/assets/6b9566fa-3519-45e6-9770-8f3391163a58" />
## 文章列表页
当用户点击导航菜单中的某个分类时，会进入该分类的文章列表页。分类标题与描述显示当前分类的名称和简介。文章列表以卡片或列表形式展示该分类下的所有文章，包含：文章标题（点击可进入详情页）、文章摘要等。  
<img width="414" height="221" alt="image" src="https://github.com/user-attachments/assets/bcc65b12-c72e-49f1-a599-570abaa40356" />
## 文章详情页
这是展示单篇文章完整内容的页面。文章标题位于页面顶部，字体较大。文章元信息位于标题下方，包括：发布时间、所属分类等。文章正文展示完整的文章内容，排版等将按后台编辑时的样式展示。  
<img width="415" height="244" alt="image" src="https://github.com/user-attachments/assets/f8839d1a-4e9f-4e71-a8c5-1f3cb0858598" />
## 前台用户登录功能
在首页的导航栏点击前台登录可转跳到登录界面进行前台用户登录。  
<img width="416" height="221" alt="image" src="https://github.com/user-attachments/assets/6934c86e-ad2d-4d41-a65f-3c0a72172db0" />
## 搜索功能
前台用户登录后，网站在首页的导航栏提供搜索框。用户在搜索框中输入关键词（如 “人工智能”）后，点击搜索按钮或按回车键系统会跳转到搜索结果页，展示所有标题或正文中包含该关键词的文章列表。搜索结果页的布局通常与文章列表页类似。  
<img width="414" height="221" alt="image" src="https://github.com/user-attachments/assets/4c173ea6-e8c1-4a25-ab54-440aced2261a" />
## 文章发布功能
前台用户登录后可在首页的导航栏点击发布文章进行文章发布，发布后的文章将立即公开。  
<img width="414" height="220" alt="image" src="https://github.com/user-attachments/assets/1529c3bf-9628-422d-9f37-852c51f9acce" />
# 系统后台主要功能（管理员）
## 系统登录
访问系统后台登录地址进行登录，验证通过后会进入系统后台首页。  
<img width="415" height="220" alt="image" src="https://github.com/user-attachments/assets/58f9c2a9-cd64-4d7a-a741-8f7c4723192b" />
## 首页数据统计
登录成功后，系统默认显示后台首页，首页包含以下数据统计模块。文章总数，系统已发布的所有文章数量；分类总数，系统已创建的文章分类数量；用户总数，系统前后台一共注册的用户数量；登录用户，当前登录管理员的昵称。  
<img width="458" height="244" alt="image" src="https://github.com/user-attachments/assets/199d9a1c-bd31-4294-abe1-879e298bbf4e" />
## 用户管理模块
用户管理模块用于管理系统后台管理员账号，支持添加、编辑、删除、查看用户列表等操作。
### 查看用户列表
点击左侧菜单栏「用户管理」，进入用户列表页面；页面显示所有管用户的 ID、用户名、昵称、状态、创建时间及操作按钮。
### 添加用户
在用户列表页面，点击右上角「添加用户」按钮，填写用户表单（用户名、昵称、密码、状态），点击「提交」按钮，添加成功后自动跳转至用户列表页面。
### 编辑用户
在用户列表页面，找到目标用户，点击「编辑」，在编辑页面，可修改用户昵称、状态、密码（密码为空则不更新），点击「提交」按钮，保存修改。
### 删除用户
在用户列表页面，找到目标用户（超级管理员 ID=1 不可删除），点击「删除」按钮，系统弹出确认提示框，点击「确定」即可删除用户。  
<img width="440" height="234" alt="image" src="https://github.com/user-attachments/assets/6142c6fa-1312-4f3c-99b9-0bd09e823579" />
<img width="415" height="220" alt="image" src="https://github.com/user-attachments/assets/f0d15242-3691-4d0c-8a89-ffc0a09cf9b0" />
## 文章管理模块
文章管理模块是 CMS 的核心，用于发布、编辑、删除和管理网站的所有文章内容。
### 查看文章列表
点击左侧菜单栏「文章管理」，进入文章列表页面，页面显示文章的 ID、标题、分类、作者、发布时间、阅读量和状态（已发布 / 草稿）。支持按标题关键词搜索和按分类筛选。
### 添加文章
点击「添加文章」按钮，进入文章编辑页面。填写文章信息包括标题
分类（为文章选择一个所属分类）、内容（使用富文本编辑器编写文章正文）、
状态（选择「已发布」或「草稿」），点击「提交」按钮，完成文章发布。
### 编辑 / 删除文章
在文章列表页面，找到目标目标，点击「编辑」按纽，进入编辑页面即可进行编辑，点击「提交」按钮，即可保存修改并返回文章列表页面。点击「删除」按钮，系统弹出确认提示框，点击「确定」即可删除文章。  
<img width="414" height="199" alt="image" src="https://github.com/user-attachments/assets/e05efffd-7a77-4c9e-80b3-2e60b9aa6e9b" />
<img width="415" height="221" alt="image" src="https://github.com/user-attachments/assets/323b6963-4b28-4ebb-81ba-20a077da40ca" />
<img width="415" height="222" alt="image" src="https://github.com/user-attachments/assets/dccfe4d1-364b-4979-8ce9-fa8eb3bdc5a9" />



