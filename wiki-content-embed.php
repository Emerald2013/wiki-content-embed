<?php

/**
* Plugin Name: Embed wiki content
* Plugin URI: http://axactsoft.com
* Description: This plugin allows you to embed content from wikipedia into your post and pages using a simple shortcode [embedwiki url='your url']. It supports foreign language characters in urls
* Version: 1.0.0
* Author: Yumna Tatheer
* Author URI: http://axactsoft.com
* License: GPL2
*/

function wikiex_shortcode_custom( $atts ) {
    	ob_start();

		$args = shortcode_atts( 
    array(
      'wikiurl' => '',
	    'sections' => '',
         'settings' => '',
    ), 
    $atts
);
			$wikiurl= $args['wikiurl'];
			$sections = $args['sections'];
			$settings =  $args['settings'];


        if(trim($wikiurl)){
            $wiki_items[0]['url']=$wikiurl;
            $wiki_items[0]['wikiexcb']=$sections;
            $wiki_settings=$settings;
			//$wiki_content="line 96";
        }

         $wiki_content.='<div class="wiki-sections" id="460">';
		
         foreach($wiki_items as $wiki_item){
                 if(empty($wiki_item)) continue;
                   
                 $wiki_url=$wiki_item['url'];
                 $wiki_title='';
                 $wiki_url_root='';
                 
                 if($wiki_url){
                    $term=explode('/',$wiki_url);
                    $wiki_title=array_pop($term);
                    $parse_url=parse_url($wiki_url);
                    $wiki_url_root='http://'.$parse_url['host'].'/';
                 }
$array_section=array();
        //remove
		   
		//remove
                 
                 $wiki_content.='<div class="wiki-item"><h3>'.$wiki_title.'</h3>';
             

                                    
              if($wiki_title){
				 //this condition is true for players list single page. this is being executed twice
					//$wiki_content.="line 319";
                    $wikiurl=$wiki_url_root.'w/api.php?action=parse&page='.rawurldecode($wiki_title).'&prop=text&format=xml';
                    $wiki_xml= wp_remote_get($wikiurl);
                   
					
					$content = html_entity_decode($wiki_xml['body']);
					//var_dump($content);exit;
					 //print_r($content);exit;
					 
                    $wiki_content .= preg_replace('|<strong class="error mw-ext-cite-error">.*?</strong>|i','',$content);
					  $wiki_content =preg_replace('#<a .*?>(.*?)</a>#i', '$1', $wiki_content);
            $wiki_content =preg_replace('#<span class="mw-editsection">.*?]</span></span>#i', '$1', $wiki_content);
					
                    //$wiki_content .= preg_replace('|href="(/wiki.*?)"|i','href="'.$wiki_url_root.'$1" target="_blank"',$wiki_content);
                     
                 }
                 $wiki_content.='</div>';
         }
         $wiki_content.='</div>';

  
          //if($shortcode_ran_before==false){}
        // var_dump($shortcode_ran_before);die('testing');
        return $wiki_content;
       
    }

	add_shortcode( 'embedwiki', 'wikiex_shortcode_custom' );
    ?>