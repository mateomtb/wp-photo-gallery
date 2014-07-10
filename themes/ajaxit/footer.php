</head>
<body>

<?php
global $is_iPad, $is_iPhone, $is_Android_tablet, $is_Android_mobile;

if ( $is_iPad ) {
	include (THEMELIB . '/functions/ipadinterface.php');
} else if ( $is_iPhone ) {
	include (THEMELIB . '/functions/iphoneinterface.php');
} else if ( $is_Android_mobile ) {
	include (THEMELIB . '/functions/iphoneinterface.php');
} else if ( $is_Android_tablet ) {
	include (THEMELIB . '/functions/ipadinterface.php');
}

?>

</body>
</html>