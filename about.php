<?php
/*
Template Name: About
*/
?>
<?php get_header(); ?>
<style>
.about_me {
	width: 100%;
	height: auto;
	background: #eee;
	padding: 30px 50px;
}

.about_me_main {
	width: 100%;
	margin: 0 auto;
}

.about_me_main p {
	line-height: 40px;
	min-height: 40px;
	font-family: "Century Gothic","Microsoft yahei";
	font-size: 12px;
	color: #666;
}

.about_me_main p i {
	color: #B8B8B8;
	font-size: 12px;
	margin-right: 15px;
	display: inline-block;
	width: 20px;
	height: 20px;
	line-height: 20px;
	text-align: center;
	background-color: #ddd;
}

.about_hr {
	width: 100%;
	height: 10px;
	background-color: #ccc;
}

.about_opus {
	width: 100%;
	overflow: hidden;
	height: 280px;
	border: 10px solid #eee;
}

.about_theme {
	width: 100%;
  height: 80px;
  background: #eee;
  margin-bottom: 10px;
  text-align: left;
  line-height: 80px;
  font-size: 20px;
  color: #ABABAB;
  font-style: inherit;
  padding: 10px;
  float: left;
  -webkit-transition: all .5s;
  -moz-transition: all .5s;
  -ms-transition: all .5s;
  -o-transition: all .5s;
  transition: all .5s;
}

.about_theme:hover {
	background-color: #ddd;
	color: #8D8D8D;
	-webkit-transition: background 0.5s;
	-moz-transition: background 0.5s;
	-o-transition: background 0.5s;
	-ms-transition: background 0.5s;
	transition: background 0.5s;
}

.about_theme a span{
  margin-left: 2%;
  font-size: 14px;
}

.about_theme a{display:block;}

.about_theme a p{display:block}

.about_theme_all {
	width: 100%;
	height: 180px;
}
</style>
<section id="container">
<div class="about_all">
<div class="about_me">
<div class="about_me_main">
<p><i class="fa fa-user"></i>I'm Surmon（Before this , I'm responsible for "www.nocower.com"）</p>
<p><i class="fa fa-user"></i>New Site：Surmon.me（<s>www.nocower.com</s>）</p>
<p><i class="fa fa-comment"></i>QQ: <a href="tencent://Message/?Uin=794939078&websiteName=surmon.me=&Menu=yes" target="_blank">794939078</a></p>
<p><i class="fa fa-comments"></i>Group：①&nbsp;<a href="http://shang.qq.com/wpa/qunwpa?idkey=837dc31ccbcd49feeba19430562be7bdc06f4428880f78a391fd61c8af714ce4" target="_blank" rel="nofollow">288325802</a>&nbsp;&nbsp;&nbsp;&nbsp;②&nbsp;<a href="http://shang.qq.com/wpa/qunwpa?idkey=7576e7204e01f8b9e26c90b4e0d84b6acab3b757e55286ba66e3b40ccec382e7" target="_blank" rel="nofollow">137080447</a></p>
<p><i class="fa fa-envelope"></i>E-Mail: <a href="mailto:surmon@foxmail.com" target="_blank" rel="nofollow">Surmon@foxmail.com</a></p>
<p><i class="fa fa-map-marker"></i>Add: XI'AN</p>
<p><i class="fa fa-github"></i>GitHub：<a href="https://github.com/surmon-china" target="_blank" rel="nofollow">https://github.com/surmon-china</a></p>
<p><i class="fa fa-music"></i><a href="http://www.xiami.com/radio/play/type/4/oid/11925881" target="_blank" rel="nofollow">Music: Jazz-HipHop, Rock, POP, Classical, New Age, EM</a></p>
<p><i class="fa fa-heart"></i>Skill: H5/Canvas, CSS3/Sass/Less, Javascript, JQuery, Ajax, Ps, PHP, Bootstrap, AngulaeJS, Wordpress, Hybrid App</p>
<p><i class="fa fa-check"></i>Service: Full Stack service.</p>
<p><i class="fa fa-exclamation" style="margin-left: 1px;"></i>以至高用户体验为精神目标，专注功能实现/框架重构/交互优化</p>
<!--<p><i class="fa fa-trophy"></i>求伯乐：由于钟情于各种语言及思想，我会经常忘记一些代码的语法和API，所以我经常需要去查询重复的信息，我觉得没有搜索引擎我可能没法工作。也许你认为，这是技术不够的表现。我记的只是一个Key，一个如何找寻答案的索引，而不是全部，我只会尽可能让大脑始终充斥最有价值的信息和思想</p>-->
</div>
</div>
<div class="about_hr"></div>
<div class="about_opus">
<iframe src="http://surmon.me/about_map.html" style="width: 960px; height: 280px;"></iframe>
</div>
<div class="about_hr"></div>
<div class="about_theme_all">
<div class="about_theme"><a href="http://surmon.me/228.html">One-Theme<span>时尚小清新响应式的Wordpress主题，适用于个人Blog</span></a></div>
<div class="about_theme"><a href="http://surmon.me/225.html">Metro-Theme<span>简洁高效的的Wordpress主题， 适用于Blog/轻CMS</span></a></div>
<div class="about_theme"><a href="http://surmon.me/232.html">Think-Theme<span>充满现代感的的Wordpress主题，适用于资讯/新闻/科技站</span></a></div>
<div class="about_theme"><a href="http://surmon.me/230.html">Portal-Theme<span>大气门户的Wordpress主题，适用于讯息展现类门户地方</span></a></div>
<div class="about_theme"><a href="http://surmon.me/656.html">Hshow前端工具箱插件<span>集成多功能，简化开发，便捷高效</span></a></div>
</div>
</div>
</section>
<script>
$(function(){
   $("#sidebar").animate({width:"0px",opacity:"0",display:"none"},1000,function(){
   $("#sidebar").css('display','none');
   });
   $(".about_all").animate({width:"960px"},1000);
})
</script>
<?php get_footer(); ?>