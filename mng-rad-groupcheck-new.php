<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	// declaring variables
	$groupname = "";
	$op = "";
	$attribute = "";
	$value = "";	

        if (isset($_POST['submit'])) {
	        $groupname = $_POST['groupname'];
	        $op = $_POST['op'];
	        $attribute = $_POST['attribute'];
			$value = $_POST['value'];

            include 'library/config.php';
            include 'library/opendb.php';

			$counter = 0;
			foreach ($groupname as $group) {
				
				$sql = "SELECT * FROM radgroupcheck WHERE GroupName='$group' AND Value='$value[$counter]'";
				$res = mysql_query($sql) or die('Query failed: ' . mysql_error());
				
				if (mysql_num_rows($res) == 0) {
					if (trim($group) != "" and trim($value[$counter]) != "" and trim($op[$counter]) != "" and trim($attribute[$counter]) != "") {								
						// insert usergroup details
						$sql = "INSERT INTO radgroupcheck values (0,'$group', '$attribute[$counter]', '$op[$counter]', '$value[$counter]')";
						$res = mysql_query($sql) or die('Query failed: ' . mysql_error());
						$counter++;
					}
				} else {
                        echo "<font color='#FF0000'>error: the group [$groupname[$counter]] already exist in the database with value [$value[$counter]] <br/></font>";
						echo "
                                <script language='JavaScript'>
                                <!--
                                alert('The group $groupname[$counter] already exists in the database with value $value[$counter]');
                                -->
                                </script>
                        ";
                }
				
			}
                        
            include 'library/closedb.php';
        }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>

<SCRIPT TYPE="text/javascript">
<!--
function toggleShowDiv(pass) {

        var divs = document.getElementsByTagName('div');
        for(i=0;i<divs.length;i++) {
                if (divs[i].id.match(pass)) {
                        if (document.getElementById) {                                         
                                if (divs[i].style.display=="inline")
                                        divs[i].style.display="none";
                                else
                                        divs[i].style.display="inline";
                        } else if (document.layers) {                                           
                                if (document.layers[divs[i]].display=='visible')
                                        document.layers[divs[i]].display = 'hidden';
                                else
                                        document.layers[divs[i]].display = 'visible';
                        } else {
                                if (document.all.hideShow.divs[i].visibility=='visible')     
                                        document.all.hideShow.divs[i].visibility = 'hidden';
                                else
                                        document.all.hideShow.divs[i].visibility = 'visible';
                        }
                }
        }
}



// -->
</script>


<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

</head>
 
<?php
	include ("menu-mng-rad-groupcheck.php");
?>
		
		<div id="contentnorightbar">
		
				<h2 id="Intro"><a href="#">New Group Check Mapping</a></h2>
				
				<p>

                                <form name="newgroupreply" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                                                <?php if (trim($groupname) == "") { echo "<font color='#FF0000'>"; }?>
                                                <b>Groupname</b>
                                                <input value="<?php echo $groupname[0] ?>" name="groupname[]"/>
                                                </font><br/>

                                                <?php if (trim($attribute) == "") { echo "<font color='#FF0000'>";  }?>
												<b>Attribute</b>
                                                <input value="<?php echo $attribute[0] ?>" name="attribute[]" /> 
                                                </font><br/>
												
                                                <?php if (trim($op) == "") { echo "<font color='#FF0000'>";  }?>
                                                <b>Operator</b>
												<select name="op[]" />
													<option value="==">==</option>
													<option value=":=">:=</option>
													<option value="=">=</option>
													<option value=":">:</option>
												</select>
                                                </font><br/>

                                                <?php if (trim($value) == "") { echo "<font color='#FF0000'>";  }?>
                                                <b>Value</b>
                                                <input value="<?php echo $value[0] ?>" name="value[]" />
                                                </font><br/>

                                                <br/><br/>
                                                <input type="submit" name="submit" value="Apply"/>

                                </form>


				</p>
				
		</div>
		
		<div id="footer">
		
								<?php
        include 'page-footer.php';
?>

		
		</div>
		
</div>
</div>


</body>
</html>