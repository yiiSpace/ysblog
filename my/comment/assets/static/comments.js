/**
 * Created by yiqing on 2016/5/31.
 */

Comments = window.Comments || {};
(function (exports, $) {
    // todo 目前写死了 后续使之可以配置    当前js风格是函数式  最好改成jquery插件形式 这样可配置度会好些！
    var formSelector = '.comment-form form' ;
    var commentListUrl ;
    /**
     *  |+  _____________________________________________________________________________________________ +
     */
    function displayNoComments() {
        noComments = $('<h3>', {
            'text': 'No comments have been posted yet.'
        });
        $(formSelector).before(noComments);
    }

    /* Template string for rendering a comment. */
    var commentTemplate = (
        '<div class="media">' +
        '<a class="pull-left" href="{url}">' + '<img class="media-object" src="{gravatar}" />' +
        '</a>' +
        '<div class="media-body">' +
        '<h4 class="media-heading">{created_at} By ({user_name})</h4>{body}' +
        '</div></div>'
    );

    function renderComment(comment) {
        var createdDate =  comment.created_at ;  // new Date(comment.created_at).toDateString();
        return (commentTemplate
            .replace('{url}', comment.url)
            .replace('{gravatar}', comment.gravatar)
            .replace('{created_at}', createdDate)
            .replace('{user_name}', comment.user_name)
            .replace('{body}', comment.body));
    }

    function displayComments(comments) {
        $.each(comments, function (idx, comment) {
            var commentMarkup = renderComment(comment);
            $(formSelector).before($(commentMarkup));
        });
    }

    function load(entryId) {
        var filters = [{
            'name': 'entity_id',
            'op': '=',  // 'eq',  // 这个地方可以映射  eq <==> =  , neq <==> <> , gt <==> >   有好多常用的！
            'val': entryId
        }];
        var serializedQuery = JSON.stringify({'filters': filters});
        $.get(commentListUrl, {'q': serializedQuery}, function (data) {
            if (data['num_results'] === 0) {
                displayNoComments();
            } else {
                displayComments(data['items']);
            }
        });
    }

    /**
     *                                   以上是加载评论列表的逻辑
     * +  _____________________________________________________________________________________________ + |
     */


    /* Template string for rendering success or error messages. */
    var alertMarkup = (
    '<div class="alert alert-{class} alert-dismissable">' +
    '<button type="button" class="close" data-dismiss="alert"  aria-hidden="true">&times;</button>' +
    '<strong>{title}</strong> {body}</div>');
    /* Create an alert element. */
    function makeAlert(alertClass, title, body) {
        var alertCopy = (alertMarkup
            .replace('{class}', alertClass)
            .replace('{title}', title)
            .replace('{body}', body));
        return $(alertCopy);
    }

    /* Retrieve the values from the form fields and return as an
     object. */
    function getFormData(form) {
        return form.serialize();
        /*
         return {
         'user_name': getFormInputVal(form,'user_name') , // form.find('input#name').val(),
         'email': getFormInputVal(form,'email') ,  // form.find('input#email').val(),
         'url': getFormInputVal(form, 'url'), //  form.find('input#url').val(),
         'body': getFormData(form,'url'), // form.find('textarea#body').val(),
         'entity_id': getFormData(form,'entity_id') // form.find('input[name=entity_id]').val()
         }
         */
    }

    /**
     * retrieve the specified inputName's value from form
     * @param form
     * @param inputName
     */
    function getFormInputVal(form, inputName) {
        form.find('input[name$="[' + inputName + ']"]').val();
    }

    function bindHandler() {
        /* When the comment form is submitted, serialize the form data
         as JSON
         and POST it to the API. */
        $('.comment-form form').on('submit', function () {
            var form = $(this);
            var formData = getFormData(form);
            console.log(formData);

            var request = $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,  // JSON.stringify(formData),
                //  contentType: 'application/json; charset=utf-8',
                dataType: 'json'
            });
            request.success(function (data) {
                alertDiv = makeAlert('success', 'Success', 'your comment    was posted.');
                form.before(alertDiv);
                form[0].reset();
                // 添加新的评论数据到首部
                var commentMarkup = renderComment(data);
                $(formSelector).before($(commentMarkup));

            });
            request.fail(function () {
                alertDiv = makeAlert('danger', 'Error', 'your comment was    not posted.');
                form.before(alertDiv);
            });
            return false;
        });
    }

    exports.bindHandler = bindHandler;
    exports.load = load;

    // 外部传入请求comment时的URL
    exports.setCommentListUrl = function(url){ commentListUrl = url} ;

})(Comments, jQuery);