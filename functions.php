<?php
/*--- CONSTANTS ---*/
define('THEMEROOT', get_stylesheet_directory_uri());


/*--- LOAD SCRIPTS AND STYLES ---*/

function load_style_script() {
	wp_enqueue_script('my_jquery', THEMEROOT.'/js/jquery-1.10.1.min.js');
	wp_enqueue_script('jqFancyTransitions', THEMEROOT.'/js/jqFancyTransitions.1.8.min.js');
	wp_enqueue_style('style', THEMEROOT.'/style.css');
}

add_action('wp_enqueue_scripts', 'load_style_script');

/*--- ADD THUMBNAILS FOR POST ---*/
add_theme_support('post-thumbnails');
set_post_thumbnail_size(180, 180);




/*--- WIDGETS ---*/

register_sidebar(array(
	'name' => 'Меню',
	'id' => 'menu_header',
	'before_widget' => '',
	'after_widget' => ''
));

register_sidebar(array(
	'name' => 'SideBar',
	'id' => 'sidebar',
	'before_widget' => '<div class="sidebar-widget">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));



function kama_excerpt( $args = '' ){
	global $post;

	$default = array(
		'maxchar'     => 200, // количество символов.
		'text'        => '',  // какой текст обрезать (по умолчанию post_excerpt, если нет post_content.
							  // Если есть тег <!--more-->, то maxchar игнорируется и берется все до <!--more--> вместе с HTML
		'save_format' => false, // Сохранять перенос строк или нет. Если в параметр указать теги, то они НЕ будут вырезаться: пр. '<strong><a>'
		'more_text'   => 'Читать дальше...', // текст ссылки читать дальше
		'echo'        => true, // выводить на экран или возвращать (return) для обработки.
	);

	if( is_array($args) )
		$rgs = $args;
	else
		parse_str( $args, $rgs );

	$args = array_merge( $default, $rgs );

	extract( $args );

	if( ! $text ){
		$text = $post->post_excerpt ? $post->post_excerpt : $post->post_content;

		$text = preg_replace ('~\[[^\]]+\]~', '', $text ); // убираем шоткоды, например:[singlepic id=3]
		// $text = strip_shortcodes( $text ); // или можно так обрезать шоткоды, так будет вырезан шоткод и конструкция текста внутри него
		// и только те шоткоды которые зарегистрированы в WordPress. И эта операция быстрая, но она в десятки раз дольше предыдущей 
		// (хотя там очень маленькие цифры в пределах одной секунды на 50000 повторений)

		// для тега <!--more-->
		if( ! $post->post_excerpt && strpos( $post->post_content, '<!--more-->') ){
			preg_match ('~(.*)<!--more-->~s', $text, $match );
			$text = trim( $match[1] );
			$text = str_replace("\r", '', $text );
			$text = preg_replace( "~\n\n+~s", "</p><p>", $text );

			$more_text = $more_text ? '<a class="kexc_moretext" href="'. get_permalink( $post->ID ) .'#more-'. $post->ID .'">'. $more_text .'</a>' : '';

			$text = '<p>'. str_replace( "\n", '<br />', $text ) .' '. $more_text .'</p>';

			if( $echo )
				return print $text;

			return $text;
		}
		elseif( ! $post->post_excerpt )
			$text = strip_tags( $text, $save_format );
	}   

	// Обрезаем
	if ( mb_strlen( $text ) > $maxchar ){
		$text = mb_substr( $text, 0, $maxchar );
		$text = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ...', $text ); // убираем последнее слово, оно 99% неполное
	}

	// Сохраняем переносы строк. Упрощенный аналог wpautop()
	if( $save_format ){
		$text = str_replace("\r", '', $text );
		$text = preg_replace("~\n\n+~", "</p><p>", $text );
		$text = "<p>". str_replace ("\n", "<br />", trim( $text ) ) ."</p>";
	}

	//$out = preg_replace('@\*[a-z0-9-_]{0,15}\*@', '', $out); // удалить *some_name-1* - фильтр сммайлов

	if( $echo ) return print $text;

	return $text;
}
