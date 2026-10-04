<?php
defined('ABSPATH') || exit;
function rema_array_get($array,$path,$fallback=''){foreach(explode('.',$path) as $key){if(!is_array($array)||!array_key_exists($key,$array))return $fallback;$array=$array[$key];}return $array;}
function rema_array_set(&$array,$path,$value){$keys=explode('.',$path);$cursor=&$array;foreach($keys as $key){if(!isset($cursor[$key])||!is_array($cursor[$key]))$cursor[$key]=array();$cursor=&$cursor[$key];}$cursor=$value;}
function rema_get_settings(){return array_replace_recursive(rema_default_settings(),(array)get_option('rema_theme_settings',array()));}
function rema_t($value){return function_exists('pll__')?pll__($value):$value;}
function rema_content($path,$fallback=''){return rema_t((string)rema_array_get(rema_get_settings(),$path,$fallback));}
function rema_asset($path){$url=rema_array_get(rema_get_settings(),$path);return $url?esc_url($url):'';}
function rema_image_html($url,$alt='',$class=''){return $url?sprintf('<img src="%s" alt="%s" class="%s" loading="lazy">',esc_url($url),esc_attr(wp_strip_all_tags($alt)),esc_attr($class)):'';}
function rema_language_switcher(){
 if(!function_exists('pll_the_languages'))return '';$languages=pll_the_languages(array('raw'=>1,'hide_if_empty'=>0));if(!is_array($languages)||count($languages)<2)return '';
 $out='<div class="dropdown rema-language"><button class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-solid fa-globe"></i> '.esc_html(strtoupper(pll_current_language('slug'))).'</button><ul class="dropdown-menu dropdown-menu-end">';
 foreach($languages as $lang)$out.='<li><a class="dropdown-item'.(!empty($lang['current_lang'])?' active':'').'" href="'.esc_url($lang['url']).'">'.esc_html($lang['name']).'</a></li>';return $out.'</ul></div>';
}
function rema_translatable_fields(){$fields=array('header.about_label'=>'Header About','header.brands_label'=>'Header Brands','header.shop_label'=>'Header Shop','header.account_label'=>'Header account','hero.title'=>'Hero title','hero.button'=>'Hero button','intro.title'=>'Intro title','intro.text'=>'Intro text','brands.title'=>'Brands title','brands.rima_text'=>'Rima text','brands.rima_button'=>'Rima button','brands.ramroma_text'=>'Ramroma text','brands.ramroma_button'=>'Ramroma button','divider.text'=>'Divider text','vision.title'=>'Vision title','vision.text'=>'Vision text','mission.title'=>'Mission title','values.title'=>'Values title','lifestyle_family.title'=>'Family title','lifestyle_family.text'=>'Family text','lifestyle_back.title'=>'Journey title','lifestyle_back.text'=>'Journey text','lifestyle_back.button'=>'Journey button','footer.about'=>'Footer about','footer.follow'=>'Follow heading','footer.quick'=>'Quick links heading','footer.copyright'=>'Copyright');for($i=0;$i<3;$i++){$fields['mission.items.'.$i.'.title']='Mission card title '.($i+1);$fields['mission.items.'.$i.'.text']='Mission card text '.($i+1);}for($i=0;$i<5;$i++){$fields['values.items.'.$i.'.label']='Value label '.($i+1);$fields['footer.links.'.$i.'.label']='Footer link '.($i+1);}return $fields;}
function rema_section_enabled($id){return(bool)rema_array_get(rema_get_settings(),$id.'.enabled',1);}
function rema_local_icon_asset($item){
 $icon=strtolower((string)($item['icon']??''));$label=strtolower((string)($item['label']??''));$match=$icon.' '.$label;
 $assets=array(
  'fa-gem'=>'values-quality.svg','fa-wand-magic-sparkles'=>'values-art.svg','fa-building-shield'=>'values-empowerment.svg','fa-person-running'=>'values-playfulness.png','fa-leaf'=>'values-sustainability.svg'
 );
 foreach($assets as $needle=>$file)if(strpos($match,$needle)!==false)return get_template_directory_uri().'/assets/images/'.$file;
 return '';
}
function rema_icon_or_image($item,$class=''){
 if(($item['type']??'icon')==='image'&&!empty($item['image']))return rema_image_html($item['image'],$item['label']??'',$class);
 $local=rema_local_icon_asset($item);if($local)return rema_image_html($local,$item['label']??'',$class);
 return '<i class="'.esc_attr($item['icon']??'fa-solid fa-circle').' '.esc_attr($class).'" aria-hidden="true"></i>';
}
function rema_dynamic_css(){
 $s=rema_get_settings();$t=$s['typography'];$c=$s['colors'];
 return ':root{--rema-ink:'.esc_attr($c['ink']).';--rema-muted:'.esc_attr($c['muted']).';--rema-soft:'.esc_attr($c['soft']).';--rema-footer:'.esc_attr($c['footer']).';--rema-heading:'.intval($t['heading_desktop']).'px;--rema-hero:'.intval($t['hero_desktop']).'px;--rema-body:'.intval($t['body_desktop']).'px}@media(max-width:991.98px){:root{--rema-heading:'.intval($t['heading_tablet']).'px;--rema-hero:'.intval($t['hero_tablet']).'px;--rema-body:'.intval($t['body_tablet']).'px}}@media(max-width:575.98px){:root{--rema-heading:'.intval($t['heading_mobile']).'px;--rema-hero:'.intval($t['hero_mobile']).'px;--rema-body:'.intval($t['body_mobile']).'px}}';
}
add_action('wp_head',function(){echo '<style id="rema-dashboard-vars">'.rema_dynamic_css().'</style>';},20);
