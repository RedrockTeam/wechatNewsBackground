var swiper = $$('.swiper');
var indicator = $$('.indicator');
var startPoint;
var endPoint;
var disX;
var startEle = 0;
var index = 0;
var dis = 0;
var imgArr;

$.ajax({
        method: 'GET',
        url: 'http://redrock.team/cqupt-wechatNews/public/index.php/api/Article/hotArticle?page=1&size=3',
        dataType: 'json',
        success: function(res) {
            var imgs = '';
            imgArr = res.data;
            var btn = '';
            for (var i = 0; i < imgArr.length; i++) {
                imgs += '<div class="banner"><a class="banner-link" href="' + imgArr[i].target_url + ' "alt="">'
                        + '<img  class="banner-img" src="'+ imgArr[i].pictures[0].photo_src + ' "alt="">'
                        + '<p class="img-des">' + imgArr[i].title + '</p>' + '</a>' + '</div>';
                btn += '<span></span>'
            }
            swiper.innerHTML = imgs;
            indicator.innerHTML = btn;
            indicator.children[0].className = 'on';
        }    
})

swiper.addEventListener('touchstart', function (e) {
    startPoint = e.changedTouches[0].pageX;
    startEle = trans(swiper, "translateX");
}); 
swiper.addEventListener('touchmove', function(e) {
    endPoint = e.changedTouches[0].pageX;
    disX = endPoint - startPoint;
    trans(swiper, "translateX", (disX + startEle) / 75 + dis);
});
swiper.addEventListener('touchend', function (e) {
    if (disX < 0 && dis > -10*(imgArr.length-1)) {
        dis = dis - 10;
        index++;
    } else if (disX > 0 && dis < 0) {
        dis = dis + 10;
        index--;
    } 
    buttonChange(indicator.children);
});

function trans(ele, attr, val) {
    if (!ele.transform) {
        ele.transform = {};
    };

    if (arguments.length > 2) {

        ele.transform[attr] = val;
        var sval = "";
        for(var s in ele.transform){
            if(s == "translateX"){
                sval += s + "("+ele.transform[s] +"rem)";
            }
            ele.style.WebkitTransform = ele.style.transform = sval;
        }
    } else {
        val = ele.transform[attr];
        if (typeof val == "undefined") {
            if (attr == "translateX") {
                val = 0;
            }
        };
        return val;
    } 
}

function buttonChange(ele) {
    swiper.style.transition = "300ms";
    trans(swiper, "translateX", dis);
    for(var i = 0; i < ele.length; i++) {
        ele[i].className = "";
    };
    ele[index].className = "on";
}
