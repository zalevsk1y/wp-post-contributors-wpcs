<?php

use Spatie\Snapshots\MatchesSnapshots;

class Contributors_Plugin_Metabox_Controller_Test extends \WP_UnitTestCase
{

    use MatchesSnapshots;
    public $users = [];
    public $controller;
    public $post_id;
    public $post;
    public $contributors = [1, 6];
    public function setUp()
    {
        parent::setUp();
        $roles = [
            'administrator',
            'author',
            'contributor',
            'subscriber',
        ];
        foreach ($roles as $role) {
            $this->users[] = ['id' => $this->factory->user->create(['role' => $role,'nickname'=>$role]), 'role' => $role];
        }
        wp_set_current_user($this->users[0]['id']);
        $admin_template = __DIR__ . '/mock/contributors-plugin-admin-template-mock.php';
        $post_template = __DIR__ . '/../templates/contributors-plugin-post-template.php';
        $this->controller = new Contributors_Plugin_Metabox_Controller(new Contributors_Plugin_Template_Render($admin_template), new Contributors_Plugin_Template_Render($post_template));
        $this->post_id = $this->factory->post->create(['post_author' => $this->users[1]['id']]);
        $nonce = wp_create_nonce(CONTRIBUTORS_PLUGIN_NONCE_ACTION);
        $_POST[CONTRIBUTORS_PLUGIN_NONCE] = $nonce;
        $_POST[CONTRIBUTORS_PLUGIN_FIELD] = $this->contributors;
        
        do_action('save_post', $this->post_id);
    }
  
    public function test_save_meta_data()
    {
        $meta = get_post_meta($this->post_id, CONTRIBUTORS_PLUGIN_META, true);
        $this->assertEquals(implode(',', $this->contributors), $meta);
    }
    public function test_permission_check()
    {
        wp_set_current_user($this->users[3]['id']);
        $response=$this->controller->save_meta_data($this->post_id);
        $this->assertEquals($response,__( 'Nonce is not verified', CONTRIBUTORS_PLUGIN_SLUG ));
    }
    public function test_render_post_contributors_box()
    {
        ob_start();
        $this->controller->render_post_contributors_box(get_post($this->post_id));
        $metabox = ob_get_contents();
        ob_end_clean();
        $this->assertMatchesSnapshot($metabox);
    }
    public function test_render_post()
    {   
        $post = get_post($this->post_id);
        setup_postdata($GLOBALS['post']=$post);
        $content = $this->controller->render_post('');
        $this->assertMatchesSnapshot($content);
    }
    public function testAddContributorBox(){
        do_action('add_meta_boxes');
        ob_start();
        do_meta_boxes('post','side',get_post($this->post_id));
        $metabox = ob_get_contents();
        ob_end_clean();
        $this->assertMatchesSnapshot($metabox);
    }

}
