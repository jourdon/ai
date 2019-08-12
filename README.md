# 以图搜图功能
>  使用的是百度AI平台，需申请百度AI开放平台帐号

[![Latest Stable Version](https://poser.pugx.org/jourdon/ai/version)](https://github.com/jourdon/ai)
[![Total Downloads](https://poser.pugx.org/jourdon/ai/downloads)](https://packagist.org/packages/jourdon/ai)
[![License](https://poser.pugx.org/jourdon/ai/license)](https://packagist.org/packages/jourdon/ai)

##要求

* PHP版本: 7.1+
* laravel版本:5.5+

## 安装

`composer require jourdon/ai`


## 发布配置文件:

`php artisan vendor:publish --provider="Ai\ServiceProvider"`

#### env中增加配置
```
#百度应用列表中的appid
BAIDU_SEARCH_APP_ID=
#百度应用的API Key
BAIDU_SEARCH_API_KEY=
#百度应用的Secret Key
BAIDU_SEARCH_SECRET_KEY=
```
#### API类型
- same 相同图检索
- similar 相似图检
- product 商品检索

#### 方法类型
- add  入库
- search  检索
- delete 删除
- update 更新

## 使用方法
```
app('ai')
//图片文件或图片 URL
->select($path)
//API类型   方法类型
->where('product','search')
//可选参数 参考官方文档
->options($options)
->get(10);

```
[官方文档](http://ai.baidu.com/docs#/IMAGESEARCH-API/f04ab525)
