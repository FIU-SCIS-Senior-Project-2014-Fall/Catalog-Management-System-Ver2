<?php
/* @var $this ProspectiveController */

    $this->breadcrumbs=array(
	'Prospective'=>array('/catalog/prospective'),
	'Create',
);
     
    $dbc = mysqli_connect( "localhost:3306", "curriculum", "Tur99tleMuta33nt", "curriculum" ) or die( "Could not connect to database" );
    
    $query = "SELECT * FROM curr_dgu";
    $result = mysqli_query($dbc, $query);
            
?>
<h2><?php echo 'Create Prospective Catalog ( Step 1 ): Select DGU'; ?></h2>

<div class = "form" >

    <form action="../prospective/createStep2.php" method="post" id="selectdgu"> 
    <h3>Please select your DGU below</h3>
    
    <select name="dgu">
        <?php while( $row = mysqli_fetch_row($result)) 
                {?>
        <option value = " <?php echo $row[1]; ?> "> <?php echo $row[1]; ?> </option>
        <?php } ?>
    </select>
    <label for="catalogName"> Catalog Name </label>
    <input type="text" name="catalogName" id="catalogname" required ></br>
    </br>
    <input type="submit" value="Start Creating Prospetive Catalog "/>
    
    </form>

</div><!--form end-->
