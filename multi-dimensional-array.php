<?php
/*
function: nested2ul
original: https://stackoverflow.com/questions/48803780/need-html-design-of-tree-view-using-php-array
*/
function nested2ul($data) {
    $result = array();

    if (sizeof($data) > 0) {
        $result[] = '<ul>';
        foreach ($data as $entry) {
            if(isset($entry['children'])){
              $result[] = sprintf(
                      '<li>%s %s</li>', $entry['name'], nested2ul($entry['children'])
              );
            } else {
              $result[] = sprintf(
                      '<li>%s</li>', $entry['name']
              );
            }
        }
        $result[] = '</ul>';
    }

    return implode($result);
}
/*
function: createTree
original: https://stackoverflow.com/questions/4196157/create-array-tree-from-array-list
*/
function createTree(&$list, $parent){
    $tree = array();
    foreach ($parent as $k=>$l){
        if(isset($list[$l['id']])){
            $l['children'] = createTree($list, $list[$l['id']]);
        }
        $tree[] = $l;
    }
    return $tree;
}


$arr = array();

//$result_task_query is a query result of "SELECT id, name, parent FROM tasklist"
while($rows=mysqli_fetch_array($result_task_query))
{
  $arr[] = $rows;
}

$new = array();
foreach ($arr as $a) {
  $new[$a['parent']][] = $a;
}

$tree = array();
foreach ($arr as $k=>$a) {
  if ($a['parent'] == '0') {
    $tree[] = createTree($new, array($arr[$k]));
  }
}
// $tree = createTree($new, array($arr[0]));
// echo "<pre>";
// print_r($tree);
// echo "</pre>";
$html = '';
foreach($tree as $t){
  $html .= nested2ul($t);
}
echo $html;
?>
