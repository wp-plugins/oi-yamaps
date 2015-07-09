<?php
function oiym_fields()
{
	$fields = array(
					'height' => array(
								'title' => __('Map height','oiyamaps'),
								'type' => 'text',
								'section' => 'setting_section_1',
								'page' => 'oiym-setting-admin',
								'hint' => __('Use px or %. 400px by default','oiyamaps'),
					),
					'width' => array(
								'title' => __('Map width','oiyamaps'),
								'type' => 'text',
								'section' => 'setting_section_1',
								'page' => 'oiym-setting-admin',
								'hint' => __('Use px or %. 100% by default','oiyamaps'),
					),
					'zoom' => array(
								'title' => __('Map zoom','oiyamaps'),
								'type' => 'text',
								'section' => 'setting_section_1',
								'page' => 'oiym-setting-admin',
								'hint' => __('16 by default','oiyamaps'),
					),
					'placemark' => array(
								'title' => __('Default placemark','oiyamaps'),
								'type' => 'text',
								'section' => 'setting_section_1',
								'page' => 'oiym-setting-admin',
								'hint' => __('You can use different placemarks. Checkout this page - '.'<a target="_blank" href="http://api.yandex.ru/maps/doc/jsapi/2.x/ref/reference/option.presetStorage.xml">http://api.yandex.ru/maps/...</a>','oiyamaps'),
					),
					'author_link' => array(
								'title' => __("Show link to the plugin's page",'oiyamaps'),
								'type' => 'checkbox',
								'section' => 'setting_section_1',
								'page' => 'oiym-setting-admin',
								'hint' => __('It is just a link to the plugin page in corner of the map.','oiyamaps'),
					),
	);
	return $fields;
}

function oiym_psf($atts)
{
	$fields = oiym_fields();
	extract(shortcode_atts(array(
		'key'			=> '',
		'type'			=> '',
		'before'		=> null,
		'after'			=> null,
		'width'			=> '200px',
		'placeholder'	=> '',
		'hint'			=> '',
		'value'			=> '',
		'readonly'		=> false,
		'disabled'		=> false,
		'required'		=> '',
		'addon'			=> '',
	), $atts));
	if($hint==''){$hint = $fields[$key]['hint'];}
	if($type==''){$type = $fields[$key]['type'];}
	if($key)
	{
		if($hint){$hint = '<p class="help-block description">'.$hint.'</p>';}
		if($placeholder){$placeholder = ' placeholder="'.$placeholder.'"';}
		if($readonly==true){$readonly = ' readonly';}else{$readonly = '';}
		if($disabled==true){$disabled = ' disabled="disabled"';}else{$disabled = '';}
		if($width=='200px'&&$type=='textarea')
		{
			$style = 'style="width: 98%;height: 100px;"';
		}else
		{
			$style = '';
		}
		$addon = $style.$readonly.$disabled.$placeholder.' '.$required.' '.$addon;
		if($type=='checkbox'){$class = ' class="checkbox-inline"';}else{$class = '';}
		if($before){$before = '<label'.$class.' for="'.$key.'">'.$before.'</label>';}
		if($after){$after = '<label'.$class.' style="margin-right:25px;" for="'.$key.'">'.$after.'</label>';}
		switch ($type) {
			case 'select':
						$out = $before.
						'<select class="form-control" id="'.$key.'" name="'.$key.'"'.$addon.'>'.
							$value.
						'</select>'.
						$after.$hint;
				break;
			case 'text':
	$out = $before.'<input type="'.$type.'" id="'.OIYM_PREFIX.'options['.$key.']" name="'.OIYM_PREFIX.'options['.$key.']" class="regular-text" value="'.$value.'" '.$addon.'/>'.$after.$hint;
				break;
			case 'hidden':
	$out = $before.'<input type="'.$type.'" id="'.OIYM_PREFIX.'options['.$key.']" name="'.OIYM_PREFIX.'options['.$key.']" value="'.$value.'">'.$after.$hint;
				break;
			case 'checkbox':
				if($value=='1'){$checked_flag = ' checked';}else{$checked_flag = '';}
	$out = $before.'<input type="'.$type.'" id="'.OIYM_PREFIX.'options['.$key.']" name="'.OIYM_PREFIX.'options['.$key.']"'.' value="1"'.$checked_flag.''.$addon.'>'.$after.$hint;
				break;
			case 'textarea':
	$out = $before.'<textarea class="wp-editor-area" id="'.OIYM_PREFIX.'options['.$key.']" name="'.OIYM_PREFIX.'options['.$key.']" '.$addon.'>'.$value.'</textarea>'.$after.$hint;
				break;
		}
		return $out;
	}
}

