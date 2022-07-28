<?php

function explodeUrl($path)
{
  $fullpath = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $fullpath = strtok($fullpath,'?');
  $array = explode("/",str_replace($path,'',$fullpath));
  for ($i=0; $i<count($array); $i++)
  {
    if($array[$i]!=='') $url[$i+'1'] = $array[$i];
  }
  return @$url;
}
function mobileDetect()
{
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) $useragent=1;
	return $useragent;
}
function replaceLinks($string)
{
  $rexProtocol = '(https?://)?';
  $rexDomain   = '((?:[-a-zA-Z0-9]{1,63}\.)+[-a-zA-Z0-9]{2,63}|(?:[0-9]{1,3}\.){3}[0-9]{1,3})';
  $rexPort     = '(:[0-9]{1,5})?';
  $rexPath     = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
  $rexQuery    = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
  $rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
  function callback($match)
  {
    $completeUrl = $match[1] ? $match[0] : "http://{$match[0]}";
    return '<a href="'.$completeUrl.'" target="_blank">'.$match[2].$match[3].$match[4].'</a>';
  }
  $newString = preg_replace_callback("&\\b$rexProtocol$rexDomain$rexPort$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))&", 'callback', htmlspecialchars($string));
  return $newString;
}
function clearString($string)
{
  $string = addslashes($string);
  $string = htmlspecialchars($string);
  $string = strip_tags($string);
  $string = htmlentities($string);
  return $string;
}
function detectOS()
{
  $useragent = getenv('HTTP_USER_AGENT');
  if(strpos($useragent, 'Win') !== false) $os = 'windows';
  elseif(strpos($useragent, 'Mac') !== false) $os = 'mac';
  return $os;
}
function getUserIP()
{
  if (empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  else
  {
    $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $ip = $ip[0];
  }
  return $ip;
}
function viewParser($url,$replace=null,$root='./')
{
  $view = file_get_contents($root.'system/view/'.$url);
  if($replace!==null)
  {
    foreach($replace as $key => $value)
    {
      $view = str_replace('{{'.$key.'}}', $value, $view);
    }
  }
  $view = preg_replace("/---[\s\S]*---/", "", $view);
  $view = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $view);
  return $view;
}
function hex2rgb($hex)
{
  $hex = str_replace("#", "", $hex);
  if(strlen($hex) == 3)
  {
    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
  }
  else
  {
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));
  }
  $rgb = array($r, $g, $b);
  return $rgb;
}
function adminChecker($facebookid,$config,$target)
{
  if($facebookid !== null)
  {
    if(in_array($facebookid,$config['admin']))
    {
      include_once './system/controller/adminController.php';
      new $target();
    }
    else
    {
      $url = $config['site']['path'];
      header("Location: $url");
    }
  }
  else
  {
    $url = $config['site']['path'].'signin';
    header("Location: $url");
  }
}
?>
