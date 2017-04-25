var tab = $$('.tab').children;
var online = $$('#online');
var study = $$('#studyMaterial');
var news = $$('#news');
var x = 0;
var y = 0;
var z = 0;

study.addEventListener('touchend', function(e) {
    // changeAritcle('studyMaterial', 1, '.study');
    set('.study', 0);
    addStudy();
    $$('.dropload-down')[1].remove();
})

news.addEventListener('touchend', function(e) {
    // changeAritcle('notice', 0, '.news'); 
    console.log(1);
    set('.news', 1);
    addNews();
    $$('.dropload-down')[1].remove();     
})

online.addEventListener('touchend', function(e) {
    // changeAritcle('news', 2, '.online'); 
    set('.online', 2);
    addOnline();
    $$('.dropload-down')[1].remove();
})
//keyword, index, area, page
function changeAritcle(k, i, a, p) {
    set(a, i);
    add(k, a, p);
    $$('.dropload-down')[1].remove();
}

function addStudy() {
    var size = 5;

    $('.content').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            y += 1;
            var result = '';

            $.ajax({
                method: 'GET',
                url: 'http://hongyan.cqupt.edu.cn/cqupt-wechatNews/public/index.php/api/Article/studyMaterial?page='+y+'&size='+size,
                dataType: 'json',

                success: function(res) {
                    var arrLen = res.data.length;
                    var flag = res.totalPageNum;

                    if (y <= flag) {
                        for (var i = 0; i < arrLen; i++) {
                            result += '<a class="news-link" href="' + res.data[i].target_url + '">' 
                                        + '<div class="news-img">' 
                                        + '<img src="' + res.data[i].pictures[0].photo_src + '" alt="">' 
                                        + '</div>' 
                                        + '<div class="news-content">' 
                                        + '<h2 class="news-title">' + res.data[i].title + '</h2>' 
                                        + '<p class="news-desc">' 
                                        + res.data[i].content + '</p>' + '</div>' + '</a>';
                        }
                        // 如果没有数据
                    } else {
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                    }
                        me.resetload();                        
                        $('.study').append(result);
                        // 每次数据插入，必须重置

                },

            })
        }
    });
};

addStudy();

function addNews() {
    var size = 5;

    $('.content').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            x += 1;
            var result = '';
            $.ajax({
                method: 'GET',
                url: 'http://hongyan.cqupt.edu.cn/cqupt-wechatNews/public/index.php/api/Article/news?page='+x+'&size='+size,
                dataType: 'json',

                success: function(res) {
                    var arrLen = res.data.length;
                    var flag = res.totalPageNum;

                    if (x <= flag) {
                        for (var i = 0; i < arrLen; i++) {
                            result += '<a class="news-link" href="' + res.data[i].target_url + '">' 
                                        + '<div class="news-img">' 
                                        + '<img src="' + res.data[i].pictures[0].photo_src + '" alt="">' 
                                        + '</div>' 
                                        + '<div class="news-content">' 
                                        + '<h2 class="news-title">' + res.data[i].title + '</h2>' 
                                        + '<p class="news-desc">' 
                                        + res.data[i].content + '</p>' + '</div>' + '</a>';
                        }
                        // 如果没有数据
                    } else {
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                    }
                    // 为了测试，延迟1秒加载
                    // setTimeout(function() {
                    //     // 插入数据到页面，放到最后面
                    //     $(area).append(result);
                    //     // 每次数据插入，必须重置
                    //     me.resetload();
                    // }, 1000);
                        // 插入数据到页面，放到最后面
                        me.resetload();                        
                        $('.news').append(result);
                        // 每次数据插入，必须重置

                },

            })
        }
    });
};

function addOnline() {
    var size = 5;

    $('.content').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            z += 1;
            var result = '';

            $.ajax({
                method: 'GET',
                url: 'http://hongyan.cqupt.edu.cn/cqupt-wechatNews/public/index.php/api/Article/online?page='+z+'&size='+size,
                dataType: 'json',

                success: function(res) {
                    var arrLen = res.data.length;
                    var flag = res.totalPageNum;
                    // console.log(z);

                    if (z <= flag) {
                        for (var i = 0; i < arrLen; i++) {
                            result += '<a class="news-link" href="' + res.data[i].target_url + '">' 
                                        + '<div class="news-img">' 
                                        + '<img src="' + res.data[i].pictures[0].photo_src + '" alt="">' 
                                        + '</div>' 
                                        + '<div class="news-content">' 
                                        + '<h2 class="news-title">' + res.data[i].title + '</h2>' 
                                        + '<p class="news-desc">' 
                                        + res.data[i].content + '</p>' + '</div>' + '</a>';
                        }
                        // 如果没有数据
                    } else {
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                    }
                        me.resetload();                        
                        $('.online').append(result);
                        // 每次数据插入，必须重置

                },

            })
        }
    });
};

function set(ele, num) {
    for (var i = 0; i < 3; i++) {
        $$('.area')[i].style.display = 'none';
        tab[i].className = '';
    }
    $$(ele).style.display = 'block';
    tab[num].className = 'active';
}