<?php
/*
Template Name: 404页面
*/
?>
<?php get_header(); ?>
<style>#sidebar{display:none;}</style>
<script type="text/javascript">     
function countDown(secs,surl){     
 //alert(surl);     
 var jumpTo = document.getElementById('jumpTo');
 jumpTo.innerHTML=secs;  
 if(--secs>0){     
     setTimeout("countDown("+secs+",'"+surl+"')",1000);     
     }     
 else{       
     location.href=surl;     
     }     
 }     
</script> 
<section id="container" style="width:100%;height: 500px;background-color: #eee;text-align: center;">
<div style="width: 100%;height: 400px; line-height: 400px;font-size: 100pt;color: #ccc;">404</div>
<div style="text-align: center;height: 100px;line-height: 100px;font-size: 14pt;color: #ccc;background-color: #ddd;letter-spacing: 1px;" ><span id="jumpTo">5</span>秒后自动回首页>></div>
<script type="text/javascript">countDown(5,'http://surmon.me');</script>
</section>
<?php get_footer(); ?>