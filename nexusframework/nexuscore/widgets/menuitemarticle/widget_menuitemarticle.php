<?php

nxs_requirewidget("menuitemgeneric");

function nxs_widgets_menuitemarticle_geticonid()
{
	return "nxs-icon-text";
}

function nxs_widgets_menuitemarticle_gettitle()
{
	return nxs_l18n__("Article reference (menu item)[nxs:widgettitle]", "nxs_td");
}

/* WIDGET STRUCTURE
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------- */

// Define the properties of this widget
function nxs_widgets_menuitemarticle_home_getoptions($args) 
{
	// CORE WIDGET OPTIONS
	
	$options = array
	(
		"sheettitle" => nxs_widgets_menuitemarticle_gettitle(),
		"sheeticonid" => nxs_widgets_menuitemarticle_geticonid(),
		"footerfiller" => true,
		"fields" => array
		(
			// ICON
            
            array( 
				"id" 				=> "wrapper_title_begin",
				"type" 				=> "wrapperbegin",
				"initial_toggle_state" => "closed",
				"label" 			=> nxs_l18n__("Icon", "nxs_td"),
			),
            
            array(
				"id" 				=> "icon",
				"type" 				=> "icon",
				"label" 			=> nxs_l18n__("Icon", "nxs_td"),
				"unicontentablefield" => false,
			),
			array( 
				"id" 				=> "wrapper_title_end",
				"type" 				=> "wrapperend",
			),

            // TITLE
			
			array( 
				"id" 				=> "wrapper_title_begin",
				"type" 				=> "wrapperbegin",
				"label" 			=> nxs_l18n__("Title", "nxs_td"),
			),
			array
			(
				"id" 				=> "title",
				"type" 				=> "input",
				"label" 			=> nxs_l18n__("Title", "nxs_td"),
				"placeholder" => nxs_l18n__("Title goes here", "nxs_td"),
				"localizablefield"	=> true
			),
			array( 
				"id" 				=> "wrapper_title_end",
				"type" 				=> "wrapperend",
			),
            
            //
			
			array( 
				"id" 				=> "wrapper_link_begin",
				"type" 				=> "wrapperbegin",
				"label" 			=> nxs_l18n__("Link", "nxs_td"),
			),
			
			array(
				"id" 				=> "destination_articleid",
				"type" 				=> "article_link",
				"label" 			=> nxs_l18n__("Article link", "nxs_td"),
				"tooltip" 			=> nxs_l18n__("Link the menu item to an article within your site.", "nxs_td"),
			),	
			array( 
				"id" 				=> "wrapper_link_end",
				"type" 				=> "wrapperend"
			),
			
			// SWITCH TYPE
			array( 
				"id" 				=> "wrapper_switch_begin",
				"type" 				=> "wrapperbegin",
				"initial_toggle_state" => "closed",
				"label" 			=> nxs_l18n__("Switch type", "nxs_td"),
			),
			array(
				"id" 					=> "menuitemcustomtoggle",
				"type" 				=> "custom",
				"customcontenthandler"	=> "nxs_menuitemgeneric_switchtype",
				"label" 			=> nxs_l18n__("Switch type", "nxs_td"),
				"excludeitem" => "menuitemarticle",
			),
			array( 
				"id" 				=> "wrapper_switch_end",
				"type" 				=> "wrapperend",
			),			
		)
	);
	
	return $options;
}

//

// rendert de placeholder zoals deze uiteindelijk door een gebruiker zichtbaar is,
// hierbij worden afhankelijk van de rechten ook knoppen gerenderd waarmee de gebruiker
// het bewerken van de placeholder kan opstarten
function nxs_widgets_menuitemarticle_render_webpart_render_htmlvisualization($args)
{
	
	//
	extract($args);
	
	global $nxs_global_row_render_statebag;
	
	$result = array();
	$result["result"] = "OK";
	
	$mixedattributes = nxs_getwidgetmetadata($postid, $placeholderid);
	
	$mixedattributes = array_merge($mixedattributes, $args);

	// Localize atts
	$mixedattributes = nxs_localization_localize($mixedattributes);
	
	$title = $mixedattributes['title'];
	
    $icon = $mixedattributes['icon'];
	$icon_scale = "0-5";
    $icon_scale_cssclass = nxs_getcssclassesforlookup("nxs-icon-scale-", $icon_scale);
    
	$destination_articleid = $mixedattributes['destination_articleid'];
	$depthindex = $mixedattributes['depthindex'];	// sibling or child

	//
	//
	//
	
	$paddingleft = 30 * ($depthindex - 1);
	
	global $nxs_global_placeholder_render_statebag;
	
	$hovermenuargs = array();
	$hovermenuargs["postid"] = $postid;
	$hovermenuargs["placeholderid"] = $placeholderid;
	$hovermenuargs["placeholdertemplate"] = $placeholdertemplate;
	$hovermenuargs["enable_decoratewidget"] = false;
	$hovermenuargs["enable_deletewidget"] = false;
	$hovermenuargs["enable_deleterow"] = true;
	
	//$hovermenuargs["enable_movewidget"] = "first";
	//$hovermenuargs["enable_editwidget"] = "second";
	
	$hovermenuargs["metadata"] = $mixedattributes;	
	nxs_widgets_setgenericwidgethovermenu_v2($hovermenuargs);
	
	//
	// render actual control / html
	//
	
	nxs_ob_start();

	$nxs_global_placeholder_render_statebag["widgetclass"] = "nxs-menu-item " . "nxs-listitem-depth-" . $depthindex;
	
  if ($depthindex == 1)
  {
  	$positionerclass = "";
  } 
  else if ($depthindex == 2)
  {
  	$positionerclass = "nxs-margin-left30";
  }
  else if ($depthindex == 3)
  {
  	$positionerclass = "nxs-margin-left60";
  }
  else if ($depthindex == 4)
  {
  	$positionerclass = "nxs-margin-left90";
  }
  else if ($depthindex == 5)
  {
  	$positionerclass = "nxs-margin-left120";
  }
  else
  {
  	echo "max depth = 4";
  	$positionerclass = "nxs-margin-left120";
  }
  
  if ($icon != "") {$icon = '<span class="'.$icon.' '.$icon_scale_cssclass.'"></span> ';}
    
  ?>
	<div class="nxs-padding-menu-item nxs-draggable nxs-existing-pageitem nxs-dragtype-placeholder" id='draggableplaceholderid_<?php echo $placeholderid; ?>'>
		<div class="nxs-drag-helper" style='display: none;'>
			<div class='placeholder'>
			</div>
		</div>
		<div class="content2 border <?php echo $positionerclass;?>">
	    <div class="box-content nxs-float-left"><p><?php echo $icon; ?><?php echo $title; ?></p></div>
	    <div class="nxs-clear"></div>
	  </div> <!--END content-->
	</div>
	
	<?php 
	
	$html = nxs_ob_get_contents();
	nxs_ob_end_clean();

	$result["html"] = $html;	
	$result["replacedomid"] = 'nxs-widget-' . $placeholderid;

	return $result;
}

//
// wordt aangeroepen bij het opslaan van data van deze placeholder
//
function nxs_widgets_menuitemarticle_initplaceholderdata($args)
{
	extract($args);

	$args["title"] = "Item";
	$args["depthindex"] = 1;
	$args["destination_target"] = "";
	$args['ph_margin_bottom'] = "0-0";
	
	nxs_mergewidgetmetadata_internal($postid, $placeholderid, $args);

	$result = array();
	$result["result"] = "OK";
	
	return $result;
}

?>