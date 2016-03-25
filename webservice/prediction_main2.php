<?php
    require_once('../excel_reader/excel_reader2.php');
    require_once("../include/class.php");
    require_once("../cron/cron_custom_functions.php");
    require_once("../webservice/custom_functions.php");
    require_once("../cron/check_file_updates.php");
    $qry             = mysql_query("select prediction_date from prediction_date where name='prediction_for'");
    $prediction_date = "";
    $result          = array();
    
    if ($x = mysql_fetch_array($qry)) {
        $prediction_date = $x['prediction_date'];
    }
 
    $reply = array();
    $i     = 0;
    $z     = 0;
    $xmlfile = "xml_data/best.xml";
    $product = simplexml_load_file($xmlfile);
    $j       = 0;
    $grpname = "";
    $result = array();


  $array = json_decode(json_encode((array)$product), TRUE);


  foreach ($array as $key => $oneproduct) {


    if ($oneproduct->best == '1') {
        $best = true;
    } else {
        $best = false;
    }

    $predict_high = $oneproduct['predict_high'];
    $predict_low  = $oneproduct['predict_low'];
    
    if (!empty($predict_high) or !empty($predict_low)) {


    $new1 = array();
    $new1['gid'] = (int)$oneproduct->gid;
    $new1['product_name'] = $oneproduct->product_name;
    $new1['best'] = (int)$best;
    $new[] = $new1;

    
  }


$new = array();
    foreach ($product->product as $oneproduct) {
        
        if ($oneproduct->best == '1') {
            $best = true;
        } else {
            $best = false;
        }

        $predict_high = $oneproduct->predict_high;
        $predict_low  = $oneproduct->predict_low;
        $predict_high = "$predict_high";
        $predict_low  = "$predict_low";
        
        if (!empty($predict_high) or !empty($predict_low)) {

        //$array = json_decode(json_encode((array)$xml), TRUE);
        	$new1 = array();
          $new1['gid'] = (int)$oneproduct->gid;
          $new1['product_name'] = $oneproduct->product_name;
          $new1['best'] = (int)$best;
          $new[] = $new1;

            $gid       = $oneproduct->gid;
            $id        = $oneproduct->id;
            $name      = $oneproduct->product_name;
            $groupname = $oneproduct->groupname;
            $trend     = $oneproduct->trend;
            $flag      = $oneproduct->img_path;
            
            if ($grpname != "$groupname") {
                $result['groupname'][] = "$groupname";
                $result['showLabel'][] = true;
                $grpname               = "$groupname";
            } else {
                $result['showLabel'][] = false;
                $result['groupname'][] = null;
            }

            $result['best'][]         = $best;
            $result['gid'][]          = "$gid";
            $result['id'][]           = "$id";
            $result['name'][]         = "$name";
            $result['predict_high'][] = "$predict_high";
            $result['predict_low'][]  = "$predict_low";
            $result['trend'][]        = "$trend";
            $result['flag'][]         = $web_url . "/$flag";
            //$result['prediction_date']=$prediction_date;
            $reply["predictions"][]   = $result;
        }

        $i++;
    }




$mylist =  (array)($new);

//echo '<pre>';
//print_r($mylist);
//echo '</pre>--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>';

# get a list of sort columns and their data to pass to array_multisort
/*
$sort = array();
foreach($mylist as $k=>$v) {
	$sort['gid'][$k] = $v['gid'];
	$sort['best'][$k] = $v['best'];
	$sort['product_name'][$k] = $v['product_name'];
}

# sort by event_type desc and then title asc
*/
//array_multisort($sort['gid'], SORT_ASC, $sort['best'], SORT_DESC, $sort['product_name'], SORT_ASC,$mylist);
 
//echo '<pre>';
//print_r($mylist);
//echo '</pre>---------------------------------------------------<br>';

//return;

/*
// Obtain a list of columns
foreach ($mylist as $key => $row) {
    $gid[$key]  = $row['gid'];
    $best[$key] = $row['best'];
    $product_name[$key] = $row['product_name'];
}
*/
// Sort the data with volume descending, edition ascending
// Add $data as the last parameter, to sort by the common key
//array_multisort($gid, SORT_ASC, $best, SORT_DESC, $product_name, SORT_ASC, $mylist);


//sort_comments_by_timestamp($mylist,array("best","product_name"));


/*
$array = array_msort($mylist	, array(
					'gid'=>SORT_ASC	
					, 'best'=>SORT_DESC
					, 'product_name'=>SORT_ASC
				)
			);

* osort($items, 'size');
* osort($items, array('size', array('time' => SORT_DESC, 'user' => SORT_ASC));
* osort($items, array('size', array('user', 'forname'))

*/
function xml2array ( $xmlObject, $out = array () )
{
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

        return $out;
}


osort($mylist, array('product_name' => SORT_DESC)); //  , array('gid', 'product_name')));//, array('gid','product_name')));// => SORT_ASC, 'gid' => SORT_DESC));
//osort($mylist, 'gid'); // => SORT_ASC, 'best' => SORT_DESC, 'product_name' => SORT_ASC));
//osort($mylist, array('size', array('user', 'forname'))

//$product = (object) $mylist;
echo 'NEW: <pre>';
print_r($mylist);
//echo '</pre>---------------------------------------------------<br>';

    foreach ($product->product as $oneproduct) {
        
        if ($oneproduct->best == '1') {
            $best = true;
        } else {
            $best = false;
        }

        $predict_high = $oneproduct->predict_high;
        $predict_low  = $oneproduct->predict_low;
        $predict_high = "$predict_high";
        $predict_low  = "$predict_low";
        
        if (!empty($predict_high) or !empty($predict_low)) {

          $new[] = $oneproduct;

            $gid       = $oneproduct->gid;
            $id        = $oneproduct->id;
            $name      = $oneproduct->product_name;
            $groupname = $oneproduct->groupname;
            $trend     = $oneproduct->trend;
            $flag      = $oneproduct->img_path;
            
            if ($grpname != "$groupname") {
                $result['groupname'][] = "$groupname";
                $result['showLabel'][] = true;
                $grpname               = "$groupname";
            } else {
                $result['showLabel'][] = false;
                $result['groupname'][] = null;
            }

            $result['best'][]         = $best;
            $result['gid'][]          = "$gid";
            $result['id'][]           = "$id";
            $result['name'][]         = "$name";
            $result['predict_high'][] = "$predict_high";
            $result['predict_low'][]  = "$predict_low";
            $result['trend'][]        = "$trend";
            $result['flag'][]         = $web_url . "/$flag";
            //$result['prediction_date']=$prediction_date;
            $reply["predictions"][]   = $result;
        }

        $i++;
    }



    $reply['status'] = 1;
    die(json_encode($result));
/*
function array_msort($array, $cols)
{
   $colarr = array();
   foreach ($cols as $col => $order) {
       $colarr[$col] = array();
       foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
   }
   $eval = 'array_multisort(';
   foreach ($cols as $col => $order) {
       $eval .= '$colarr[\''.$col.'\'],'.$order.',';
   }
   $eval = substr($eval,0,-1).');';
   eval($eval);
   $ret = array();
   foreach ($colarr as $col => $arr) {
       foreach ($arr as $k => $v) {
           $k = substr($k,1);
           if (!isset($ret[$k])) $ret[$k] = $array[$k];
           $ret[$k][$col] = $array[$k][$col];
       }
   }
   return $ret;
}



function sort_comments_by_timestamp(&$comments, $props)
{
    usort($comments, function($a, $b) use ($props) {
        if($a->$props[11] == $b->$props[11])
            return $a->$props[3] < $b->$props[3] ? 1 : -1;
        return $a->$props[11] < $b->$props[11] ? 1 : -1;
    });
}


*
* Sort an array of objects.
*
* You can pass in one or more properties on which to sort. If a
* string is supplied as the sole property, or if you specify a
* property without a sort order then the sorting will be ascending.
*
* If the key of an array is an array, then it will sorted down to that
* level of node.
*
* Example usages:
*
* osort($items, 'size');
* osort($items, array('size', array('time' => SORT_DESC, 'user' => SORT_ASC));
* osort($items, array('size', array('user', 'forname'))
*
* @param array $array
* @param string|array $properties
*/
function osort(&$array, $properties)
{
    if (is_string($properties)) {
      $properties = array($properties => SORT_ASC);
    }
    uasort($array, function($a, $b) use ($properties) {
      foreach($properties as $k => $v) {
        if (is_int($k)) {
          $k = $v;
          $v = SORT_ASC;
        }
      $collapse = function($node, $props) {
        if (is_array($props)) {
          foreach ($props as $prop) {
          $node = (!isset($node->$prop)) ? null : $node->$prop;
        }
          return $node;
        } else {
          return (!isset($node->$props)) ? null : $node->$props;
        }
      };
      $aProp = $collapse($a, $k);
      $bProp = $collapse($b, $k);
        if ($aProp != $bProp) {
          return ($v == SORT_ASC)
          ? strnatcasecmp($aProp, $bProp)
          : strnatcasecmp($bProp, $aProp);
        }
      }
      return 0;
    });
}


    ?>




