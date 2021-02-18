<?php
    require 'db_connection.php';
    include("auth_session.php");
    $id = $_GET['id']; // get id through query string
    $query = "SELECT * FROM `Games` WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    while($row = $result->fetch_assoc()) {
        $name = $row['name']; // Print a single column data
    }
        
    if (isset($_POST['newcategory'])) {
        $newcategory = stripslashes($_REQUEST['newcategory']);    // removes backslashes
        $newcategory = mysqli_real_escape_string($conn, $newcategory);
        $querycheck =  "SELECT
                            *
                        FROM
                            GameCategory
                        WHERE
                            game_id = $id AND categoryname = '$newcategory'";
        $querycheckresult = mysqli_query($conn, $querycheck) or die(mysql_error());
        $rows = mysqli_num_rows($querycheckresult);
        echo $rows;
        if($rows == 0) {
            $queryinsert = "INSERT INTO `GameCategory`(`game_id`, `categoryname`)
                            VALUES($id,'$newcategory')";
            $queryinsertresult = mysqli_query($conn, $queryinsert);
        }
    }
    
    if (isset($_POST['newcategory1'])) {
        $newcategory1 = stripslashes($_REQUEST['newcategory1']);    // removes backslashes
        $newcategory1 = mysqli_real_escape_string($conn, $newcategory1);
        $newcategory1id = stripslashes($_REQUEST['newcategory1id']);    // removes backslashes
        $newcategory1id = mysqli_real_escape_string($conn, $newcategory1id);
        echo $newcategory1;
        echo $newcategory1id;
        $queryinsert = "INSERT INTO `CategoryEntries`(`category_id`, `title`)
                        VALUES( $newcategory1id,'$newcategory1' )";
        echo $queryinsert;
        $queryinsertresult = mysqli_query($conn, $queryinsert);
    }
    
        if (isset($_POST['newcategory2'])) {
        $newcategory2 = stripslashes($_REQUEST['newcategory2']);    // removes backslashes
        $newcategory2 = mysqli_real_escape_string($conn, $newcategory2);
        $newcategory2id = stripslashes($_REQUEST['newcategory2id']);    // removes backslashes
        $newcategory2id = mysqli_real_escape_string($conn, $newcategory2id);
        echo $newcategory2;
        echo $newcategory2id;
        $queryinsert = "INSERT INTO `CategoryEntries`(`category_id`, `title`)
                        VALUES( $newcategory2id,'$newcategory2' )";
        echo $queryinsert;
        $queryinsertresult = mysqli_query($conn, $queryinsert);
    }
    
        if (isset($_POST['newcategory3'])) {
        $newcategory3 = stripslashes($_REQUEST['newcategory3']);    // removes backslashes
        $newcategory3 = mysqli_real_escape_string($conn, $newcategory3);
        $newcategory3id = stripslashes($_REQUEST['newcategory3id']);    // removes backslashes
        $newcategory3id = mysqli_real_escape_string($conn, $newcategory3id);
        echo $newcategory3;
        echo $newcategory3id;
        $queryinsert = "INSERT INTO `CategoryEntries`(`category_id`, `title`)
                        VALUES( $newcategory1id,'$newcategory1' )";
        echo $queryinsert;
        $queryinsertresult = mysqli_query($conn, $queryinsert);
    }
    
    ?>

<html>
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include('header.php'); ?>
    <div id="GOTitle">
    <?php echo $name; ?>
    </div>
    <?php
        $query = "SELECT * FROM `GameCategory` WHERE game_id='$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_num_rows($result);
        $x = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            $x++;
            $rowid = $row["id"];
            $query2 = "SELECT * FROM CategoryEntries where category_id = $rowid";
            echo $query2;
            $result2 = mysqli_query($conn,$query2);
            $row2 = mysqli_num_rows($result2);
            echo "<p id='GOCustomTableHeader".$x."'>".$row["categoryname"]."</p>";
            echo '<table id="GOCustomTable'. $x.'">';
            if ($result2->num_rows > 0) {
                while($row = $result2->fetch_assoc()) {
                    echo '<tr><td>'.$row["title"].'</td></tr>';
                }
            }
            echo '</table>';
            }
        }
    ?>
    
    <form id='GOAddCategoryMain' method="POST">
        <input type="hidden" name='id' value='<?php echo $id ?>'>
        <input type="Text" name="newcategory">
        <input type="submit" value="Add new Category" name="AddCategorySubmit">
    </form>
    <?php
    
    $query = "SELECT * FROM `GameCategory` WHERE game_id=$id";
    echo $query;
    $result = mysqli_query($conn, $query);
    $row = mysqli_num_rows($result);
    if ($result->num_rows > 0) {
        $x = 0;
        while($row = $result->fetch_assoc()) {
            $x++;
            $categoryname = stripslashes($row['categoryname']);    // removes backslashes
            $categoryname = mysqli_real_escape_string($conn, $categoryname);
            $categoryid = stripslashes($row['categoryid']);    // removes backslashes
            $categoryid = mysqli_real_escape_string($conn, $categoryid);
            echo '<form id="GOAddCategory'.$x.'" method="POST">
            <input type="hidden" name="newcategory'.$x.'id" value="'.$row["id"].'">
            <input type="Text" name="newcategory'.$x.'">
            <input type="submit" value="Add new '.$categoryname.'" name="Add'.$x.'Submit">
            </form>';
        }
    }
    
    ?>
    
    </body>
    </html>