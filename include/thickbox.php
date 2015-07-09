<?php
function oi_yamaps_button() // Добавляем кнопку редактирования шорткода на страницу редактирования поста в админке
{
?>
<a href="#TB_inline?width=320&inlineId=insert_oi_yamaps" id="oi_yamaps_button" class="thickbox button" title="<?php _e("Yandex Map", "oiyamaps"); ?>"><?php _e("Yandex Map", "oiyamaps"); ?></a>
<?php
}

function oi_yamaps_thickbox() // окно редактирования шорткода
{
	$fields = array(
			'address'		=> array(
								'label'	=> __('Address','oiyamaps'),
								'value'	=> '',
								),
			'coordinates'	=> array(
								'label'	=> __('Coordinates','oiyamaps'),
								'value'	=> '',
								),
			'center'		=> array(
								'label'	=> __('Map center','oiyamaps'),
								'hint'	=> __('It should be a coordinates, like 55.754736,37.620875','oiyamaps').'<br>'.__('By default center = coordinates','oiyamaps'),
								'value'	=> '',
								),
			'header'		=> array(
								'label'	=> __('Baloon header','oiyamaps'),
								'value'	=> '',
								),
			'body'			=> array(
								'label'	=> __('Baloon body content','oiyamaps'),
								'value'	=> '',
								),
			'footer'		=> array(
								'label'	=> __('Baloon footer','oiyamaps'),
								'value'	=> '',
								),
			'hint'			=> array(
								'label'	=> __('Placemark hint','oiyamaps'),
								'value'	=> '',
								),
			'height'		=> array(
								'label'	=> __('Map height','oiyamaps'),
								'hint'	=> __('Default: ','oiyamaps'),
								'value'	=> '',
								),
			'width'			=> array(
								'label'	=> __('Map width','oiyamaps'),
								'hint'	=> __('Default: ','oiyamaps'),
								'value'	=> '',
								),
			'zoom'			=> array(
								'label'	=> __('Map zoom','oiyamaps'),
								'hint'	=> __('Default: ','oiyamaps'),
								'value'	=> '',
								),
			'iconcontent'	=> array(
								'label'	=> __('Plcamark label','oiyamaps'),
								'value'	=> '',
								),
			'placemark'		=> array(
								'label'	=> __('Plcamark type','oiyamaps'),
								'hint'	=> __('Default: ','oiyamaps'),
								'value'	=> '',
								),
	);
	$out = '';
	$out1 = '';
	$out2 = '';
	$out3 = '';
	$out4 = '';
	$options = get_option( OIYM_PREFIX.'options' );
	foreach($options as $k=>$v) // получаем опции из бд
	{
		if($$k==''){$$k = $v;} // формируем список переменных с нормальными именами
	}
	
	foreach($fields as $field=>$val)
	{
		$out1 .= 'var '.$field.' = jQuery("#'.$field.'").val();'."\n"; // формируем список объявления переменных для JS
		$out2 .= "if({$field}!=''){{$field}=' {$field}=\"' + {$field} +'\"';}else{{$field}='';}"; // формируем условия вывода параметров в шорткод
		$out3 .= '+'.$field; // формируем строку параметров со значениями
		if( $val['hint'] ) // если есть подсказка, формируем ее внешний вид
		{
			$hint = '<p class="help-block description">'.$val['hint'].' '.$$field.'</p>';
		}else
		{
			$hint = '';
		}
		 // формируем таблицу с полями
		$out4 .= 
		'<tr>'.
			'<td><label for="'.$field.'">'.$val['label'].'</label></td>'.
			'<td><input name="'.$field.'" id="'.$field.'" value="" />'.
				$hint.
			'</td>'.
		'</tr>';
	}
	$out = '
<script>
	function insert_oi_yamaps(){
	';
	$out .= 
		$out1.
		$out2.'window.send_to_editor("[showyamap " '.$out3.'+ "/]");';
	$out .= '
	}
</script>';
	$out = $out.
	'<div id="insert_oi_yamaps" style="display:none;"><div>'.
	'<form>'.
	'<table class="widefat">'.
	$out4.
	'<tr><td>'.
	'<input type="button" class="button-primary" value="Add shortcode" onclick="insert_oi_yamaps();"/>'.
	'<a class="button-cancel" href="#" onclick="tb_remove(); return false;">'.__("Cancel").'</a>'.
	'</td><td></td></tr>'.
	'</table>'.
	'</form></div></div>';
	//add_thickbox();
	print $out;
}

add_action( 'admin_footer', 'get_cords_javascript' ); // встраиваем скрипт в футер
function get_cords_javascript() // скрипт агригации php через ajax
{
?>
<script type="text/javascript" >
jQuery(document).ready(function($) {
	function get_cords() // функция вызова php функции и получение результата ее работы
	{
		var data = {
			'action': 'get_cords',	// вызываемая php функция - get_cords_callback
			'address': $("#TB_ajaxContent #address").val() // передаваемый параметр
		};

		$.post(ajaxurl, data, function(response) {
			$("#TB_ajaxContent #coordinates").val( response ); // помещаем полученный результат от функции php в нужное место
		});
	}
	$("#address").bind("change",function(){ //событие при котором запускаем функцию
		get_cords(); // запускаем процедуру выполнения php функции
	});
	
	$("#coordinates").bind("change",function(){ // если введены непосредственно координаты...
		$("#address").val(''); // очищаем строку адреса
	});
	
});
</script>
<?php
}
add_action('wp_ajax_get_cords', 'get_cords_callback');

function get_cords_callback() // вычисление и возврат координат
{
	echo coordinates( $_POST['address'] ); // функция вычисления координат по предоставленному адресу
    die(); // необходимо, для правильного возвращения результата
}
?>