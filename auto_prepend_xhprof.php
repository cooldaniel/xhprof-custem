<?php

//开启xhprof
xhprof_enable(XHPROF_FLAGS_MEMORY | XHPROF_FLAGS_CPU);

//在程序结束后收集数据
register_shutdown_function(function() {

    $xhprof_data = xhprof_disable();
	
	require_once __DIR__.'/../xhprof/xhprof_lib/utils/xhprof_lib.php';
    require_once __DIR__.'/../xhprof/xhprof_lib/utils/xhprof_runs.php';

	$xhprof_runs = new \XHProfRuns_Default();
        
    if (isset($_SERVER['REQUEST_URI'])) {
        $url = $_SERVER['REQUEST_URI'];
        
        $url = urldecode($url);
        $url = str_replace('&', '|', $url);
        $url = str_replace('[', '(', $url);
        $url = str_replace(']', ')', $url);
        $url = str_replace('/', '|', $url);
        $url = str_replace('.', '_', $url);

        $run_id = substr($url, 0, 150) . '-' .  uniqid();
        
        //file_put_contents('/var/xhprof/dd.txt', $run_id."\n", FILE_APPEND);
    }else{
        $run_id = null;
    }

    $xhprof_project_name = isset($_SERVER['XHPROF_PROJECT_NAME']) ? $_SERVER['XHPROF_PROJECT_NAME'] : 'xhprof_test';

	$run_id = $xhprof_runs->save_run($xhprof_data, $xhprof_project_name, $run_id);
	//var_dump($run_id);
	
});


