num = 1;
baseArticleUrl = '{{ path('show_article', { 'id' : 'article_id' }) }}';
locale = '{{ app.request.locale }}';

function getArticles() {
    var url = '{{ path('json_article_page', { 'num' : 'var_number' }) }}';
    url = url.replace("var_number", num);
    $.ajax({
        url: url,
        success: function(result) {
            if(JSON.stringify(result) == "[]") {
                num = num - 1;
                return;
            }
            var inner = "";
            var title;
            var index;
            for(index = 0; index < result.length; index++) {
                if(locale == 'en') {
                    title = result[index].titleEn;
                }
                else {
                    title = result[index].title;
                }
                inner = inner + '<p><a href="' + baseArticleUrl.replace("article_id", result[index].id) + '">' + title + '</a></p>';
            }
            $('#links').html(inner);
        }
    });
}

$(document).ready(function() {
    getArticles(num);


    $('#prev').on('click', function() {
        if(num == 1) {
            return;
        }
        num = num - 1;
        getArticles();
    });

    $('#next').on('click', function() {
        num = num + 1;
        getArticles();
    });
});
