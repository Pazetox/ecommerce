<?php 
session_start();

require_once("vendor/autoload.php");
use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;


$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
	
	//$sql = new Hcode\DB\Sql();
	//$results = $sql->select("select * from tb_users");
	//echo json_encode($results);
	//echo "OK";
	$page = new Page();
	$page->setTpl("index");

});

$app->get('/admin', function() {
	$page = new PageAdmin();
	$page->setTpl("index");
});

$app->get('/admin/login', function() {
	$dados= ["header"=> false, "footer"=>false];
	$page = new PageAdmin($dados);
	$page->setTpl("login",array());
});

$app->post('/admin/login', function() {

	$data= User::login($_POST["login"], $_POST["password"]);
	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function() {
	 User::logout();
	 header("Location: /admin/login");
	exit;
});

$app->run();

 ?>