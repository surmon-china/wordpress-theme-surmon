<?php
/**
	*用户自定义函数（可删减）
*/

//自动文章关键词内链：


add_filter('the_content','substr_content');
function substr_content($content){
	if(!is_singular()){
		$content=mb_strimwidth(strip_tags($content),0,310);
	}
	return $content;
}
$match_num_from = 1; 
$match_num_to = 90; //一个关键字最多替换
add_filter('the_content','tag_link',10); 
function tag_sort($a, $b){
	if ( $a->name == $b->name ) return 0;
	return ( strlen($a->name) > strlen($b->name) ) ? -1 : 1;
}
function tag_link($content){
global $match_num_from,$match_num_to;
	 $posttags = get_the_tags();
	 if ($posttags) {
		 usort($posttags, "tag_sort");
		 foreach($posttags as $tag) {
			 $link = get_tag_link($tag->term_id); 
			 $keyword = $tag->name;
			 $cleankeyword = stripslashes($keyword);
			 $url = "<a href=\"$link\" title=\"".str_replace('%s',addcslashes($cleankeyword, '$'),__('查看更多关于 %s 的文章'))."\"";
			 $url .= 'class="tag_link"';
			 $url .= ">".addcslashes($cleankeyword, '$')."</a>";
			 $limit = rand($match_num_from,$match_num_to);
             $content = preg_replace( '|(<a[^>]+>)(.*)('.$ex_word.')(.*)(</a[^>]*>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
			 $content = preg_replace( '|(<img)(.*?)('.$ex_word.')(.*?)(>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
				$cleankeyword = preg_quote($cleankeyword,'\'');
					$regEx = '\'(?!((<.*?)|(<a.*?)))('. $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' . $case;
				$content = preg_replace($regEx,$url,$content,$limit);
	$content = str_replace( '%&&&&&%', stripslashes($ex_word), $content);
		 }
	 } 
    return $content; 
}

function article_index($content) {
    $matches = array();
    $ul_li = '';
    //匹配出h2、h3标题
    $rh = "/<h[34]>(.*?)<\/h[34]>/im";
    $h3_num = 0;
    $h4_num = 0;
    //判断是否是文章页
    if(is_single()){
         if(preg_match_all($rh, $content, $matches)) {
            // 找到匹配的结果
            foreach($matches[1] as $num => $title) {
                $hx = substr($matches[0][$num], 0, 3);      //前缀，判断是h2还是h3
                $start = stripos($content, $matches[0][$num]);  //匹配每个标题字符串的起始位置
                $end = strlen($matches[0][$num]);       //匹配每个标题字符串的结束位置
                if($hx == "<h3"){
                    $h3_num += 1; //记录h2的序列，此效果请查看百度百科中的序号，如1.1、1.2中的第一位数
                    $h4_num = 0;
                    // 文章标题添加id，便于目录导航的点击定位
                    $content = substr_replace($content, '<h3 id="h3-'.$num.'">'.$title.'</h3>',$start,$end);
                    $title = preg_replace('/<.+?>/', "", $title); //将h2里面的a链接或者其他标签去除，留下文字
                    $ul_li .= '<li class="h3_nav"><a href="#h3-'.$num.'" target="_self" noajax="true" class="h3-'.$num.'" title="'.$title.'">'.$title."</a></li>\n";
                }else if($hx == "<h4"){
                    $h4_num += 1; //记录h3的序列，此熬过请查看百度百科中的序号，如1.1、1.2中的第二位数
                    $content = substr_replace($content, '<h4 id="h4-'.$num.'">'.$title.'</h4>',$start,$end);
                    $title = preg_replace('/<.+?>/', "", $title); //将h3里面的a链接或者其他标签去除，留下文字
                    $ul_li .= '<li class="h4_nav"><a href="#h4-'.$num.'" target="_self" noajax="true" class="h4-'.$num.'" title="'.$title.'">'.$title."</a></li>\n";
                }   
            }
        }
        // 将目录拼接到文章
        $content =  $content . "<div id=\"post_nav\"><span><i id=\"closeNav\" class=\"fa fa-chevron-left\"></i><i id=\"navToPrev\" class=\"fa fa-chevron-up\"></i><i id=\"navToNext\" class=\"fa fa-chevron-down\"></i></span><div class=\"post_nav_main\"><ul class=\"post_nav_content\">\n" . $ul_li . "</ul></div></div>\n";
        return $content;
    }elseif(is_home){
        return $content;
    }
}
add_filter( "the_content", "article_index" );

//Page End.
