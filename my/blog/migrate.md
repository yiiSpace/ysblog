~~~shell
    
    yii migrate/create entry_init --migrationPath=@my/blog/migrations
    yii migrate/create tag_init --migrationPath=@my/blog/migrations
    yii migrate/create entry_tag_init --migrationPath=@my/blog/migrations
    yii migrate/create ar_init --migrationPath=@my/blog/migrations
    
    yii migrate/create entry_status_adding --migrationPath=@my/blog/migrations
    
    yii migrate/create  entry_add_user_id --migrationPath=@my/blog/migrations
    
    yii migrate/up   --migrationPath=@my/blog/migrations
    
    
    yii migrate/create comment_create --migrationPath=@my/comment/migrations

~~~