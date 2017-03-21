<?php
/**
	*选项样式
*/
//设置选项
function mpanel_item( $value ){
	if( $value['type'] == 'help' ){
		if( $value['id'] ) $id = ' id="' . 'mpanel-item-' . $value['id'] . '"';
		echo '<div class="mpanel-form-table mpanel-form-table-help"' . $id . '>' . $value['name'] . '</div>';
		return;
	}
	global $mpanel;
	if( isset( $value['default'] ) ) $mpanel->original[$value['id']] = $value['default'];
	$option_value = $mpanel->get( $value['id'] );
	if( $value['id'] ) $htmlid = 'mpanel-item-' . $value['id'];
	$panel_box_id = 'mpanel-panel-box-' . $value['id'];
?>
	<div class="mpanel-form-table mpanel-form-table-<?php echo $value['type']; ?>" id="<?php echo $panel_box_id; ?>">
		<?php
		if( $value['help'] ) echo '<div class="mpanel-help" title="' . $value['help'] . '"></div>';
		if( $value['name'] && $value['type'] != 'bigtext' ) echo '<span class="mpanel-panel-name">' . $value['name'] . '</span>';
		switch( $value['type'] ){
			case 'text':
			case 'number':
			case 'password':
			if( $value['type'] == 'text' && $value['placeholder'] ) $placeholder = ' placeholder="' . $value['placeholder'] . '"';
		?>
				<input name="mpanel[<?php echo $value['id']; ?>]" type="<?php echo $value['type']; ?>" id="<?php echo $htmlid; ?>"<?php echo $placeholder; ?> value="<?php echo $option_value; ?>" />
		<?php
			break;
			case 'upload':
		?>
				<input name="mpanel[<?php echo $value['id']; ?>]" type="text" id="<?php echo $htmlid; ?>" value="<?php echo $option_value; ?>" />
				<a class="mpanel-upload-button" href="javascript:;" data-value="<?php echo $htmlid; ?>"><?php _e( '上传', 'Bing' ); ?></a>
				<?php if( !empty( $option_value ) ) echo '<div class="upload-img-box"><img src="' . $option_value . '" /><span class="delete"></span></div>'; ?>
		<?php
			break;
			case 'checkbox':
				if( $option_value ) $checked = ' checked="checked"';
		?>
				<input class="mpanel-checkbox" name="mpanel[<?php echo $value['id']; ?>]" type="<?php echo $value['type']; ?>" id="<?php echo $htmlid; ?>" value="true"<?php echo $checked; ?> />
		<?php
				if( $value['open'] ):
					if( is_array( $value['open'] ) ){
						$i = count( $value['open'] );
						$controlhtmlid = '';
						foreach( $value['open'] as $value ){
							$controlhtmlid .= '#mpanel-panel-box-' . $value;
							if( $i != 1 ) $controlhtmlid .= ',';
							$i--;
						}
					}else $controlhtmlid = '#mpanel-panel-box-' . $value['open'];
		?>
					<script type="text/javascript">
						jQuery(document).ready(function($){
							var htmlid = $("#<?php echo $htmlid; ?>");
							if( !htmlid.attr('checked') ){
								$('<?php echo $controlhtmlid; ?>').hide(100);
							}
							$('#<?php echo $htmlid; ?>').click(function(){
								if( htmlid.attr('checked') ){
									$('<?php echo $controlhtmlid; ?>').show(100);
								}else{
									$('<?php echo $controlhtmlid; ?>').hide(100);
								}
							});
						});
					</script>
		<?php
				endif;
			break;
			case 'select':
			case 'multiple':
				if( !$value['option'] ) return;
				if( $value['type'] == 'multiple' ){
					$multiple = ' multiple="multiple"';
					$multiplearray = '[]';
				}
		?>
				<select name="mpanel[<?php echo $value['id']; ?>]<?php echo $multiplearray; ?>"<?php echo $multiple; ?> id="<?php echo $htmlid; ?>">
					<?php
					$multipletype = $value['type'] == 'multiple';
					$selecttype = $value['type'] == 'select';
					foreach( $value['option'] as $key => $value ){
						if( !is_string( $key ) ) $key = $value;
						if( is_array( $option_value ) && in_array( $key, $option_value ) && $multipletype ) $selected = ' selected="selected"';
						elseif( $option_value === $key && $selecttype ) $selected = ' selected="selected"';
						echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
						$selected = null;
					}
					?>
				</select>
		<?php
			break;
			case 'textarea':
		?>
				<textarea id="<?php echo $htmlid; ?>" name="mpanel[<?php echo $value['id']; ?>]"><?php echo $option_value; ?></textarea>
		<?php
			break;
			case 'color':
		?>
				<input class="colorSelector" name="mpanel[<?php echo $value['id']; ?>]" type="text" id="<?php echo $htmlid; ?>" maxlength="6" value="<?php echo $option_value; ?>" />
		<?php
			break;
			case 'bigtext':
				if( $value['id'] == 'export' ){
					$readonly = ' readonly="readonly"';
					$option_value = base64_encode( json_encode( get_option( THEME_MPANEL_NAME ) ) );
				}
				$bigname = 'mpanel[' . $value['id'] . ']';
				if( $value['id'] == 'export' || $value['id'] == 'import' ) $bigname = 'mpanel-' . $value['id'];
		?>
				<textarea id="<?php echo $htmlid; ?>" name="<?php echo $bigname; ?>"<?php echo $readonly; ?>><?php echo $option_value; ?></textarea>
		<?php
			break;
			case 'list':
		?>
				<div id="<?php echo $htmlid; ?>">
					<input name="mpanel-list-enter" class="mpanel-list-enter" type="text" id="<?php echo $htmlid; ?>" />
					<a href="javascript:;" class="mpanel-list-add"><?php _e( '添加', 'Bing' ); ?></a>
					<ul class="mpanel-list-li">
						<?php
						if( is_array( $option_value ) ):
							foreach( $option_value as $name ):
						?>
								<li>
									<input type="hidden" name="mpanel[<?php echo $value['id']; ?>][]" class="mpanel-list-hidden-content" value="<?php echo $name; ?>">
									<span class="mpanel-list-li-name"><?php echo $name; ?></span>
									<a href="javascript:;" class="mpanel-list-li-delete"></a>
								</li>
						<?php
							endforeach;
						endif;
						?>
					</ul>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function(){
						Custom_List('<?php echo $htmlid; ?>','<?php echo $value['id']; ?>','<?php _e( '不允许出现空格！', 'Bing' ); ?>','<?php _e( '不允许重复的内容！', 'Bing' ); ?>','<?php _e( '不允许空的内容！', 'Bing' ); ?>');
					});
				</script>
		<?php
			break;
			case 'date':
		?>
				<input class="mpanel-cxcalendar" name="mpanel[<?php echo $value['id']; ?>]" type="text" id="<?php echo $htmlid; ?>"<?php echo $placeholder; ?> value="<?php echo $option_value; ?>" />
		<?php
			break;
			case 'radio':
				echo '<div class="mpanel-radio-box">';
				foreach( $value['option'] as $key => $name ){
					if( $option_value == $key ) $checked = ' checked="checked"';
					echo '<label for="' . $value['id'] . '"><input name="mpanel[' . $value['id'] . ']" type="' . $value['type'] . '" value="' . $key . '"' . $checked . ' />' . $name . '</label>';
					$checked = null;
				}
				echo '</div>';
		?>
				
		<?php
			break;
		}
		if( $value['explain'] && ( $value['type'] == 'text' || $value['type'] == 'password' || $value['type'] == 'upload' ) ) echo '<p class="mpanel-explain">' . $value['explain'] . '</p>';
		?>
	</div>
