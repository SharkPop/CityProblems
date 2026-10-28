<?php
require_once 'db.php';

$req1 = $pdo->query("SELECT * FROM request WHERE decision = 2 ORDER BY id DESC LIMIT 8");
$array1 = $req1->fetchAll();

$req2 = $pdo->query("SELECT * FROM problemCategory ORDER BY id");
$array2 = $req2->fetchAll();

$senData = array();
$catId = 0;
for($i = 0; $i < count($array1); $i++)
{
    if(!empty($array1))
    $catId = 0;
    for($j = 0; $j < count($array2); $j++)
    {
        if($array2[$j]['id'] == $array1[$i]['categoryId'])
        {
            $catId = $j;
        }
    }
    $newArray = array(
        'name' => $array1[$i]['name'],
        'category' => $array2[$catId]['name'],
        'description' => $array1[$i]['description'],
        'photo' => $array1[$i]['photo'],
        'proofPhoto' => $array1[$i]['proofPhoto'],
    );
    array_push($senData, $newArray);
}
// Отправляем только первые 8 элементов в формате JSON
echo json_encode(array_slice($senData, 0, 8));
?>