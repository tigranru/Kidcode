<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="codemirror-4.0/lib/codemirror.css">
	<link rel="stylesheet" href="codemirror-4.0/addon/hint/show-hint.css">
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/bootstrap-theme.min.css" rel="stylesheet"/>

 <!--
    <script src="https://cdn.firebase.com/v0/firebase.js"/>
-->

	<script src="codemirror-4.0/lib/codemirror.js"></script>
	<script src="codemirror-4.0/addon/hint/show-hint-patched.js"></script>
	<script src="codemirror-4.0/addon/hint/javascript-hint-patched.js"></script>
	<script src="codemirror-4.0/addon/edit/matchbrackets.js"></script>
	<script src="codemirror-4.0/mode/javascript/javascript.js"></script>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script> 

<!--
	<link rel="stylesheet" href="firepad/firepad.css" />
    <script src="firepad/firepad.js"></script>	
 -->
<style>
	body {
	  padding-top: 60px;
	  padding-bottom: 30px;
	}

	.theme-dropdown .dropdown-menu {
	  position: static;
	  display: block;
	  margin-bottom: 20px;
	}

	.theme-showcase > p > .btn {
	  margin: 5px 0;
	}
</style>

</head>

<body role="document">
   <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">KidCode – программирование для детей</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#about">О проекте</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>


   <div class="container theme-showcase" role="main">

	<br>
	<div>
		<table border=0>
		<tr>
			<td>
			</td>
			<td></td>
		<tr>
			<td valign=top>
				<div style='border: solid 1px black; width: 451px;'><textarea id="code"></textarea></div>
			</td>
			<td valign=middle width='80px' align=center>
				<button type="button" class="btn btn-success">Run</button><br><br>
			</td>
			<td valign=top style='padding-left: 0px'>
				<div style='width: 460px'><iframe name="runtime" src="run.html" id="runtime" style='width: 100%; height: 460px;border: 0px' border=0></iframe></div>
			</td>
		</tr></table>
	</div>

  </div>
<?
	$file = fopen("code.js", "r");
	$code=fread($file, filesize("code.js"));
	$code=str_replace('"', "\\\"", $code);
	$code=str_replace("\n", "\\n", $code);
	fclose($file);
?>
	<script>
		//http://www.firepad.io/docs/
		
		function Run() {
				document.getElementById("RunForm").codeText.value=editor.getValue();
				document.getElementById("RunForm").submit();
		}


	//	https://flickering-fire-6952.firebaseio.com/
	//	var firepadRef = new Firebase("https://flickering-fire-6952.firebaseio.com");


		 var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		 	mode:  "javascript",
		    lineNumbers: true,
		    styleActiveLine: true,
		    matchBrackets: true,
		    tabSize: 2,
		    indentUnit: 2,
		    completeSingle: false,
		  //  extraKeys: {"Ctrl-Space": "autocomplete"},		    

		 	});

		editor.on("keypress", function(cm, change) { 
			setTimeout(function() { cm.execCommand("autocomplete"); }, 20); 
		}); 

		editor.setValue("<?=$code?>");
		editor.setSize("448px", "450px");


/*		var firepad = Firepad.fromCodeMirror(firepadRef, editor);

		firepad.on('ready', function() {
			//alert("ready");
	      if (firepad.isHistoryEmpty()) {
	        firepad.setText('// JavaScript Editing with Firepad!\nfunction go() {\n  var message = "Hello, world.";\n  console.log(message);\n}');
	      }
	    });
*/


		$(document).ready(function(){
		  $("button").click(function(){
		    $.post("save.php",
		    {
		      codeText: editor.getValue()
		    },
		    function(){
		    	$('#runtime').attr('src', "run.html?"+Math.random());
		    });
		  });
		});

	</script>
</body>
</html>

