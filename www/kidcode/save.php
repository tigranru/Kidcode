<?php
	error_reporting(E_ALL);

	$codeTextOrigin = $_POST['codeText'];

	$pattern = '/repeat\s+\{/i';
	$replacement = 'function paint() {';
	$codeText = preg_replace($pattern, $replacement, $codeTextOrigin);

	$file = fopen("mel.js", "r");
	$mel=fread($file, filesize("mel.js"));
	fclose($file);


	$file = fopen("run_template.html", "r");
	$tmpl=fread($file, filesize("run_template.html"));
	fclose($file);

	$tmpl=str_replace('$mel', $mel, $tmpl);
	$tmpl=str_replace('$codeText', $codeText, $tmpl);

	//$codeText = "<body><script>\n$mel\n</script><script>$codeText</script></body>";
	
	$file = fopen("run.html","w");
	fwrite($file, $tmpl);
	fclose($file);

	$file = fopen("code.js","w");
	fwrite($file, $codeTextOrigin);
	fclose($file);
?>