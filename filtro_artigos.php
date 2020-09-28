<form role="search" method="get" class="search-form" action="https://unbox.dreamhosters.com/" id="search-form-artigos">			
    <label>   
        <div class="elementor-control-content">
            <div class="elementor-control-field"> 
                <div class="elementor-control-input-wrapper elementor-control-unit-5">  
                    <input type="submit-search" class="search-field" placeholder="Artigo 1" value="" name="s" />
                </div>
            </div>
        </div>
    </label>  
    </br>    
    <label>    
        <div class="elementor-control-content">
            <div class="elementor-control-field">
                <label for="elementor-control-default-c764" class="elementor-control-title"></label>
                <div class="elementor-control-input-wrapper elementor-control-unit-5">    
                <select id="elementor-control-default-c764" data-setting="posts_select_2">
                    <option value="And">E</option>
                    <option value="Or">OU</option>
                </select>
                </div>
            </div>
        </div>
    </label>
    </br>
    <label> 
        <div class="elementor-control-content">
            <div class="elementor-control-field"> 
                <div class="elementor-control-input-wrapper elementor-control-unit-5"> 
                    <input type="submit-search" class="search-field" placeholder="Artigo 2" value="" name="s1">
                </div>
            </div>
        </div>
    </label>
    </br>
    <button type="submit" id="searchsubmit" value="" class="search-field" >Buscar</button>
</form>	




<!-- *** Abaixo parte do general-template.php do wordpress que fica na pasta wp-include *** -->

<?php
function intercepta_busca( $query ) {
    if( is_admin() ) {
        return;
    }
    if( $query->is_main_query() && $query->is_search() ) {
        $query->set( 'post_type', array('post') );
        $query->set( 'meta_query', array(
            'relation' => 'OR' 
			),
			array(
                'key' => 'OU',
				'value' => $query->query_vars['s'],
				'compare' => '='
            ),
            array(
                'key' => 'E',
                'value' => $query->query_vars['s'],
				'compare' => '='
			),
        );
    }

}
add_action( 'pre_get_posts', 'intercepta_busca' ); //gancho para o filtro E/OU


function get_search_form( $args = array() ) {
	/**
	 * Fires before the search form is retrieved, at the start of get_search_form().
	 *
	 * @since 2.7.0 as 'get_search_form' action.
	 * @since 3.6.0
	 * @since 5.5.0 The `$args` parameter was added.
	 *
	 * @link https://core.trac.wordpress.org/ticket/19321
	 *
	 * @param array $args The array of arguments for building the search form.
	 */
	do_action( 'pre_get_search_form', $args );

	$echo = true;

	if ( ! is_array( $args ) ) {
		/*
		 * Back compat: to ensure previous uses of get_search_form() continue to
		 * function as expected, we handle a value for the boolean $echo param removed
		 * in 5.2.0. Then we deal with the $args array and cast its defaults.
		 */
		$echo = (bool) $args;

		// Set an empty array and allow default arguments to take over.
		$args = array();
	}

	// Defaults are to echo and to output no custom label on the form.
	$defaults = array(
		'echo'       => $echo,
		'aria_label' => '',
	);

	$args = wp_parse_args( $args, $defaults );

	/**
	 * Filters the array of arguments used when generating the search form.
	 *
	 * @since 5.2.0
	 *
	 * @param array $args The array of arguments for building the search form.
	 */
	$args = apply_filters( 'search_form_args', $args );

	$format = current_theme_supports( 'html5', 'search-form' ) ? 'html5' : 'xhtml';

	/**
	 * Filters the HTML format of the search form.
	 *
	 * @since 3.6.0
	 * @since 5.5.0 The `$args` parameter was added.
	 *
	 * @param string $format The type of markup to use in the search form.
	 *                       Accepts 'html5', 'xhtml'.
	 * @param array  $args   The array of arguments for building the search form.
	 */
	$format = apply_filters( 'search_form_format', $format, $args );

	$search_form_template = locate_template( 'searchform.php' );

	if ( '' !== $search_form_template ) {
		ob_start();
		require $search_form_template;
		$form = ob_get_clean();
	} else {
		// Build a string containing an aria-label to use for the search form.
		if ( isset( $args['aria_label'] ) && $args['aria_label'] ) {
			$aria_label = 'aria-label="' . esc_attr( $args['aria_label'] ) . '" ';
		} else {
			/*
			 * If there's no custom aria-label, we can set a default here. At the
			 * moment it's empty as there's uncertainty about what the default should be.
			 */
			$aria_label = '';
		}
//--------- Area de modificação do form do FILTRO_ARTIGOS --------
		if ( 'html5' === $format ) {
			$form = '<form role="search" ' . $aria_label . 'method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
				<label>
					<span class="screen-reader-text">' . _x( 'Search for:', 'label' ) . '</span>
					<input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" />
				</label>
				<input type="submit" class="search-submit" value="' . esc_attr_x( 'Search', 'submit button' ) . '" />
			</form>';
		} else {
			$form = '<form role="search" ' . $aria_label . 'method="get" id="searchform" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
				<div>
					<label class="screen-reader-text" for="s">' . _x( 'Search for:', 'label' ) . '</label>
					<input type="text" value="' . get_search_query() . '" name="s" id="s" />
					<input type="submit" id="searchsubmit" value="' . esc_attr_x( 'Search', 'submit button' ) . '" />
				</div>
			</form>';
		}	
		if ( 'html5' === $format ) {
			$form = '<form role="search" ' . $aria_label . 'method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
				<label>
					<span class="screen-reader-text">' . _x( 'Search for:', 'label' ) . '</span>
					<input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" value="' . get_search_query() . '" name="s1" />
				</label>
				<input type="submit" class="search-submit" value="' . esc_attr_x( 'Search', 'submit button' ) . '" />
			</form>';
		} else {
			$form = '<form role="search" ' . $aria_label . 'method="get" id="searchform" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
				<div>
					<label class="screen-reader-text" for="s1">' . _x( 'Search for:', 'label' ) . '</label>
					<input type="text" value="' . get_search_query() . '" name="s1" id="s1" />
					<input type="submit" id="searchsubmit" value="' . esc_attr_x( 'Search', 'submit button' ) . '" />
				</div>
			</form>';
		}
		
    }
//--------- Fim da area de modificação do form do FILTRO_ARTIGOS --------    