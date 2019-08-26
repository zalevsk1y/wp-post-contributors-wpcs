<?php

use Spatie\Snapshots\MatchesSnapshots;

class Contributors_Plugin_Template_Render_Test extends \WP_UnitTestCase{
    use MatchesSnapshots;
    public function test_render(){
        $path=__DIR__.'/mock/test-render-mock.php';
        $template=new Contributors_Plugin_Template_Render($path);
        $args=array(
            'test1'=>'test1',
            'test2'=>'test2',
            'test3'=>'test3',
            'test4'=>'test4'
        );
        $this->assertMatchesSnapshot($template->render($args));
    }
}