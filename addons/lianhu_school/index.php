<?php 
// 独立入口
//问题比较多，暂时从微擎入口
define('IN_SYS', true);
define('ROOT_PATH',$_SERVER['DOCUMENT_ROOT']);
require '../../framework/bootstrap.inc.php';

require IA_ROOT.'/web/common/bootstrap.sys.inc.php';
load()->web('common');
load()->web('template');
