<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Indexnow extends SQ_Classes_FrontController
{

    /**
     * Restrict to one request every X seconds to a given URL.
     */
    const INDEX_TIMELAPS = 5;

    /** @var array of submitted posts */
    public $processed = array();

    public function __construct() {
        parent::__construct();

        if(!SQ_Classes_Helpers_Tools::getOption('sq_auto_indexnow')){
            return;
        }

        //Auto-Indexing
        $post_types = (array)SQ_Classes_Helpers_Tools::getOption('indexnow_post_type');
        if(!empty($post_types)) {
            foreach ($post_types as $post_type) {
                add_filter("save_post_{$post_type}", array($this, 'savePost'), 10, 2);
                add_filter("bulk_actions-edit-{$post_type}", array($this, 'bulkOption'), 11, 1);
                add_filter("handle_bulk_actions-edit-{$post_type}", array($this, 'bulkActions'), 10, 3);
            }
        }

        add_filter( 'post_row_actions', array($this, 'postRowOption'), 10, 2 );
        add_filter( 'page_row_actions', array($this, 'postRowOption'), 10, 2 );
        add_filter( 'admin_init', array($this, 'postRowAction'));
    }

    function init()
    {
        $tab = preg_replace("/[^a-zA-Z0-9]/", "", SQ_Classes_Helpers_Tools::getValue('tab', 'submit'));

        if (method_exists($this, $tab)) {
            call_user_func(array($this, $tab));
        }

        $this->show_view('Indexnow/' . esc_attr(ucfirst($tab)));

    }

    /**
     * Called when action is triggered
     *
     * @return void
     */
    public function action()
    {
        parent::action();

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {

            ///////////////////////////////////////////INDEX NOW
            case 'sq_seosettings_indexnow':

                if (!SQ_Classes_Helpers_Tools::userCan('sq_manage_settings')) {
                    return;
                }

                //reset the post types
                SQ_Classes_Helpers_Tools::saveOptions('indexnow_post_type', array());
                SQ_Classes_Helpers_Tools::saveOptions('indexnow_endpoints', array());

                //Save the settings
	            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }


                //show the saved message
                if (!SQ_Classes_Error::isError()) {
                    SQ_Classes_Error::setMessage(esc_html__("Saved", 'squirrly-seo'));
                }

                break;
            case 'sq_seosettings_indexnow_submit':

                if ( !SQ_Classes_Helpers_Tools::userCan('sq_manage_snippet') ) {
                    return;
                }

				//The calls are with POST and GET
	            if(isset($_POST['urls'])){
		            $urls = $_POST['urls'];
	            }elseif(isset($_GET['urls'])){
		            $urls = $_GET['urls'];
	            }

                if ( empty( $urls ) ) {
                    SQ_Classes_Error::setError(esc_html__("No URLs found. Please add URLs to index.", 'squirrly-seo'));
                }

				if(strpos($urls, "\n") !== false){
					$urls = array_map( 'trim', explode( "\n", $urls ));
				}elseif(strpos($urls, " ") !== false){
					$urls = array_map( 'trim', explode( " ", $urls ));
				}
	            $urls = array_map( 'esc_url_raw', (array)$urls);
	            $urls = array_map( 'urldecode', $urls);
	            $urls = array_unique( $urls );
                $urls = array_values( $urls );

                if ( ! $urls ) {
                    SQ_Classes_Error::setError(esc_html__("Invalid URLs provided. Please add valid URLs.", 'squirrly-seo'));
                }

                $result = SQ_Classes_ObjController::getClass('SQ_Models_Indexnow')->submitUrl( $urls , true);
                if ( ! $result ) {
                    SQ_Classes_Error::setError(esc_html__("Failed to submit the URLs. Please try again.", 'squirrly-seo'));
                }

                $urls_number = count( $urls );
                if (!SQ_Classes_Error::isError()) {
                    SQ_Classes_Error::setMessage(sprintf(
                        _n(
                            'Successfully submitted %s URL.',
                            'Successfully submitted %s URLs.',
                            $urls_number,
                            'squirrly-seo'
                        ),
                        $urls_number)
                    );
                }


                break;
            case 'sq_seosettings_indexnow_clear':

                if ( !SQ_Classes_Helpers_Tools::userCan('sq_manage_settings') ) {
                    return;
                }

                $this->model->deleteLog();

                //show the saved message
                if (!SQ_Classes_Error::isError()) {
                    SQ_Classes_Error::setMessage(esc_html__("Log cleared", 'squirrly-seo'));
                }

                break;
            case 'sq_seosettings_indexnow_reset':

                if ( !SQ_Classes_Helpers_Tools::userCan('sq_manage_settings') ) {
                    return;
                }

                SQ_Classes_ObjController::getClass('SQ_Models_Indexnow')->resetIndexnowKey();

                //show the saved message
                if (!SQ_Classes_Error::isError()) {
                    SQ_Classes_Error::setMessage(esc_html__("Regenerated", 'squirrly-seo'));
                }

                break;
        }

    }


    public function bulkOption($actions){
        $actions['sq_indexnow'] = esc_html__( 'Submit to Auto-Indexing', 'squirrly-seo' );
        return $actions;
    }

    public function bulkActions($redirect, $doaction, $object_ids){
        if ( $doaction !== 'sq_indexnow' || empty( $object_ids ) ) {
            return $redirect;
        }

        if ( !SQ_Classes_Helpers_Tools::userCan('sq_manage_snippet') ) {
            return $redirect;
        }

        $urls = [];
        foreach ( $object_ids as $object_id ) {
            $urls[] = get_permalink( $object_id );
        }

        $this->submitUrl( $urls, true );

        return $redirect;
    }

    /**
     * Action links for the post listing screens.
     *
     * @param array  $actions Action links.
     * @param object $post    Current post object.
     * @return array
     */
    public function postRowOption( $actions, $post ) {
        if ( !SQ_Classes_Helpers_Tools::userCan('sq_manage_snippet') ) {
            return $actions;
        }

        if ( $post->post_status !== 'publish' ) {
            return $actions;
        }

        $post_types = (array)SQ_Classes_Helpers_Tools::getOption('indexnow_post_type');
        if ( !in_array( $post->post_type, $post_types, true ) ) {
            return $actions;
        }

        $link = wp_nonce_url(
            add_query_arg(
                [
                    'action'  => 'sq_indexnow_post',
                    'indexnow_post_id' => $post->ID,
                    'method'  => 'indexnow_submit',
                ]
            ),
            'sq_indexnow_post'
        );

        $actions['indexnow_submit'] = '<a href="' . esc_url( $link ) . '">' . esc_html__( 'Submit to Auto-Indexing', 'squirrly-seo' ) . '</a>';

        return $actions;
    }

    /**
     * Handle post row action link actions.
     *
     * @return void
     */
    public function postRowAction() {
        if ( !SQ_Classes_Helpers_Tools::getValue('action' ) == 'sq_indexnow_post' ) {
            return;
        }

        if ( !$post_id = absint(SQ_Classes_Helpers_Tools::getValue('indexnow_post_id')) ) {
            return;
        }

        if ( !SQ_Classes_Helpers_Tools::userCan('sq_manage_snippet') ) {
            return;
        }

        if ( ! wp_verify_nonce( SQ_Classes_Helpers_Tools::getValue( '_wpnonce' ), 'sq_indexnow_post' ) ) {
            return;
        }

        $this->submitUrl( get_permalink( $post_id ), true );

        wp_redirect( remove_query_arg( array('action', 'indexnow_post_id', 'method', '_wpnonce') ) );
        exit;
    }

    /**
     * When a post from a watched post type is published or updated, submit its URL
     * to the API and add notice about it.
     *
     * @param  int    $post_id Post ID.
     * @param  object $post    Post object.
     *
     * @return void
     */
    public function savePost( $post_id, $post ) {

        if ( in_array( $post_id, $this->processed, true ) ) {
            return;
        }

        if ( ! in_array( $post->post_status, [ 'publish', 'trash' ], true ) ) {
            return;
        }

        if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
            return;
        }

        if (!SQ_Classes_ObjController::getClass('SQ_Models_Post')->isIndexable($post_id)) {
            return;
        }

        if ( !$url = apply_filters( 'sq_publish_url', get_permalink($post), $post ) ) {
            return;
        }

        $this->submitUrl( $url, false );
        $this->processed[] = $post_id;

    }

	/**
	 * Submit an URL to Auto-Indexing
	 * @param string $url
	 * @param bool $manual
	 *
	 * @return false
	 */
    private function submitUrl( $url, $manual ) {

        if ( !$url = apply_filters( 'sq_submit_url', $url, $manual ) ) {
            return false;
        }

        if ( ! $manual ) {
			if(is_array($this->model->getLog())){
				$logs = array_values( array_reverse( $this->model->getLog() ) );
				if ( ! empty( $logs[0] ) && $logs[0]['url'] === $url && time() - $logs[0]['time'] < self::INDEX_TIMELAPS ) {
					return false;
				}
			}
        }

        $submitted = $this->model->submitUrl( $url, $manual );

        if ( ! $manual ) {
            return $submitted;
        }

        $count = is_array( $url ) ? count( $url ) : 1;

        if ( $submitted ) {
            SQ_Classes_Error::saveMessage(sprintf(_n( '%s page submitted to Auto-Indexing.', '%s pages submitted to Auto-Indexing.', $count, 'squirrly-seo' ), $count), 'notice notice-success');
        }else{
            SQ_Classes_Error::saveMessage(esc_html__( 'Error submitting page to Auto-Indexing.','squirrly-seo' ), 'notice notice-error');
        }

        return $submitted;
    }
}