<?php
}

//选项页样式
function mpanel_page( $class = null ){
	global $mpanel;
	$title = Bing_mpanel_menu();
	$array_keys = array_keys( $title );
	$array_keys = $array_keys[$mpanel->page];
	if( $array_keys ) $titleclassis = ' ' . $array_keys;
	$title = $title[$array_keys];
	$mpanel->page++;
	if( !is_null( $class ) ) $classis = ' ' . $class;
?>
	<article id="mpanel-page-id-<?php echo $mpanel->page; ?>" class="mpanel-page<?php echo $classis; ?>">
		<h2 class="title<?php echo $titleclassis; ?>"><?php echo $title; ?></h2>
		<div class="mpanel-page-box">
<?php
}

//结束选项页
function mpanel_pend(){
	echo '</div></article>';
}

//选项组样式
function mpanel_group( $title, $class = null ){
	global $mpanel;
	$mpanel->group++;
	if( !is_null( $class ) ) $classis = ' ' . $class;
?>
	<div class="mpnael-group<?php echo $classis; ?>" id="mpnael-group-id-<?php echo $mpanel->group; ?>">
		<h3 class="title"><?php echo $title; ?></h3>
		<div class="mpnael-group-box">
<?php
}

//结束选项组
function mpanel_gend(){
	echo '</div></div>';
}

//Page End.
