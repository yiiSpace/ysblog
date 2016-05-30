flask-admin

>
    admin = Admin(app, 'Blog Admin')
    admin.add_view(EntryModelView(Entry, db.session))
    admin.add_view(ModelView(Tag, db.session))
    admin.add_view(ModelView(User, db.session))
    
admin 作为视图集中点（中心管理 集成点）  每个模型对应一个 ModelView（此套view 对应crud 对应某个ActiveRecord的视图）
如果需要自定义某个模型的模型视图 那么通过继承的方式做到 如上例中的EntryModelView
   
~~~python
   
       class EntryModelView(ModelView):
       _status_choices = [(choice, label) for choice, label in [
       (Entry.STATUS_PUBLIC, 'Public'),
       (Entry.STATUS_DRAFT, 'Draft'),
       (Entry.STATUS_DELETED, 'Deleted'),
       ]]
       column_choices = {
       'status': _status_choices,
       }
       column_filters = [
         'status', User.name, User.email, 'created_timestamp'
       ]
       column_list = [
       'title', 'status', 'author', 'tease', 'tag_list',
       'created_timestamp',
       ]
       column_searchable_list = ['title', 'body']
       column_select_related_list = ['author']
       
       form_columns = ['title', 'body', 'status', 'author', 'tags']
       
       form_ajax_refs = {
       'author': {
       'fields': (User.name, User.email),
       },
       }
       form_extra_fields = {
       'password': PasswordField('New password'),
       }
       def on_model_change(self, form, model, is_created):
       if form.password.data:
       model.password_hash =
       User.make_password(form.password.data)
       return super(UserModelView, self).on_model_change(
       form, model, is_created)
~~~   