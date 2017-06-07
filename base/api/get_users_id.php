<?php
  session_start();
  header('Content-Type: application/json');
  require_once('./../../api/utils.php');
  if(!$_SESSION['_admin_userid']){
    Utils::json(0, '没有获取该数据', 'No permissions');
  }

  $admin_userid = $_SESSION['_admin_userid'];

  $userid = $_REQUEST['userid'];
  if(!$userid){
    Utils::json(0, '没有输入用户ID', 'no userid');
  }
  //查询数据库
  $pdo = null;
  try{
    $pdo = DBHelp::getInstance()->connect();
  }catch (PDOException $e){
    Utils::json(0, '数据连接异常', 'db link error');
  }

  //第1步，查询管理员表
  $stmt_admin = $pdo->prepare('select email from admin WHERE userid=:userid');
  $stmt_admin->bindParam(':userid', $admin_userid);

  if(!$stmt_admin->execute()){
    Utils::json(0, '你没有登录，不具备管理员权限', 'db admin query error');
  }
  $stmt_admin = null;

  $sql = <<<EOF
      SELECT userid, email, nickname, job, company, intro, avatar, time, ip, is_close 
      FROM users 
      where userid like :userid;
EOF;

  $userid = '%'.$userid.'%';
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
  $is_ok = $stmt->execute();

  if(!$is_ok){
    $stmt = null;
    Utils::json(0, '查询数据库失败', 'db query error');
  }

  $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
  if(!$rows){
    $stmt = null;
    Utils::json(0, '没有查询到数据', 'db query error');
  }
  $stmt = null;
  Utils::json(1, '查询成功', $rows);

?>