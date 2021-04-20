<?php
$data = file_get_contents("backend-titanic-test.json");
$arr_data = json_decode($data, true);

// sorting array
usort($arr_data, function ($a, $b) {
    return $a['age'] - $b['age'];
});

echo "Showing sorted data by Age </br></br>";
foreach ($arr_data as $value) {
    echo $value['name'] . " - " . $value['age'] . "</br>";
}

//count total per age
function countArr($param)
{
    $count_arr_age = [];
    $age = "";
    $count = 0;
    foreach ($param as $value) {
        if ($age != $value['age']) {
            if ($count > 0) {
                $count_arr_age[] = ['age' => $age, "total" => $count];
            }
            $count = 1;
            $age = $value['age'];
        } else {
            $count++;
        }
    }

    if ($count > 0) {
        $count_arr_age[] = ['age' => $age, 'total' => $count];
    }

    return $count_arr_age;
}

$data_count_per_age = countArr($arr_data);

echo "</br> Showing Count Per Age </br></br>";
foreach ($data_count_per_age as $value) {
    echo "age : " . $value['age'] . " || total : " . $value['total'] . "</br>";
}

$highest_total_age = max(array_column($data_count_per_age, 'total'));
$highest_age_showing = array_search($highest_total_age, array_column($data_count_per_age, 'total'));

echo "</br>Max showing age is " . $data_count_per_age[$highest_age_showing]['age'] . " with total showing " . $highest_total_age;

$group_max_age_showing = [];
foreach ($arr_data as $value) {
    if ($value['age'] == $data_count_per_age[$highest_age_showing]['age']) {
        $group_max_age_showing[] = $value['name'];
    }
}

echo "</br>Group age with age " . $data_count_per_age[$highest_age_showing]['age'] . " : " . json_encode($group_max_age_showing);
