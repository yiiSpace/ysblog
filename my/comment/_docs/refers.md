yii2 comment module
===========

现有的评论模块

- https://github.com/yii2mod/yii2-comments  js写的很好哦  | Pjax 用的很溜啊
- https://github.com/rmrevin/yii2-comments  看起来比较牛  俄罗斯的  | 接口的使用不错 CommentatorInterface |
    可扩展性看起来很好
- https://github.com/vova07/yii2-start-comments-module 有点费解 模型关系| 里面有好多也值得学习    | 有批处理支持
- https://github.com/yeesoft/yii2-comments   不错！
- https://github.com/spanjeta/yii2-comments
- https://github.com/itzen/yii2-comments    好像还未完成 有rate投票功能    
- https://github.com/FrenzelGmbH/cm-comments JS 写的不错
- https://github.com/Patroklo/yii2-comments
- https://github.com/yii2mod/yii2-disqus
- https://github.com/msdie/yii2-module-comments
- https://github.com/MickeyUr/yii2-commentator 看起来也不错哦！
- https://github.com/PendalF89/yii-commentator 看起来相当漂亮！  | 作者有好多好玩的东西哦  比如 scroll-top ,image-resizer
  [visitor-filter](https://github.com/PendalF89/visitor-filter)这个就是用来禁止其他国家人访问的功能！
  
- https://github.com/dmuratov/yii2-universal-comment  以behavior形式实现评论功能 寄生在宿主身上！ 比较简单
- https://github.com/yeesoft/yii2-comments     yeecms项目中的一个模块 应该很可以！
- https://github.com/yeesoft/yii2-yee-comment  为毛搞两个 一个通用 一个专用么？
- https://github.com/itsurka/yii2-simple-comment  模型太简单 
- https://github.com/rudeeeboy/yii2-comments  看起来是个熟人 好像不活跃了！
- https://github.com/roman444uk/yii2-module-comments  很不错 权限做的比较好
- https://github.com/VitaliyGit/yii2-simple-comments   Ajax 功能的
- https://github.com/developer-av/Yii2-Comments  比较奇怪 |  有空仔细看看 |  竟然叫feedback
- https://github.com/DevGroup-ru/dotplant2    此项目下的review 模块  |　项目比较出名　模块功能可以借鉴
- https://github.com/demisang/yii2-comments   目录结构类似高级模板  |  完成度不错 | db 可以借鉴
- https://github.com/vryabov1/yii2-comments   trait 有点意思 | 邻接表模型

- https://github.com/naffiq/yii2-rocket-comments  未完成     |  用到了nestedset 具有投票功能

- https://github.com/range-web/yii2-rw-comments

其他扩展
- https://github.com/creocoder/yii2-nested-sets


心得：
------------
一个句子：
> 无聊的 yiqing 在凌晨一点 评论了 蛋蛋的博客   | 语法角度讲 主谓宾 状语定语 都有了！

三个东西间的关系

User   评论   评论目标（目标类型 目标id 标识）

功能在三者间的 **移动** 职责的分配

这里的移动是指 功能可以全部由评论模块完成 也可以把部分功能留给其他两个实体  比如借用behavior让user "具有"评论的方法
使用接口 使一个实体变为commentable（可被评论的）  功能越分散 那么评论跟其他两个实体联系就越紧密 对他们的侵入就越大，
越耦合的紧的功能 想以后跨项目使用就不是太容易  耦合的度需要平衡


- 关于被评论对象  有的用合并   modelClass.':'.modelId    作为评论目标 但个人觉得这不是一个比较好的方案

- crc32  这个倒不错 如果被评论目标的类型用crc32 编码下会变短 比如 my\blog\common\models\Blog 如果类型是这样 在db中可能
    会很长 但crc32 后不会长的太离谱
    
    
- **树形表示**
    
    + 有的使用邻接表模型（parent_id）
    + 有的使用左右树

- **评论状态**

>       
    const STATUS_DRAFT 		= 0;
	const STATUS_PUBLISHED 	= 1;
	const STATUS_ARCHIEVED 	= 2;
	
- 事件
	
- 操作权限	

- migration
  均使用migration完成db表创建
  
  
- 提供api

-  支持分表 使用继承 指定不同的表名
    	
### 对其他模块的依赖
    
有的会直接依赖User组件 考虑到最松散情形  ：
一个页面本身是其他语言或者静态文件 只是在某个block区域想实现评论 这种情况是最松散耦合的情形 该区域可以使用ajax完成所有功能
比如大家现在所用的 “多说”  可以用一个第三方插件的形式来集成到你的项目中 而且是通用的 此时comment模块 不应该依赖任何其他
实体 。