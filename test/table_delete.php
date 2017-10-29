<?
header('Content-Type: text/json; charset=utf-8;');
require 'settings.php';
if ($_POST && $_POST['id']){
    $file_path = json_file_path();
    $data = file_get_contents($file_path);
    $data = json_decode($data);
    $changed_arr = array();
    foreach ($data->LPU as $element){
        if ($element->id != $_POST['id'] && $element->hid != $_POST['id']){
            $changed_arr[]=$element;
        }
    }
//    var_dump($changed_arr);
    $data = array(
        'LPU' => $changed_arr
    );
    file_put_contents($file_path, json_encode($data));
    $result = array(
        'complete' => true,
        'text' => 'Выполнено'
    );
    echo json_encode($result);
}
?>