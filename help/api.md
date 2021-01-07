# API接口

云图api,图片存储,图片处理功能. 有问题可以联系: [admin] 

[![小P](https://git.sogou-inc.com/yun/yuntu/raw/master/static/xiaop.png) 小P:辛占国](xiaop:xinzhanguo)
[![邮件](https://git.sogou-inc.com/yun/yuntu/raw/master/static/email_4.png) 邮件:xinzhanguo@sogou-inc.com](mailto:xinzhanguo@sogou-inc.com?subject=[云图]问题&body=有一个问题) 
[![电话](https://git.sogou-inc.com/yun/yuntu/raw/master/static/phone_4.png) 电话:010-56899999-1653](tel:010-56899999-1653)
[![微信](https://git.sogou-inc.com/yun/yuntu/raw/master/static/weixin_4.png) 微信](https://git.sogou-inc.com/yun/yuntu/blob/master/static/wechat.jpg)

## 存储文件以及CDN需求

[存储视频，音频，各种文件的方法](https://git.sogou-inc.com/yun/yuntu/blob/master/s3.md)

## 申请appid

[云图appid申请入口](http://yun.sogou/#/yuntu)

[云图计费说明](https://git.sogou-inc.com/yun/yuntu/blob/master/price.md)

## 上传页面
[上传页面](http://innerupload.sogou/upload.html)

## 上传

### 上传文件图片
注: 更改图片与上传接口是相同的,刷新链接返回更新前的图片有可能是缓存还没刷新。
#### Reuqest

- Method: **POST**
- URL: ```http://innerupload.sogou/http_upload?appid={appid}```
- Body:

```shell
sign_file1={sign_file1}&file1={file1}
```
注: 云图接收body最大为20M 

|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| sign_file1 | string  | nil  | 图片名字 (字母 or 数字 or 下划线 or 点 避免其他特殊符号) |
| file1 | string | nil | 图片内容 |
| appid | number  | nil | 云图appid |


#### Response
- Body

```shell
[
    {
        "info": {
            "type": "gif", 
            "width": 4, 
            "size": 43, 
            "height": 1
        }, 
        "url": "http://img02.sogoucdn.com/app/a/101490007/xzgtestfile", 
        "status": "0", 
        "name": "xzgtestfile", 
        "appid": "101490007"
    }
]
```
#### Exmaple

```shell
curl -i -X POST -H "Content-Type: multipart/form-data" -F "file1=@testfile.gif" -F "sign_file1=xzgtestfile" "http://innerupload.sogou/http_upload?appid=101490007"
```
#### 异常status

```
0  success
10 Invalid encode / Invalid url
40 unsupported image type
42 large image then 100000px
50 pdb store error  or image is empty or appid is not storage type
90 appid not found
110 appid missing or Protocol error
140 appid banned
```

### 抓取图片上传
#### Reuqest

- Method: **GET**
- URL: ```http://innerupload.sogou/http_upload?url1={url1}&sign_url1={sign_url1}appid={appid}```
- Body:

注: 云图接收body最大为20M 

|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| url1 | string  | nil  | 图片链接(需要进行urlencode)  |
| sign_url1 | string | nil | 图片名称 |
| appid | number  | nil | 云图appid |

* 注意: 支持多个url上传,参数形式如可以累加 `url1={url1}&sign_url1={sign_url1}&url2={url2}&sign_url2={sign_url2}`


#### Response
- Body

```shell
[
    {
        "info": {
            "type": "jpg", 
            "size": 40152, 
            "height": 625, 
            "width": 473
        }, 
        "url": "http://img01.sogoucdn.com/app/a/101490007/testurlupload", 
        "name": "testurlupload", 
        "status": "0", 
        "appid": "101490007"
    }
]
```
#### Exmaple

```shell
curl -i -X GET "http://innerupload.sogou/http_upload?appid=101490007&url1=http://img03.sogoucdn.com/app/a/200841/e4b5ccaa08a2e685381dfd0f0630b2ac&sign_url1=testurlupload"
```

### 上传base64code图片
#### Reuqest

- Method: **POST**
- URL: ```http://innerupload.sogou/http_upload?appid={appid}```
- Body:

```shell
sign_encode1={sign_encode1}&encode1={encode1}
```
注: 云图接收body最大为20M 


|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| sign_encode1 | string  | nil  | 图片名字  |
| encode1 | string | nil | 图片的Base64后字符串,需要urlencode |
| appid | number  | nil | 云图appid |

#### Response
- Body

```shell
[
    {
        "info": {
            "type": "gif", 
            "width": 4, 
            "size": 43, 
            "height": 1
        }, 
        "url": "http://img02.sogoucdn.com/app/a/101490007/testbase64encode", 
        "status": "0", 
        "name": "testbase64encode", 
        "appid": "101490007"
    }
]
```
#### Exmaple

```shell
curl -X POST "http://innerupload.sogou/http_upload?appid=101490007" -d "encode1=data%3Aimage%2Fgif%3Bbase64%2CR0lGODlhBAABAIABAMLBwfLx8SH5BAEAAAEALAAAAAAEAAEAAAICRF4AOw%3D%3D&sign_encode1=testbase64encode"
```

### 上传图片加盲水印
#### Reuqest

- Method: **POST**
- URL: ```http://innerupload.sogou/blindupload?appid={appid}```
- Body:

```shell
sign_file1={sign_file1}&file1={file1}
```
注: 云图接收body最大为20M 

|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| sign_file1 | string  | nil  | 图片名字 (字母 or 数字 or 下划线 or 点 避免其他特殊符号) |
| file1 | string | nil | 图片内容 |
| appid | number  | nil | 云图appid |


#### Response
- Body

```shell
[
    {
        "info": {
            "type": "jpg", 
            "width": 4, 
            "size": 43, 
            "height": 1
        }, 
        "url": "http://img02.sogoucdn.com/app/a/101490007/xzgtestfile", 
        "status": "0", 
        "name": "xzgtestblindfile", 
        "appid": "101490007"
    }
]
```
#### Exmaple

```shell
curl -i -X POST -H "Content-Type: multipart/form-data" -F "file1=@testfile.jpg" -F "sign_file1=xzgtestblindfile" "http://innerupload.sogou/blindupload?appid=101490007"
```

### 查看盲水印解析效果

#### Exmaple

```shell
curl -i -X GET "http://innerupload.sogou/unblind?appid=101490007&name=xzgtestblindfile"
```

## 缩略
### 缩略图片
#### Reuqest

- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb/resize/w/{w}/h/{h}/t/{t}/s/{s}/zi/{zi}/iw/{iw}/ih/{ih}/ir/{ir}?appid={appid}&url={url}&name={name}```

|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| w | number  | 0  | 指定缩略的width  |
| h | number  | 0  | 指定缩略的height |
| t | enum{0,1,2}  |  1 | (0:按指定的w，h缩略,必须同时指定w，h; 1:根据w，h的比例，按上限缩略; 2:根据w，h的比例，按下限缩略) |
| s | enum{0,1} | 0  | 当缩略图的宽高大于原图的宽高时，默认返回原图。为了避免图片中嵌入了恶意代码，可以指定s为1，把图片宽高各减少1个像素返回  |
| zi | enum{on,off} | off | 是否允许拉伸，默认不允许 |
| iw | number | nil | 原图的最小宽 |
| ih | number | nil | 原图的最小高 |
| ir | enum{0,1,2} | nil | 云图小于iw、ih时，1返回原图，2返回空图，其它返回519 |
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url/name 二选一 url需要外网抓一遍图，然后进行处理, url需要urlencode避免获取参数错误 |
| name | string  | nil | 图片的名字 url/name 二选一 name是这个appid已经在云图存了一份的图片进行处理 |

* 注: 不支持GIT，支持格式 jpeg png


#### Exmaple

```shell
curl -o test.jpg "http://img03.sogoucdn.com/v2/thumb/resize/w/200/h/200/t/0/zi/on/iw/100/ih/100/ir/3?appid=101490007&name=thename"
```
```shell
curl -o test.jpg "http://img03.sogoucdn.com/v2/thumb/resize/w/200/h/200/t/0/zi/on/iw/100/ih/100/ir/3?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename"
```

## 裁剪
### 剪切图片
#### Reuqest

- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb/crop/x/{x}/y/{y}/w/{w}/h/{h}/xy/{xy}/t/{t}?appid={appid}&url={url}&name={name}```


|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| x | number | 0 | 裁剪的x轴起点，>=0 左起计算，<=0 右起计算，-0和0不同 (整数按像素算;小数按百分比算)|
| y | number | 0 | 裁剪的y轴，同参数x (整数;小数百分比;负数)|
| w | number  | nil  | 裁剪的width，非负 |
| h | number  | nil  | 裁剪的height，非负 |
| xy | enum{center,face,faceorcenter,ai}  | nil | center 以图像中心裁剪 face 以人脸为中心裁剪 faceorcenter 以人脸中心剪裁如果失败用center剪裁, ai 使用ai技术剪裁 xy的优先级高于x，y， 只有当xy定位不到x，y时，才参考x，y |
| t | enum{0,1}  |  0 | 0 按指定的w，h裁剪 1 根据w，h的比例，按上限裁剪 （如果指定xy为ai值0会进行等比例放大或者缩略剪裁,值1如果大图缩略，如果小图按照比例不缩略剪裁)|
| iw | number | 0 | 原图最小宽 |
| ih | number | 0 | 原图最小高 |
| ir | enum{0,1,2} | nil | 云图小于iw、ih时，1返回原图，2返回空图，其它返回519 |
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url/name 二选一 url需要外网抓一遍图，然后进行处理，url需要urlencode避免获取参数错误|
| name | string  | nil | 图片的名字 url/name 二选一 name是这个appid已经在云图存了一份的图片进行处理 |
| m | enum{cent,lt,pad,auto} | auto | 如果xy指定智能裁剪 cent: 居中 ， lt：左上 pad：填充 auto：自动 |

* 注: 不支持动态的GIF，如果无特别处理默认返回第一帧
* 注：xy定位功能优先级高于x,y定位. 有xy参数可以不用x,y参数. 
* 注：crop支持的图片格式jpg/png/webp静态;不支持gif/webp等动图 center 返回静图，其他返回原图.
* 注: crop xy ai 功能支持(jpg/png/webp/gif)格式图片, 动图返回静图.
* 注：xy如果是ai功能, crop 默认会第一个执行.
* 注: xy是ai功能会先缩略图片，然后选出合适位置剪裁；其他xy是定位出合适位置不进行缩略.
* 注: xy 非 ai 如果原图w,h小于处理后的设定值，返回原图，不进行处理.

#### Exmaple

* 智能裁剪示例

```shell
http://img01.sogoucdn.com/v2/thumb/crop/xy/ai/w/300/h/200/t/0/iw/50/ih/50/ir/3?appid=101490007&name=thename
```

```shell
http://img01.sogoucdn.com/v2/thumb/crop/xy/ai/w/300/h/200/t/0/iw/50/ih/50/ir/3?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename
```


* 其他示例


```shell
curl -o test.jpg "http://img03.sogoucdn.com/v2/thumb/crop/x/0.5/y/0.5/w/100/h/100/t/0?appid=101490007&name=thename"
```
```shell
curl -o test.jpg "http://img03.sogoucdn.com/v2/thumb/crop/xy/center/w/100/h/100/t/0?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename"
```
可以在浏览器中直接打开.

## 格式转换
### 转换图片格式
#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb/retype/ext/{ext}/q/{q}?appid={appid}&url={url}&name={name}```


|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| ext | enum{jpg,png,gif,webp,auto} | nil | 转换格式,(auto会根据请求的Accept头是否包含"webp"来返回webp或原图,Accept头不包含“webp”但原图是webp的返回jpg格式)|
| q | number | 0 | 图片质量 0～100 |
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url/name 二选一 url需要外网抓一遍图，然后进行处理，url需要urlencode避免获取参数错误 |
| name | string  | nil | 图片的名字 url/name 二选一 name是这个appid已经在云图存了一份的图片进行处理 |

* 注意:
 retype 目前不支持实时转换GIF格式动图，转换后是一个静止的图片，  
 如果想返回原图将 `retype` 替换成 `retype_exclude_gif` 将GIF返回原图。 

#### Exmaple

```shell
curl -o test.png "http://img03.sogoucdn.com/v2/thumb/retype/ext/png?appid=101490007&name=thename"
```
```shell
curl -o test.png "http://img03.sogoucdn.com/v2/thumb/retype/ext/auto/q/65?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename"
```

## 旋转
### 旋转图片，[如果你需要根据exif自动旋转,需要着管理员单独配置](#%E6%A0%B9%E6%8D%AEexif%E8%87%AA%E5%8A%A8%E6%97%8B%E8%BD%AC)
#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb/rotate/d/{d}/r/{r}/g/{g}/b/{b}?appid={appid}&url={url}&name={name}```


|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| d | number | 0 | 旋转角度 0~360 |
| r | number | 0 | RGB Red 0～256 背景填充色|
| g | number  | 0 | RGB Green 0～256 背景填充色|
| b | number  | 0 | RGB Blue 0～256 背景填充色|
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url/name 二选一 url需要外网抓一遍图，然后进行处理 |
| name | string  | nil | 图片的名字 url/name 二选一 name是这个appid已经在云图存了一份的图片进行处理 |

#### Exmaple

```shell
curl -o test.jpg "http://img03.sogoucdn.com/v2/thumb/rotate/d/70/r/111/g/222/b/10?appid=101490007&name=thename"
```
```shell
curl -o test.jpg "http://img03.sogoucdn.com/v2/thumb/rotate/d/70/r/111/g/222/b/10?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename"
```

## 根据EXIF自动旋转
### 根据图片拍摄的信息自动旋转
### 联系管理员单独配置下，云图是支持的（默认关闭）

## 压缩
### 压缩图片
#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb/compress/q/{q}?appid={appid}&url={url}&name={name}```

**目前支持jpg，webp图片压缩**

|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| q | number | 0 | 图片质量 0～100 |
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url/name 二选一 url需要外网抓一遍图，然后进行处理 |
| name | string  | nil | 图片的名字 url/name 二选一 name是这个appid已经在云图存了一份的图片进行处理 |

#### Exmaple

```shell
curl -o test.jpg "http://img03.sogoucdn.com/v2/thumb/compress/q/65?appid=101490007&name=thename"
```
```shell
curl -o test.jpg "http://img03.sogoucdn.com/v2/thumb/compress/q/65?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename"
```

## 图片致灰
#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb/color/c/{c}?appid={appid}&url={url}&name={name}```


|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| c | enum{1,2,3,4,5,6} | 0 | 颜色空间 c,3 是灰色 |
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url/name 二选一 url需要外网抓一遍图，然后进行处理 |
| name | string  | nil | 图片的名字 url/name 二选一 name是这个appid已经在云图存了一份的图片进行处理 |

#### Exmaple

```shell
curl "http://img03.sogoucdn.com/v2/thumb/color/c/3?appid=101490007&name=thename"
```
```shell
curl "http://img03.sogoucdn.com/v2/thumb/color/c/3?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename"
```

## 文字水印
#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb/watermark/x/{x}/y/{y}/p/{p}/t/{t}/c/{c}/s/{s}/f/{f}?appid={appid}&url={url}&name={name}```


|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| x | number | 0 | 水印位置x轴定位 |
| y | number | 0 | 水印位置y轴定位 |
| p | enum{rb,center,lt,lb,rt} | nil | 水印位置 |
| t | string | nil | 水印内容 utf8编码 |
| c | string | nil | 字体颜色 |
| s | number | 12 | 字体大小 |
| f | enum{Yahei,YaheiB} | simsong | 字体 |
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url/name 二选一 url需要外网抓一遍图，然后进行处理 |
| name | string  | nil | 图片的名字 url/name 二选一 name是这个appid已经在云图存了一份的图片进行处理 |

#### Exmaple

```shell
curl "http://img03.sogoucdn.com/v2/thumb/watermark/p/center/c/red/t/sogou/s/24?appid=101490007&name=thename"
```
```shell
curl "http://img03.sogoucdn.com/v2/thumb/watermark/p/center/c/red/t/sogou/s/24?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename"
```
## 图片水印
#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb/img_watermark/x/{x}/y/{y}/p/{p}/o/{o}?appid={appid}&url={url}&name={name}&comp_img={comp_img}```


|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
|comp_img | string | nil | 水印图片 |
| x | number | 0 | 水印位置x轴定位 |
| y | number | 0 | 水印位置y轴定位 |
| p | enum{rb,center,lt,lb,rt} | rb | 水印位置 |
| o | enum{over,inc,diff,plus,xor,multi} | xor | 水印覆盖效果参数 |
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url/name 二选一 url需要外网抓一遍图，然后进行处理 |
| name | string  | nil | 图片的名字 url/name 二选一 name是这个appid已经在云图存了一份的图片进行处理 |

#### Exmaple

```shell
curl "http://img03.sogoucdn.com/v2/thumb/img_watermark/p/center?appid=101490007&name=thename&comp_img=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F200841%2Fplay_video1"
```
```shell
curl "http://img03.sogoucdn.com/v2/thumb/img_watermark/p/center?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename&comp_img=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F200841%2Fplay_video1"
```

## 签名

为了避免cdn带宽被盗用增加了对链接的签名功能
带有正确签名的链接才会正常返回
如果签名不正确或者没有带签名返回400

签名功能在appid申请时候进行设置

#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb?appid={appid}&url={url}&sign={sign}```

#### 算法
签名是appid与请求链接与密钥拼接后进行md5的值
```
sign = md5("{appid}{url}{token}");
```

#### Exmaple

**需要注意的一点是url如果进行了urlencode，签名中的url是urlencode前的值**

```shell
sign = md5 -s "100140025http://img03.sogoucdn.com/app/a/101490007/thenametoken"
```
```shell
curl "http://img03.sogoucdn.com/v2/thumb?appid=100140025&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename&sign=43e3cc802ba23288dd3e38962e26f4d3"
```
## Gif图抽帧处理(舍弃/效率低不建议使用)

#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb/gif/s/{s}/m/{m}/w/{w}/h/{h}?appid={appid}&url={url}```

注: 这个功能需要绑定appid，需要单独设置，如果需要联系 “[admin]”

|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| s | number | 0 | 间隔数可以是小数 |
| m | number | 0 | 最多抽取张数 |
| w | number | 0 | Resize设置宽 |
| h | number | 0 | Resize设置高 |
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url |

#### Exmaple

```shell
curl "http://logic005.yuntu.zw.ted:8080/v2/thumb/gif/s/5/m/5/w/100/h/100?appid=101490007&url=https://n.sinaimg.cn/tech/transform/665/w427h238/20191028/6a22-ihqyuyk4025338.gif"
# curl "http://img03.sogoucdn.com/v2/thumb/gif/s/2/m/10/w/100/h/100?appid=100140025&url=https://f.sinaimg.cn/tech/transform/614/w390h224/20191018/cea4-ifzxhxm9145220.gif&nsukey=58TF59zXl9OgsDBFuaEsKhuw0mqaI%2FROktMlDTgj%2Fd5QhqAw8YiK9xUJv1C4vs8UgvTOy90u5wXK%2BwpxjF6CoV2JrueYq1J7mGYcF0OoVSgE%2Bx07adI20%2BQN%2BWldOIGiYH8SvT%2FS0Yk2BgaCH%2BBkURh9mVW8f5K4h0N29a6KQkjeUJCXWS4bjsUg8vKCq9R%2Faj0dRyLjg8Z4KAZPChbu6w%3D%3D"
```

## Gif图片压缩

gif图异步压缩, 生成压缩后的webp和压缩后的gif图.
如果不设置resize参数，会判断原图宽或高是否大于256，如果大于取256为宽或高等比例压缩.  
gif图在支持webp浏览器在压缩刷新cdn前会生成一张静态图.

#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb/resize/w/{w}/h/{h}/retype/ext/auto/q/{q}?appid={appid}&url={url}```

注: 这个功能需要绑定appid，需要单独设置，如果需要联系 “[admin]”

|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| w | number | 0 | Resize设置宽 |
| h | number | 0 | Resize设置高 |
| q | number | 65 | 压缩参数 1-100 |
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url |

#### Exmaple

```shell
curl "http://img.sogoucdn.com/v2/thumb/retype/ext/auto/q/21?url=https%3A%2F%2Fn.sinaimg.cn%2Ftech%2Ftransform%2F686%2Fw450h236%2F20181126%2FApQA-hmhswip0708764.gif&appid=101490007"
```


## 获取图片meta信息

#### Reuqest
- Method: **GET**
- URL: ```http://img.store.sogou/v2/meta?appid={appid}&url={url}```

* 注内网使用

|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url/name 二选一 url需要外网抓一遍图，然后进行处理 |
#### Response

```
{
    "t": 2,
    "size": 7963,
    "w": 175,
    "h": 97,
    "umd5": "279786b7381b0c9bd48461924de02f54",
    "tn": "jpg"
}
```
|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| t | number  | nil | 图片格式的数值 1:gif,2:jpg,3:png,6:bmp,7:webp,9:ico |
| umd5 | string  | nil | 链接的md5 |
| size | number | nil | 图片大小|
| w | string  | nil | 图片宽 |
| h | string  | nil | 图片高 |
| tn | string  | nil | 图片格式名称 与t相关 |


#### Exmaple

```shell
curl "http://img.store.sogou/v2/meta?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename"
```

## 获取图片base64encode


#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb?appid={appid}&url={url},{url2}```


|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url, url中用","分割多个,一个图片也要带上"," |
#### Response

```
{
    "http://img03.sogoucdn.com/app/a/100520024/70c90859446ae6b9b78ca70fb0b2b69a": "/9j/4AAQSkZJRgABAQEASABIAAD/++i6JJe6/VAYKeEAgccYH3RXcr/9k="
}
```
* 注意：示例中code有删减


#### Exmaple

```
http://img01.sogoucdn.com/v2/thumb?appid=101490007&url=http://img03.sogoucdn.com/app/a/100520024/70c90859446ae6b9b78ca70fb0b2b69a,
```

## 加密URL访问

#### Reuqest
- Method: **GET**
- URL: ```http://img.sogoucdn.com/v2/thumb?appid={appid}&name={name}```

可以通过抓取上传接口把链接图片存在云图后展示，达到加密目的.

|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| appid | number  | nil | 云图appid |
| name | string  | nil | 图片名称|


#### Exmaple

```
http://img01.sogoucdn.com/v2/thumb?appid=101490007&id=xxdfiasdfiajisodjfsojifj
```


## 获取图片质量


#### Reuqest
- Method: **GET**
- URL: ```http://img.store.sogou/v2/quality?appid={appid}&url={url}&name={name}&mins={mins}&maxs={maxs}&minr={minr}&max={maxr}```


|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url, url中用","分割多个,一个图片也要带上"," |
| mins | number  | 10 | 图片最小像素 |
| maxs | number  | 5000 | 图片最大像素 |
| minr | number  | 0.2 | 图片最小宽高比 |
| maxr | number  | 5.0 | 图片最大宽高比 |

#### Response

```
{
    "t": 2,
    "q": 0.91712123155594,
    "status": 200,
    "width": 100,
    "height": 100
}
```
|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| t | enum{0-11}  | 0 | 图片判断类型   |
| q | number  | 0 | 分数 |
| status | number  | 200 | 处理状态,200正常,非200异常 |
| width | number  | 0 | 宽 |
| height | number  | 0 | 高 |

** t: 含义 ** 
* -1, 图片抓取异常
* 0,  正常图
* 1,  logo图
* 2, 文字表格
* 3,  拼接图
* 4,  二维码
* 5,  盗链图
* 6,  证件照
* 7, 旗帜
* 8, 色情图
* 9, 图片过大，长或宽大于5000 （可配置）
* 10，超长图，宽/高小于0.2 （可配置）
* 11，超宽图，宽/高大于5（可配置）

#### Exmaple

```
http://img.store.sogou/v2/quality?appid=101490007&url=http%3A%2F%2Fimg03.sogoucdn.com%2Fapp%2Fa%2F101490007%2Fthename
```

## 获取GIF图片播放时间

#### Reuqest
- Method: **GET**
- URL: ```http://img.store.sogou/v2/gif?appid={appid}&url={url}&name={name}```

|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| appid | number  | nil | 云图appid |
| url | string  | nil | 图片链接 url, url中用","分割多个,一个图片也要带上"," |
| name | string  | nil | 图片名称 |

#### Response

```
{
    "status": 0,
    "time": 310
}
```
|参数| 类型 |  默认值 | 说明 |
|---|---|---|---|
| status | enum{-2,-1,0}  | 0 | 0 正常 -1 图片异常 -2  图片格式异常  |
| time | number  | 0 | 时间单位 10ms 既，time/100 转换为秒单位  |

#### Exmaple

* 注 目前只支持内网调用

```
http://img.store.sogou/v2/quality?appid=101490007&name=testuploadgif1
```

## X-YunTu-Error 含义

* `InvalidUri`  URI 参数异常
* `InvalidAppid`  appid 不存在
* `InvalidImage` 图片为空
* `InvalidUserUrl` url抓取返回非200状态
* `InvalidImageType` 不支持图片格式
* `InvalidImageSpec` 图片太小了返回519 [resize ir 的设置](https://git.sogou-inc.com/yun/yuntu/blob/master/api.md#%E7%BC%A9%E7%95%A5)


## 云图refer限制

抓图带有?appid=xxx&url=xxx这种形式的图片有refer白名单限制,如果不在白名单里回源会返回403
```
none *.sogou.com *.sogoucdn.com *.teemo.cn *.sohu.com *.sg.cn *.sogo.com *.go2map.com *.soso.com *.soso.com.cn *.wowenwen.com *.sogou-inc.com *.qq.com *.miercn.com *.xinyan.cn *.xiaoluyy.com *.iqiyi.com *.letv.com *.56.com *.ku6.com *.ifeng.com *.kankan.com *.sogou-op.org *.vodjk.com *.snssdk.com *.servicewechat.com servicewechat.com *.miwifi.com sogou.eastday.com *.sogou *.sogou.com.inner 10.* soso.com *.ted *.youlai.cn;
```
有部分白名单是设置在cdn的,不在白名单里直接返回403

## 注意

云图的域名：img01-04.sogoucdn.com
云图的备份域名: pic01-04.sogoucdn.com

Yuntu 的 thumb API 是功能（action）级联的

例如:

/crop/w/200/h/150/resize/w/150/h/100

表示先裁剪为200x150的图片，再缩率为150x100的图片，100是根据比例自动计算的，主要这里的w和h因为位置不同（分bie在crop和reisze后面），所以含义也不同，另外crop和resize的顺序决定了先裁剪后缩率。

**注意** 后一个action基于前一个action处理过的图片进行处理

目前不支持action叠加，叠加action行为时，发生400，例如/crop/w/200/h/150/resize/w/150/t/1/crop/w/500

retype无论出现在哪里，总是最后一个执行的



## 云图封禁第三方网站

由于涉及色情，政治等敏感信息，云图会封禁一些第三方网站，避免云图域名被运营商封禁。

云图封禁了用于色情行业的顶级域名 `.sex` `.xxx` `.pron` `.adult` 。

其他云图封禁的链接，如果有疑问及时联系我，云图封禁是紧急行为, 希望理解。

[admin]: 辛占国 "辛占国"
