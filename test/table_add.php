<?
header('Content-Type: text/json; charset=utf-8;');

require 'functions.php';
require 'settings.php';

$file_path = json_file_path();
$data = file_get_contents($file_path);
$data = json_decode($data);
$ids = unique_multidim_array($data->LPU,'id');
while (true) {
    $new_id = uniqid();
    if (array_search($new_id,$ids)===false){
        break;
    }
}
$new_element = array(
    "id" => $new_id,
    "hid" => '',
    "full_name" => "",
    "address" => "",
    "phone" => ""
);
$hid = '';
if ($_POST && $_POST['id']){
    $hid = $_POST['id'];
    $new_element['hid'] = $_POST['id'];
    $changed_arr = array();
    foreach ($data->LPU as $element){
        $changed_arr[]=$element;
        if ($element->id == $_POST['id']){
            $changed_arr[] = $new_element;
        }
    }
    $data = $changed_arr;
} else {
    $changed_arr = $data->LPU;
    $changed_arr[] = $new_element;
}
//var_dump($changed_arr);
$data = array(
    'LPU' => $changed_arr
);
file_put_contents($file_path, json_encode($data));
$result = array(
    'complete' => true,
    'text' => 'Выполнено',
    'id' => $new_id,
    'hid' => $hid
);
echo json_encode($result);

?>