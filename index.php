<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Happy Things</title>
		<link rel="stylesheet" href="style.css" type="text/css"/>
	</head>
	<body>
		<p><span class="happythings"><a href="http://kylemcdonald.net/happythings/">Happy Things</a></span> is a one hour <a href="http://fffff.at/speed-projects/">speed project</a> by <a href="http://theowatson.com/">Theo Watson</a> and <a href="http://kylemcdonald.net/">Kyle McDonald</a> that automatically posts a screenshot every time you smile. Download it <a href="HappyThings-001.zip">here</a> (OS X, 10 MB).</p>

<?php
$dir = opendir("images");
while($cur = readdir($dir)) {
	if($cur[0] != "." && $cur != "") {
    $all[] = $cur;
	}
}
closedir($dir);

rsort($all);

$n = count($all);
$cur = intval($_GET["start"]);
$width = intval($_GET["width"]);
$perPage = intval($_GET["perpage"]);
$mode = $_GET["mode"];

if(!$perPage) {
	$perPage = 20;
}

if(!$mode) {
	$mode = "all";
}

if($mode == "all") {
	print("\t\t<p class=\"info\">$n Happy Things are being shared. <a href=\"?mode=each\">How many people?</a></p>\n");

	for($i = 0; $i < $perPage;) {
			if($cur < $n) {
					$file = "images/$all[$cur]";
					print("\t\t<a href=\"$file\"><img src=\"$file\"");
					if($width != 0) {
							print(" width=\"$width\"");
					}
					print("/></a>\n");
					$i++;
					$cur++;
			} else {
					break;
			}
	}

	if($cur < $n) {
			$nextPage = intval(ceil($cur / $perPage));
			$total = intval(ceil($n / $perPage));
			print("\t\t<a href=\"?start=$cur\"><p>Click here for page $nextPage of $total</p></a>");
	}
} else if($mode == "each") {
	$allCount = count($all);
	for($i = 0; $i < $allCount; $i++) {
		$cur = $all[$i];
		$parts = explode(":", $cur);
		$ips[] = (string) substr($parts[1], 0, -4);
	}

	$ipCounts = array_count_values($ips);
	$uniqueCount = count($ipCounts);

	print("\t\t<p class=\"info\">$uniqueCount people are sharing Happy Things. <a href=\"?mode=all\">How many things?</a></p>\n");

	while ($curValue = current($ipCounts)) {
		$curIp = key($ipCounts);
		//print("<!-- $curIp ($curValue) -->\n");
		next($ipCounts);

		for($i = 0; $i < $allCount; $i++) {
			$curImg = $all[$i];
			if(strstr($curImg, $curIp)) {
					print("\t\t<img src=\"images/$curImg\"");
					if($width != 0) {
							print(" width=\"$width\"");
					}
					print("/>\n");
				break;
			}
		}
	}
}

?>

	</body>
</html>
