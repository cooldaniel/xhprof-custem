<?php

//开启xhprof
xhprof_enable(XHPROF_FLAGS_MEMORY | XHPROF_FLAGS_CPU);

//在程序结束后收集数据
register_shutdown_function(function() {

    // 只有允许记录的站点才会记录
    // 以站点目录的方式指定
    if (empty($GLOBALS['xhprof_site_list'])) {
        return;
    }

    $allow_log = false;
    foreach ($GLOBALS['xhprof_site_list'] as $item) {
        if (!empty($_SERVER['DOCUMENT_ROOT'])) {
            if (strpos($_SERVER['DOCUMENT_ROOT'], $item)) {
                $allow_log = true;
                break;
            }
        } else {
            if (strpos($_SERVER['PWD'], $item)) {
                $allow_log = true;
            }
        }
    }

    if (!$allow_log) {
        return;
    }

    $xhprof_data = xhprof_disable();

//    \D::logc(array_sum(array_column($xhprof_data, 'ct')), $xhprof_data);
//    \D::log($xhprof_data["main()"]);
//    \D::log($xhprof_data["main()"]['wt']);
//    if ($xhprof_data["main()"]['wt'] < 2*1000*1000) {
//        return;
//    }

//    if (!$xhprof_data["main()"]['mu'] && !$xhprof_data["main()"]['pmu']) {
//        return;
//    }

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

        $num = $xhprof_data["main()"]['wt'];
        $num = $num / 1000;
        $num = $num / 1000;
        $run_id = substr($url, 0, 150) . '-' .  uniqid() . '-----' . $num . '-----';
        
        //file_put_contents('/var/xhprof/dd.txt', $run_id."\n", FILE_APPEND);
    }else{
        $run_id = null;
    }

    $xhprof_project_name = isset($_SERVER['XHPROF_PROJECT_NAME']) ? $_SERVER['XHPROF_PROJECT_NAME'] : 'xhprof_test';

	$run_id = $xhprof_runs->save_run($xhprof_data, $xhprof_project_name, $run_id);
	//var_dump($run_id);
	
});