class OIYM_SettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            __('Oi Yandex Maps Settings','oiyamaps'), 
            __('Oi Yandex Maps','oiyamaps'), 
            'manage_options', 
            'oiym-setting-admin', 
            array( $this, 'settings_page' )
        );
    }

    /**
     * Options page callback
     */
    public function settings_page()
    {
        // Set class property
        $this->options = (get_option( OIYM_PREFIX.'options' , oi_yamaps_defaults() ) );
        ?>
<style>
.block-left {float: left;width: 50%;}
</style>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2><?php _e('Oi Yandex Maps Settings','oiyamaps'); ?></h2>
			<div class="block-left">
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( OIYM_PREFIX.'option_group' );
                submit_button(); 
                do_settings_sections( 'oiym-setting-admin' );
                submit_button(); 
            ?>
            </form>
			</div>
			<div class="block-left">
			<h4><?php _e('Oi Yandex.Maps for WordPress Needs Your Support','oiyamaps'); ?></h4>
<p><?php _e('If you like this plugin, you can support me and make a donation. But even if you don`t, you can use the plugin without any restrictions.','oiyamaps'); ?></p>
<p><?php _e('Your donation will help encourage and support the plugin`s continued development and better user support.','oiyamaps'); ?></p>
<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/shop.xml?account=41001112308777&quickpay=shop&payment-type-choice=on&writer=seller&targets=Oi+Ya.Maps+for+WordPress+donation&targets-hint=&default-sum=350&button-text=03&mail=on&successURL=successURL=http%3A%2F%2Fwww.easywebsite.ru%2Fshop%2Fplugins-wordpress%2Foi-ya-maps%3Fmsg%3Dthanks" width="450" height="198"></iframe>

			</div>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            OIYM_PREFIX.'option_group', // Option group
            OIYM_PREFIX.'options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
		
		$sections = $this->sections();
		foreach($sections as $section=>$val)
		{
			$callback = array( $this, $section.'_callback' );
			add_settings_section(
				$section,								// ID - ключ элемента
				$val['title'],							// Заголовок
				$callback,	// Функция вывода
				$val['page']							// Страница, на которой расположен элемент
			);      
		}
		$fields = oiym_fields();
		foreach($fields as $field=>$val)
		{
			$callback = array( $this, $field.'_callback' );
			add_settings_field(
				$field,								// ID - ключ элемента
				$val['title'],						// Заголовок
				$callback,	// Функция вывода
				$val['page'],						// Страница, на которой расположен элемент
				$val['section']						// Группа в которой расположен элемент
			);      
		}
    
    }
	// fields and theme attributes
    public function sections()
    {
		$fields = array(
						'setting_section_1' => array(
									'title' => __('Map defaults','oiyamaps'),
									'page' => 'oiym-setting-admin',
						),
						'setting_section_2' => array(
									'title' => __('Info','oiyamaps'),
									'page' => 'oiym-setting-admin',
						),
		);
		return $fields;
	}
    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
		$fields = oiym_fields();
		foreach($fields as $field=>$val)
		{
			 if(isset($input[$field]))
			 {
				if($val['type']=='number'){$new_input[$field] = absint( $input[$field] );}
				if($val['type']=='text'){$new_input[$field] = sanitize_text_field( $input[$field] );}
				if($val['type']=='checkbox'){$new_input[$field] = absint( $input[$field] );}
			 }
		}

        return $new_input;
    }
