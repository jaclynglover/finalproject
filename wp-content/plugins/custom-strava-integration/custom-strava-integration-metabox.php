<?php

	require_once( STRAVA_FOR_WP_PLUGIN_DIR . 'libs/StravaApi.php');
	
	add_action('load-post.php', 'strava_for_wordpress_meta_box_setup');
	add_action('load-post-new.php', 'strava_for_wordpress_meta_box_setup');	
	
	add_action('wp_ajax_next', 'strava_next');
	add_action('wp_ajax_prev', 'strava_prev');

	function strava_for_wordpress_meta_box_setup() {
		add_action( 'add_meta_boxes', 'strava_for_wordpress_meta_box');
	}
	
	function strava_for_wordpress_meta_box() {
		add_meta_box(
		    'strava-for-wp-class',
		    'Strava for Wordpress',
		    'strava_for_wordpress_meta_box_display',
		    'post',
		    'side',
		    'high'
	    );
	}
	
	function strava_for_wordpress_meta_box_display($object, $box) {
		?>
		
		<style type="text/css">
			
			.modal {
			    position:   absolute;
			    z-index:    1000;
			    top:        0;
			    left:       0;
			    height:     100%;
			    width:      100%;
			    background: rgba( 255, 255, 255, .8 ) 
			                url('http://i.stack.imgur.com/FhHRx.gif') 
			                50% 50% 
			                no-repeat;
			                
			}
			
			.search-result {
				margin: 0;
				padding: 0;
				list-style-type: none;
			}
			
			.prev-nav {
				float: left;
			}
			
			.next-nav {
				float: right;
			}	
			
			.nav, .help {
				border-top: 1px solid #eee;
			    height: 29px;
			    margin-top: 10px;
			    padding-top: 10px;
			    width: 100%;
			}	
			
			.bold {
				text-weight: bold;
			}	
		</style>
		<div id="strava-loading"> </div>
		<div id="strava-content">
			<?php print_result(1); ?>
		</div>
		<?php	
	}
	
	function print_result ($page) {
		$options = get_option( 'strava_settings_connect' );


		$api = new StravaApi();
		$api->setAccessToken($options['strava_oauth']);
		
		$activities = $api->get('activities', array("page" => $page,  "per_page" => 5));
		
		?>		

		<ul class="search-result">
				
		<?php		
		foreach ($activities as $activity) {
		$date = $activity->start_date_local;	
			
		?>
		
			<li>
				<a id="result-link-<?php echo $activity->id;?>" href="#"> <?php echo $activity->type . " from " . date("d.m.Y H:i:s", strtotime($date)) . " called <i>" . $activity->name . "</i>"; ?>  </a>
				<script type="text/javascript">
				var $j = jQuery.noConflict();

				 $j("a#result-link-<?php echo $activity->id;?>").click(function() {   
						var $html = '[strava id="<?php echo $activity->id;?>"]';
						if (tinymce.activeEditor != null) {
							tinymce.activeEditor.execCommand('mceInsertContent', false, $html);	
						} else {
							var caretPos = document.getElementById("content").selectionStart;
						    var textAreaTxt = jQuery("#content").val();

						    jQuery("#content").val(textAreaTxt.substring(0, caretPos) + $html + textAreaTxt.substring(caretPos) );
						}
			    	});		
			</script>

			</li>	
		<?php	
		}
		?>
		
		</ul>
	
		<div class="nav">
		<?php
		if ($page != 1) {
		?>
		

		<a href="#" class="prev-nav preview button"> Previous </a> &nbsp;
		<script type="text/javascript">
				var $j = jQuery.noConflict();

				 $j("a.prev-nav").click(function() {
					 $j("#strava-loading").addClass("modal");
					 $j.post(ajaxurl, { action: "prev", page: "<?php echo $page; ?>" }, function(data) {
						 $j("#strava-loading").removeClass("modal");
						 $j("#strava-content").html(data.substr(0, data.length-1));
					 });
				 });
		</script>		 
		
		<?php
		} if (sizeof($activities) == 5) {			
		?>
		
		<a href="#" class="next-nav preview button"> Next </a>
		<script type="text/javascript">
				var $j = jQuery.noConflict();

				 $j("a.next-nav").click(function() {
				 	 $j("#strava-loading").addClass("modal")
					 $j.post(ajaxurl, { action: "next", page: "<?php echo $page; ?>" }, function(data) {
						 $j("#strava-loading").removeClass("modal");
						 $j("#strava-content").html(data.substr(0, data.length-1));
					 });
				 });
		</script>		 
		
		<?php
		}
		?> 
		</div>
		<?php
	}
	
	function strava_next() {
	    print_result($_POST['page']+1);
	}

	function strava_prev() {
	    print_result($_POST['page']-1);
	}	
?>