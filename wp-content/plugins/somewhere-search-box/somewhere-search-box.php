<?php
/*
 Plugin Name: Somewhere search box
Plugin URI: http://elearn.jp/wpman/column/somewhere-search-box.html
Description: Search box widget add to the admin post editor.
Author: tmatsuur
Version: 1.2.1
Author URI: http://12net.jp/
*/

/*
 Copyright (C) 2012-2016 tmatsuur (Email: takenori dot matsuura at 12net dot jp)
This program is licensed under the GNU GPL Version 2.
*/

define( 'SOMEWHERE_SEARCH_BOX_DOMAIN', 'somewhere-search-box' );
define( 'SOMEWHERE_SEARCH_BOX_DB_VERSION_NAME', 'somewhere-search-box-db-version' );
define( 'SOMEWHERE_SEARCH_BOX_DB_VERSION', '1.2.1' );

class somewhere_search_box {
	var $post_type;
	/**
	 * Plugin initialize.
	 */
	public function __construct() {
		global $pagenow;
		register_activation_hook( __FILE__ , array( &$this , 'init' ) );
		if ( in_array( $pagenow, array( 'index.php', 'post.php', 'post-new.php' ) ) ) {
			add_action( 'admin_init', array( &$this, 'setup' ) );
			add_action( 'admin_footer', array( &$this, 'footer' ) );
			if ( in_array( $pagenow, array( 'post-new.php' ) ) ) {
				add_filter( 'default_content', array( &$this, 'default_content' ), 10, 2 );
			}
		} else if ( in_array( $pagenow, array( 'edit.php' ) ) ) {
			add_filter( 'post_row_actions', array( &$this, 'post_row_actions' ), 10, 2 );
			add_filter( 'page_row_actions', array( &$this, 'page_row_actions' ), 10, 2 );
		}
		if ( in_array( $pagenow, array( 'edit.php', 'post.php' ) ) ) {
			load_plugin_textdomain( SOMEWHERE_SEARCH_BOX_DOMAIN, false, plugin_basename( dirname( __FILE__ ) ).'/languages' );
		}
	}
	/**
	 * Plugin activation.
	 */
	public function init() {
		if ( get_option( SOMEWHERE_SEARCH_BOX_DB_VERSION_NAME ) != SOMEWHERE_SEARCH_BOX_DB_VERSION ) {
			update_option( SOMEWHERE_SEARCH_BOX_DB_VERSION_NAME, SOMEWHERE_SEARCH_BOX_DB_VERSION );
		}
	}
	/**
	 * Post search box.
	 */
	public function setup() {
		global $pagenow;
		$_title = __( 'Search Posts' );
		$this->post_type = '';
		if ( in_array( $pagenow, array( 'index.php' ) ) )
			add_meta_box( 'meta_box_somewhere_search_box', $_title, array( &$this, 'meta_box' ), 'dashboard', 'side', 'high' );
		else {
			if ( isset( $_GET['post_type'] ) )
				$this->post_type = $_GET['post_type'];
			else if ( isset( $_GET['post'] ) ) {
				$_post = get_post( $_GET['post'] );
				if ( isset( $_post->post_type ) )
					$this->post_type = $_post->post_type;
			}
			if ( $this->post_type != '' )
				$_title = get_post_type_object( $this->post_type )->labels->search_items;
			add_meta_box( 'meta_box_somewhere_search_box', $_title, array( &$this, 'meta_box' ), $this->post_type != ''? $this->post_type: 'post', 'side', 'high' );
		}
	}
	/**
	 * Post search box fields.
	 */
	public function meta_box() {
?>
<input type="text" id="somewhere-search-input" name="s" value="" style="width: 100%;" />
<select name="post_type" id="somewhere-search-post-type">
<?php foreach ( get_post_types( array( 'show_ui'=>true ), 'objects' ) as $post_type ) { ?>
<option value="<?php _e( $post_type->name ); ?>" <?php selected( $this->post_type == $post_type->name ); ?>><?php _e( $post_type->labels->name ); ?></option>
<?php } ?>
</select>
<a class="button" href="javascript:post_searchbox( '<?php echo admin_url( 'edit.php' ); ?>' );"><?php _e( 'Search' ); ?></a>
<?php
	}
	/**
	 * Add admin footer scripts.
	 */
	public function footer() {
		global $post, $pagenow;
		$edit_post_link = '';
		if ( isset( $post->post_status ) && $post->post_status != 'auto-draft' ) {
			if ( $post->post_status == 'publish' || $post->post_status == 'future' || $post->post_status == 'private' ) {
				$edit_post_link .= '&nbsp;'.$this->_get_replicate_action_link( $post, 'button' );
			}
			$prev_post = get_previous_post();
			if ( isset( $prev_post->ID ) ) {
				$title = trim( $prev_post->post_title ) != ''? $prev_post->post_title: 'ID:'.$prev_post->ID;
				$edit_post_link .= '&nbsp;<a href="?post='.intval( $prev_post->ID ).'&action=edit" title="'.esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;' ), $title ) ) .'" class="button">'.__( '&laquo; Previous' ).'</a>';
			}
			$next_post = get_next_post();
			if ( isset( $next_post->ID ) ) {
				$title = trim( $next_post->post_title ) != ''? $next_post->post_title: 'ID:'.$next_post->ID;
				$edit_post_link .= '&nbsp;<a href="?post='.intval( $next_post->ID ).'&action=edit" title="'.esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;' ), $title ) ).'" class="button">'.__( 'Next &raquo;' ).'</a>';
			}
		}
?>
<script type="text/javascript">
jQuery(document).ready( function () {
<?php if ( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) && $edit_post_link != '' ) { ?>
	jQuery( '.add-new-h2' ).each( function () {
		jQuery(this).removeClass( 'add-new-h2' ).addClass( 'button' ).parent().addClass( 'wp-core-ui' );
		jQuery(this).after( '<?php echo $edit_post_link; ?>' );
	} );
	jQuery( 'h1 a.page-title-action' ).each( function () {
		jQuery(this).after( '<?php echo $edit_post_link; ?>' );
	} );
<?php } ?>
	jQuery( '#somewhere-search-input' ).keypress( function ( e ) {
		if ( e.which == 13 ) { post_searchbox( '<?php echo admin_url( 'edit.php' ); ?>' ); return false; }
	} );
} );
function post_searchbox( url ) {
	var post_search_input = jQuery.trim( jQuery( '#somewhere-search-input' ).val() );
	if ( post_search_input != '' ) {
		url += '?s='+encodeURI( post_search_input );
		post_type_selected = jQuery.trim( jQuery( '#somewhere-search-post-type' ).val() );
		if ( post_type_selected != 'post' )
			url += '&post_type='+encodeURI( post_type_selected );
		location.href = url;
	}
}
</script>
<?php
	}
	/**
	 * Replicate the post content, terms and meta values.
	 *
	 * @since 1.2.0
	 *
	 * @param string  $post_content Default post content.
	 * @param WP_Post $post         Post object.
	 * @return string Replicate post content
	 */
	public function default_content( $post_content, $post ) {
		if ( !empty( $_GET[ 'replicate' ] ) ) {
			$replicate_post = get_post( absint( $_GET[ 'replicate' ] ) );
			if ( $replicate_post instanceof WP_Post ) {
				$post_content = $replicate_post->post_content;
				if ( $post instanceof WP_Post ) {
					// Copy taxonomies.
					$taxonomies = get_object_taxonomies( $replicate_post->post_type );
					if ( is_array( $taxonomies ) && count( $taxonomies ) > 0 ) {
						foreach ( $taxonomies as $taxonomy ) {
							if ( $taxonomy == 'post_format' ) {
								if ( current_theme_supports( 'post-formats' ) ) {
									set_post_format( $post, get_post_format( $replicate_post ) );
								}
							} else {
								// Copy terms.
								$terms = wp_get_object_terms( $replicate_post->ID, $taxonomy, array( 'fields'  => 'ids' ) );
								if ( is_array( $terms ) ) foreach ( $terms as $term ) {
									wp_set_object_terms( $post->ID, $terms, $taxonomy );
								}
							}
						}
					}
					// Copy meta values.
					$postmetas = get_post_meta( $replicate_post->ID );
					if ( is_array( $postmetas ) ) foreach ( $postmetas as $_key=>$_values ) {
						if ( !is_protected_meta( $_key ) ) {
							foreach ( $_values as $_value )
								add_post_meta( $post->ID, $_key, $_value );
						}
					}
				}
			}
		}
		return $post_content;
	}
	/**
	 * Insert 'Replicate' to the array of row action links on the Posts list table.
	 *
	 * @since 1.2.0
	 *
	 * @param array $actions An array of row action links.
	 * @param WP_Post $post The post object.
	 * @return array An array of row action links
	 */
	public function post_row_actions( $actions, $post ) {
		$can_edit = current_user_can( 'edit_post', $post->ID );
		if ( $can_edit && 'trash' != $post->post_status ) {
			$actions = $this->_insert_replicate_action( $actions, $this->_get_replicate_action_link( $post ) );
		}
		return $actions;
	}
	/**
	 * Insert 'Replicate' to the array of row action links on the Pages list table.
	 *
	 * @since 1.2.0
	 *
	 * @param array $actions An array of row action links.
	 * @param WP_Post $post The post object.
	 * @return array An array of row action links
	 */
	public function page_row_actions( $actions, $post ) {
		$can_edit = current_user_can( 'edit_pages', $post->ID );
		if ( $can_edit && 'trash' != $post->post_status ) {
			$actions = $this->_insert_replicate_action( $actions, $this->_get_replicate_action_link( $post ) );
		}
		return $actions;
	}
	/**
	 * Retrieve  'Replicate' action links.
	 *
	 * @since 1.2.0
	 *
	 * @param WP_Post $post The post object.
	 * @return string The link of replicate action.
	 */
	private function _get_replicate_action_link( $post, $class='' ) {
		$param_type = ( $post->post_type != 'post' )? 'post_type='.esc_attr( $post->post_type ).'&': '';
		$attr_class = ( $class == '' )? '': 'class="'.esc_attr( $class ).'"';
		return  '<a href="post-new.php?'.$param_type.'replicate='.intval( $post->ID ).'" title="' . esc_attr__( 'Replicate this item', SOMEWHERE_SEARCH_BOX_DOMAIN ) . '" '. $attr_class .'>'.__( 'Replicate', SOMEWHERE_SEARCH_BOX_DOMAIN ).'</a>';
	}
	/**
	 * Insert 'Replicate' to the array of row action links.
	 *
	 * @since 1.2.0
	 *
	 * @param array $actions An array of row action links.
	 * @param string $action_replicate The link of replicate action.
	 * @return array An array of row action links
	 */
	private function _insert_replicate_action( $actions, $action_replicate ) {
		$_actions = array();
		foreach ( $actions as $name=>$link ) {
			$_actions[$name] = $link;
			if ( $name == 'edit' ) $_actions['replicate'] = $action_replicate;
		}
		if ( !isset( $_actions['replicate'] ) ) $_actions['replicate'] = $action_replicate;
		return $_actions;
	}
}
$plugin_somewhere_search_box = new somewhere_search_box();
?>