/* START: EDIT HERE */
	/** 
	* Print the Section text
	*/
	public function setting_section_1_callback()
	{

		print _e('Default parameters','oiyamaps');
	}
	public function setting_section_2_callback()
	{
		$text = '<h3>'.__('Without parameters','oiyamaps').'</h3>'.
'<p><code>[showyamap]</code> - '.__('in this case you should use custom fields in the post with added map. Fields names should be ','oiyamaps').'<b>"latitude"</b> ' .__('and','oiyamaps').' <b>"longitude"</b>.</p>'.
'<h3>'.__('With parameters','oiyamaps').'</h3>'.
'<p><code>[showyamap address="Moscow, Birulevskaya, 1"]</code> - '.__('it is uses Yandex server to know coordinates by address.','oiyamaps').'</p>'.
'<p><code>[showyamap address="Moscow, Birulevskaya, 1/2" coordinates="55.601950,37.664752"]</code> - '.__('in this case you will see the place pointed by <b>coordinates</b> instead of address, because <b>"coordinates"</b> has priority.','oiyamaps').'</p>'.
'<h3>'.__('Placemarks','oiyamaps').'</h3>'.
'<p>'.__('You able to use many placemarks. Just write it inside content part of shortcode.','oiyamaps').'</p>'.
'<pre><code>
[showyamap]
	[placemark address="Moscow, Birulevskaya, 1"]
[/showyamap]
</code></pre>'.
'<p>'.__('First placemark will be taken from custom fields, second from placemark shortcode.','oiyamaps').'</p>'.
'<pre><code>
[showyamap address="Moscow, Birulevskaya, 1/2"]
	[placemark address="Moscow, Birulevskaya, 1"]
[/showyamap]
</code></pre>'.
'<p>'.__('First placemark will be taken from showyamap shortcode, second from placemark shortcode.','oiyamaps').'</p>'.
'<h3>'.__('Parameters','oiyamaps').'</h3>'.
'<pre>
[showyamap
	address		- '.__('Place address','oiyamaps').'
	header		- '.__('Baloon header','oiyamaps').'
	body		- '.__('Baloon body content','oiyamaps').'
	footer		- '.__('Baloon footer content','oiyamaps').'
	hint		- '.__('Text on hover placemark','oiyamaps').'
	coordinates	- '.__('Place coordinates','oiyamaps').'
	height		- '.__('Height of map','oiyamaps').'
	width		- '.__('Width of map','oiyamaps').'
	zoom		- '.__('Zoom of map','oiyamaps').'
	iconcontent	- '.__('Icon content for stretch icons','oiyamaps').'
	placemark	- '.__('Placemark type','oiyamaps').'
]
</pre>

<pre>
[placemark
	address		- '.__('Place address','oiyamaps').'
	header		- '.__('Baloon header','oiyamaps').'
	body		- '.__('Baloon body content','oiyamaps').'
	footer		- '.__('Baloon footer content','oiyamaps').'
	hint		- '.__('Text on hover placemark','oiyamaps').'
	coordinates	- '.__('Place coordinates','oiyamaps').'
	iconcontent	- '.__('Icon content for stretch icons','oiyamaps').'
	placemark	- '.__('Placemark type','oiyamaps').'
]
</pre>';
	
		print $text;
	}

	/** 
	* Get the settings option array and print one of its values
	*/
	public function height_callback()
	{
		$key = 'height';
		print oiym_psf(array('key'=>$key,'value'=>esc_attr( $this->options[$key]),));
	}
	public function width_callback()
	{
		$key = 'width';
		print oiym_psf(array('key'=>$key,'value'=>esc_attr( $this->options[$key]),));
	}
	public function zoom_callback()
	{
		$key = 'zoom';
		print oiym_psf(array('key'=>$key,'value'=>esc_attr( $this->options[$key]),));
	}
	public function placemark_callback()
	{
		$key = 'placemark';
		print oiym_psf(array('key'=>$key,'value'=>esc_attr( $this->options[$key]),));
	}
	public function author_link_callback()
	{
		$key = 'author_link';
		print oiym_psf(array('key'=>$key,'value'=>esc_attr( $this->options[$key]),));
	}

/* END: EDIT HERE */

}

if( is_admin() )
    $my_settings_page = new OIYM_SettingsPage();