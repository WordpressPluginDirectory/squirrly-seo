<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Patterns extends SQ_Classes_FrontController
{

    /** @var SQ_Models_Domain_Patterns */
    public $patterns;

    public function init()
    {
	    $handles = array();

        if (is_rtl()) {
	        $handles[] = SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('sqbootstrap.rtl');
	        $handles[] = SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rtl');
        } else {
	        $handles[] = SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('sqbootstrap');
        }

	    $handles[] = SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('patterns');

	    wp_print_styles($handles);
	    wp_print_scripts($handles);
    }

    /**
     * Replace the patterns by each tag
     *
     * @param  SQ_Models_Domain_Post $post
     * @return SQ_Models_Domain_Post | false
     */
    public function replacePatterns($post)
    {
        if ($post instanceof SQ_Models_Domain_Post) {

            //set the patterns based on the current post
            $this->patterns = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Patterns', $post->toArray());

            //set the current post for excerpt and description
            $this->patterns->currentpost = $post;

            //Foreach SQ, if it has patterns, replace them
            if ($sq_array = $post->sq->toArray()) {

                //set the keywords from sq and not from post
                $this->patterns->keywords = $post->sq->keywords;

                $post->sq = $this->processPatterns($sq_array, $post->sq);
            }
        }
        return $post;

    }

    /**
     * Get all patterns to process and add them in the object
     *
     * @param  $values
     * @param  $object
     * @return mixed
     */
    public function processPatterns($values, $object)
    {

        //Set the Separator from object automation
        //do not remove it from here
        $this->patterns->sep = $object->sep;

        if (!empty($values)) {
            foreach ($values as $name => $value) {
                if ($name <> '' && !is_array($value) && $value <> '') {

	                if ( strpos( $value, '%%' ) !== false ) { //in case there are still patterns from Yoast
		                $value = preg_replace( '/%%([^\%\s]+)%%/', '{{$1}}', $value );
	                }

	                if ( strpos( $value, '%' ) !== false ) { //in case there are still patterns from Rank Math
		                $value = preg_replace( '/%([^\%\s]+)%/', '{{$1}}', $value );
	                }

                    if(is_string($value) && $value <> '') {
	                    $object->{$name} = preg_replace_callback('/\{\{([^\}\s]+)\}\}/',array($this, 'processPattern'), $value);
                    }

                }
            }
        }

        return $object;
    }

	/**
	 * Replace the found pattern with the value
	 * @param array $match Found patterns
	 * @param array $patterns List of patterns
	 *
	 * @return string
	 */
	public function processPattern($match){
		$value = '';
		$found_pattern = $match[0];

		//get the patterns
		$patterns = array_flip($this->patterns->getPatterns());

		if(isset($patterns[$found_pattern])){

			//Set the key
			$key = $patterns[$found_pattern];

			//return value if the pattern is set for this key
			$value = $this->processPatternKey($key);

		}elseif(strpos($found_pattern,'customfields') !== false){

			//check custom field pattern
			preg_match('/\(([^\)]+)\)/si', $found_pattern, $custom_match);
			if(isset($custom_match[1]) && !empty($custom_match[1]) && $this->patterns->currentpost->ID){
				$fields = explode('|', $custom_match[1]);

				if(!empty($fields) && count($fields) == 2){
					//get the custom field from post meta is set
					if($values = get_post_meta($this->patterns->currentpost->ID, $fields[0], true)){

						if(is_array($values) && !empty($values)){
							if(is_string($values[$fields[1]]) && isset($values[$fields[1]])){
								return wp_strip_all_tags($values[$fields[1]]);
							}
						}elseif($values = json_decode($fields[0], true)){
							if(is_string($values[$fields[1]]) && isset($values[$fields[1]])){
								return wp_strip_all_tags($values[$fields[1]]);
							}
						}

						return false;
					}
				}


			}
		}elseif(strpos($found_pattern,'customfield') !== false){

			//check custom field pattern
			preg_match('/\(([^\)]+)\)/i', $found_pattern, $custom_match);
			if(isset($custom_match[1]) && !empty($custom_match[1]) && $this->patterns->currentpost->ID){
				//get the custom field from post meta is set
				if($value = get_post_meta($this->patterns->currentpost->ID, $custom_match[1], true)){
					return wp_strip_all_tags($value);
				}

			}
		}

		return $value;
	}

	/**
	 * Return the value of the key
	 * @param $key
	 *
	 * @return mixed|null
	 */
	public function processPatternKey($key){

		//if the pattern is set
		if($this->patterns->$key){
			$value = $this->patterns->$key;
		}else{
			$value = apply_filters('sq_process_pattern', false, $key);
		}

		return $value;
	}

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action()
    {
        parent::action();

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_getpatterns':
	            //return json with the results
	            SQ_Classes_Helpers_Tools::setHeader('json');

	            if (!SQ_Classes_Helpers_Tools::userCan('sq_manage_snippet')) {
		            $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", 'squirrly-seo'), 'error');
		            echo wp_json_encode($response);
		            exit();
	            }

	            $all_patterns = json_decode(SQ_ALL_PATTERNS, true);

	            $post_id = (int)SQ_Classes_Helpers_Tools::getValue('post_id', 0);
	            $term_id = (int)SQ_Classes_Helpers_Tools::getValue('term_id', 0);
	            $taxonomy = SQ_Classes_Helpers_Tools::getValue('taxonomy', 'category');
	            $post_type = SQ_Classes_Helpers_Tools::getValue('post_type', 'post');

				/** @var SQ_Models_Snippet $snippet */
                $snippet = SQ_Classes_ObjController::getDomain('SQ_Models_Snippet');
	            if ($post = $snippet->getCurrentSnippet($post_id, $term_id, $taxonomy, $post_type)) {
		            if ($post->ID > 0) {
			            $post_meta_keys = get_post_custom_keys( $post->ID );

						if(is_array($post_meta_keys) && !empty($post_meta_keys)) {

							$post_meta_keys = array_values( array_unique( $post_meta_keys ) );

							foreach ($post_meta_keys as $index => $post_meta_key){
								//fist, unset the $index in post meta array
								unset($post_meta_keys[$index]);

								//ignore postmeta hidden fields
								if(!apply_filters('sq_show_hidden_patterns', false)){
									if(preg_match('/^_/', $post_meta_key) ||
									   preg_match('/^classic-editor/', $post_meta_key) ||
									   preg_match('/^_edit_/', $post_meta_key) ||
									   preg_match('/^_wp_/', $post_meta_key)){
										continue;
									}
								}

								//Check if multiple values
								if($values = get_post_meta($post->ID, $post_meta_key, true)){

									if(is_array($values)){
										if(!empty($values)){

											foreach ($values as $key => $value){
												if(is_string($value) && wp_strip_all_tags($value) <> ''){
													$post_meta_keys[] = "{{customfields($post_meta_key|$key)}}";
												}
											}
										}
									}elseif(is_string($values) && wp_strip_all_tags($values) <> ''){
										$post_meta_keys[] = "{{customfield($post_meta_key)}}";
									}

								}

							}

							$post_meta_keys = array_filter($post_meta_keys);
							$post_meta_keys = array_fill_keys($post_meta_keys, esc_html__('Custom field data based on the current post ID.', 'squirrly-seo'));

							if(!empty($post_meta_keys)){
								$all_patterns = array_merge($all_patterns, $post_meta_keys);
							}
						}
		            }

		            //set the patterns based on the current post
		            $this->patterns = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Patterns', $post->toArray());

	                foreach ($all_patterns as $pattern => $title) {
		                $value = preg_replace_callback('/\{\{([^\}]+)\}\}/',array($this, 'processPattern'), $pattern);
	                    $all_patterns[$pattern] = array('value' => $value, 'details' => $title);
	                }

	            }


	            if (SQ_Classes_Helpers_Tools::isAjax()) {
	                echo wp_json_encode(array('json' => wp_json_encode($all_patterns)));
	                exit();
	            }
	            break;
        }
    }


}
