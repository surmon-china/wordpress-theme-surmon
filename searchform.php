<div class="searchform-box">
	<form method="get" class="search-form" action="/" >
        <!-- 定义请求接口 和classs选择器名称 -->
		<input class="search-text" name="s" list="tag" type="search" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php _e( 'Search...', 'Bing' ); ?>" x-webkit-speech lang="zh-CN" required maxlength=15 />
                 <!-- 使用H5新标签list定义预定义数据以及H5优化标签“search”，有删除按钮，同样使用了H5标签placeholder来定义搜索框预显示搜索词 -->
<datalist id="tag">
  <option value="Javascript">
  <option value="css">
  <option value="思考">
  <option value="情感">
  <option value="创业">
  <option value="互联网">
</datalist>
<!-- 使用H5新标签datalist来预定义搜索框数据，甚至可以模拟少量数据的首字母筛选效果，用法和select一样，但是需要id属性配合 input的list属性才会生效，否则不显示 -->
		<i class="fa fa-search"></i><!-- 使用CSS的内容生成器before来使用icon-font来显示图标 -->
		<input class="search-submit span-search" alt="search" type="submit" />
                 <!-- 提交输入框的数据，即提交按钮 -->
	</form>
</div>