<?php
$url = 'https://contribution.usercontent.google.com/download?c=CgthaWRhX2NvZGVmeBJ7Eh1hcHBfY29tcGFuaW9uX2dlbmVyYXRlZF9maWxlcxpaCiVodG1sXzM1Yjk3M2IxYzk0NDRmNjlhZmUyY2E4OGRmZGE2MTAxEgsSBxCIz9bn1hwYAZIBIwoKcHJvamVjdF9pZBIVQhM1MTg4MDA2MzQ3MTMzNTEzMTI4&filename=&opi=96797242';
$html = file_get_contents($url);
file_put_contents('page-about-raw.html', $html);
echo "Done fetching.";
