<?
header('Content-Type: text/json; charset=utf-8;');
require 'settings.php';
if ($_POST && $_POST['data']){
    $data = array(
        'LPU' => $_POST['data']
    );
    file_put_contents(json_file_path(), json_encode($data));

    $result = array(
        'complete' => true,
        'text' => 'Выполнено'
    );
    echo json_encode($result);
}
?>