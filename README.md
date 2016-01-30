# laravel_iMarkdownEditor


一个基于 laravel 5 的markdown 编辑器

本项目基于  [传送门](https://github.com/Integ/BachEditor) 二次开发完成

###安装教程

首先当然是在项目的composer.json 文件中加入包的信息

######具体的方法
```
"require": {
        "outshine/laravel-imarkdowneditor": "dev-master"
    },

```

然后执行composer update就可以了



###使用教程
2. 在laravel的config/app.php 中provider和aliases中分别分别添加

```

    'providers' => [

        'Outshine\Editor\iMarkdownEditorServiceProvider',

    ],



    'aliases' => [

          'iMarkdownEditor'=> 'Outshine\Editor\Facade\iMarkdownEditorFacade',


    ],

```

3.在view视图中引用 ：


在需要编辑器的地方插入以下代码

```
// 引入编辑器代码
@include('editor::head')

// 编辑器一定要被一个 class 为 editor 的容器包住
<div class="editor">
	
	<textarea id='myEditor'></textarea>
	
	// 容器的 ID 为 myEditor 就行
	
</div>

```


#### 图片上传移植到扩展内部处理



图片上传配置，打开config/editor.php 配置文件，修改里面的 `uploadUrl` 配置项，为你的处理上传的 controller 代码

我的上传 action 代码为

```
use iMarkdownEditor;

public function upload(){
         $url = '';
        if (Request::hasFile('image')) {
            $pic = Request::file('image');

            if ($pic->isValid()) {
                $newName = md5(rand(1, 1000) . $pic->getClientOriginalName()) . "." . $pic->getClientOriginalExtension();
                $pic->move('uploads', $newName);
                $url = '/uploads/'.$newName;
            }
        }
        $data = array(
            'status'=>empty($message)?0:1,
            'message'=>'none',
            'url'=>!empty($url)?$url:''
        );
        return json_encode($data);
        
}


```
### 解析 markdown 为 html 功能

#####如果在controller里面调用


```
		use iMarkdownEditor;
        $article = Article::first();
        return view('test',[
            'content'=>iMarkdownEditor::MarkDecode($art->content)
        ]);
        
        
```
#####如果在模板引擎中调用

直接把需要解析的 markdown 扔进这个方法就行

```
{!! iMarkdownEditor::MarkDecode("#thi is markdown doucument ") !!}

```

>>>注意：markdown的功能切记不要使用在评论模块上，否则会引起xss漏洞。
比如说，用户直接在markdown编辑器里面写上 <script>alert("xss")</script>标签，而且不标记为代码块的话，那么在此打开这篇文章的话就有alert弹窗提示“xss”。
