-  使用 某种jquery tag 组件替换当前的tag输入
-  Flask-admin 后台相当强大 简单的几个配置 就拥有了yii后台的crud生成效果 这点yii不如也
   FileAdmin 视图 可以添加到AdminView 去  实现一个静态文件管理的功能
   ~~~  
   
        class BlogFileAdmin(FileAdmin):
        pass
        admin = Admin(app, 'Blog Admin')
        admin.add_view(EntryModelView(Entry, db.session))
        admin.add_view(SlugModelView(Tag, db.session))
        admin.add_view(UserModelView(User, db.session))
        admin.add_view(
        BlogFileAdmin(app.config['STATIC_DIR'], '/static/', name='Static
        Files'))
   ~~~