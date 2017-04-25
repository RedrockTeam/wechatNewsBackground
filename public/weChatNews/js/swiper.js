var swiper = $$('.swiper');
var indicator = $$('.indicator');
var startPoint;
var endPoint;
var disX;
var startEle = 0;
var index = 0;
var dis = 0;
var imgArr;
var w = $$('.container').clientWidth;
var fs = document.getElementsByTagName('html')[0].style.fontSize.replace('px','');
console.log(fs);

$.ajax({
        method: 'GET',
        url: 'http://hongyan.cqupt.edu.cn/cqupt-wechatNews/public/index.php/api/Article/hotArticle?page=1&size=3',
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
            swiper.style.width = imgArr.length * 100 + "%";
            for (var i = 0; i < imgArr.length; i++) {
                $$('.banner')[i].style.width = 1/imgArr.length * 100 + "%";
                $$('.banner-img')[i].style.width = 100 + "%";   
            }
        }    
})

swiper.addEventListener('touchstart', function (e) {
    clearInterval(timer);
    startPoint = e.changedTouches[0].pageX;
    startEle = trans(swiper, "translateX");
}); 
swiper.addEventListener('touchmove', function(e) {
    endPoint = e.changedTouches[0].pageX;
    disX = endPoint - startPoint;
    trans(swiper, "translateX", (disX + startEle)/fs + dis);
});
swiper.addEventListener('touchend', function (e) {
    if (disX < 0 && dis > -10*(imgArr.length - 1)) {
        dis = dis - w / fs;
        index++;
    } else if (disX > 0 && dis < 0) {
        dis = dis + w / fs;
        index--;
    } 
    trans(swiper,"translateX",w);
    buttonChange(indicator.children);
    auto();
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
var timer = 0;

function auto(){
    clearInterval(timer);
    timer = setInterval(function() {
        swiper.style.transition = "none";
        trans(swiper, "translateX", dis);
        setTimeout(function(){
            if (dis > -10*(imgArr.length - 1)) {
                dis = dis - w / fs;
                index++;
            } else if (dis < 0) {
                dis = 0;
                index = 0;
            }
            buttonChange(indicator.children);
        }, 30);
    }, 2000);
};

auto();
