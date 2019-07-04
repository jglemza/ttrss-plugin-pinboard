function shareArticleToPinboard(id) {
    try {
            var query = "?op=pluginhandler&plugin=pinboard&method=getInfo&id=" + encodeURIComponent(id);

            console.log(query);

            var d = new Date();
            var ts = d.getTime();

            var w = window.open('backend.php?op=backend&method=loading', 'ttrss_tweet',
                    "status=0,toolbar=0,location=0,width=650,height=350,scrollbars=1,menubar=0");

            new Ajax.Request("backend.php", {
                    parameters: query,
                    onComplete: function(transport) {
                            var ti = JSON.parse(transport.responseText);

                            var share_url = "http://pinboard.in/add?url=" + encodeURIComponent(ti.link) + "&title=" + encodeURIComponent(ti.title);

                            w.location.href = share_url;

                    } });


    } catch (e) {
            exception_error("tweetArticle", e);
    }
}