# lumen5.4.7的改版
## 项目中site_url指设定的public/index.php所在的路径
* 查看框架的版本号

```
# GET方式访问
site_url/v1/get_version
```

* 设置.env的APP_key

```
# GET方式访问
site_url/v1/key
将生成的32位随机码写到APP_KEY
```

