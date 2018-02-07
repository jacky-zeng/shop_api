## Build Setup

``` bash
# 安装laravel (install laravel)
 
 composer install
 
# 因为要使用redis,需要安装一下,防止报Class 'Predis\Client' not found in Laravel这个错误
 
 composer require predis/predis
 
# 配置env     (env config)
    
 复制.env.example 重命名成 .env  打开.env文件 进行数据库配置
    
# 生成laravel的key
 
 php artisan key:generate
 
# 生成数据库和迁移文件
 
 新增的seed文件 需要先运行  composer dump-autoload
 方式一：运行 php artisan db:seed --class=AreasTableSeeder 指定运行areas表的迁移
 方式二：运行 php artisan db:seed 将运行Database\Seeder\DatabaseSeeder.php定义的所有表的迁移
 方式三：运行 php artisan migrate:refresh --seed 将删除所有表 并运行以下所有表的迁移
 
# 初始化laravel/passport插件的key
 
 php artisan passport:install
        

