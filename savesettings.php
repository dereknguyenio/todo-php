<?php 
    if(!isset($_SERVER['HTTP_REFERER'])){
        header('location:../index.php');
        exit;
    }
?>

<?php 
	require("./templates/header.php"); 
?>

<div class="container">
    <?php 
        //write out the connection settings to the connectionvalues.php file
        //this file is required by config.php
        require("./templates/nav.php"); 
    
        $hostValue      = "\$host           = '" . $_POST['host'] . "';\n";
        $usernameValue  = "\$username       = '" . $_POST['name'] . "';\n";
        $passwordValue  = "\$password       = '" . $_POST['password'] . "';\n";

        $configFile = fopen("./connectvalues.php", "w");
 
        fwrite($configFile, "<?php\n");
        fwrite($configFile, $hostValue);
        fwrite($configFile, $usernameValue);
        fwrite($configFile, $passwordValue);
        fclose($configFile);
    ?>

    <h4>Saving settings and testing connection</h4> <br>

    <?php
        require "./config.php";

        try {
            echo "<br> Connecting to database. <p>";
            $connection = new PDO("mysql:host=$host", $username, $password, $options);
            $sql = file_get_contents("data/init.sql");
            $connection->exec($sql);
            
            echo "Database connection successful. <p>";
            echo "Feel free to add a task using the menu up top.";
        } catch(PDOException $error) {
            echo "<br> There was an error connecting to the database server: <br>" . $sql . "<br>" . $error->getMessage();
        }
    ?>
</div>