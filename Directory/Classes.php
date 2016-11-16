<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SCCS All Classes</title>
<meta name="keywords" content="Southern Connecticut Chinese School, Chinese School">
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<script language="javascript" src="../common/JS/MainValidate.js"></script>
<style> table th {background: #3c763d !important;} </style>
</head>

<body>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td width="98%" bgcolor="#993333">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>

					<?php
					     //echo $_SESSION[memberid];
						$SQLstring = "select *   from tblClass left join tblMember on  tblClass.TeacherMemberID=tblMember.MemberID where tblClass.CurrentClass='Yes' ";
						if ($_GET[year] != "" ) { $SQLstring .= " and tblClass.Year='".$_GET[year] . "' "; }
						if ($_GET[term] != "" ) { $SQLstring .= " and tblClass.Term='".$_GET[term] . "' "; }
						$SQLstring .= " ORDER by tblClass.ClassCode, tblClass.GradeOrSubject, tblClass.ClassNumber,tblClass.Year ";
						// and TeacherMemberID=".$_SESSION[memberid];

						$RS1=mysqli_query($conn,$SQLstring);

                        $seclvl = $_SESSION[membertype]; 
					?>
					<td align="center" valign="top">
					<br /><br/><a href="Classes.php">All Classes for <?php echo $SchoolYear; ?></a>
					<a href="Classes.php?year=<?php echo $CurrentYear; ?>&term=Fall"><?php echo $CurrentYear; ?> Fall Classes</a>
					<a href="Classes.php?year=<?php echo $NextYear; ?>&term=Spring"><?php echo $NextYear; ?> Spring Classes</a>
					<br/><br/>
                                        <table width="100%" border=1>
<?php if ($SHOWTEACHER == 'Yes' && isset($_SESSION[membertype])                   ) { ?>
						<tr><th>ClassID</th><th>Class Code</th><th>Grade</th><th>Number</th><th>Period</th><th>Term</th><th>Year</th><th>Room</th><th>Teacher<br>English Name</th><th>Teacher<br>Chinese Name</th>
<?php     } else { 
				echo "		<tr>                <th>Class Code</th><th>Grade</th><th>Number</th><th>Period</th><th>Term</th><th>Year</th>             ";
          } ?>
					<?php if (isset($_SESSION[membertype])  ) {
					        if ( $seclvl == 10 || $seclvl == 15                 ) {
						       echo "<th>Home Phone</th><th>Cell Phone</th><th>Email</th>";
						    } else {
     if ($SHOWTEACHER == 'Yes') {
						       echo "<th>Email</th>";
     }
						    }
					echo "	<th nowrap>Desc/Students</th><th>Fee</th></tr>";
					 } ?>
                    <?php
					  while ( $row=mysqli_fetch_array($RS1) ){
if ($row[IsLanguage] == 'Yes' || strpos($row[GradeOrSubject],"two periods") != false )
{
 if ($row[Period]=='1') {
                                                                                               $period= $PERIOD1." ".$PERIOD2;
                                                                                            } else if ($row[Period]=='0') {
                                                                                               $period= $PERIOD0." ".$PERIOD1;
                                                                                            } else if ($row[Period]=='2') {
                                                                                               $period= $PERIOD2." ".$PERIOD3;
                                                                                            } else if ($row[Period]=='3') {
                                                                                               $period= $PERIOD3." ".$PERIOD4;
                                                                                            } else if ($row[Period]=='4') {
                                                                                               $period= $PERIOD4;
 }
}
else {
 if ($row[Period]=='1') {
                                                                                               $period= $PERIOD1;
                                                                                            } else if ($row[Period]=='0') {
                                                                                               $period= $PERIOD0;
                                                                                            } else if ($row[Period]=='2') {
                                                                                               $period= $PERIOD2;
                                                                                            } else if ($row[Period]=='3') {
                                                                                               $period= $PERIOD3;
                                                                                            } else if ($row[Period]=='4') {
                                                                                               $period= $PERIOD4;
 }
}
/*			    if ( $row[Period] == '1') {
						       $period = "<td align=center>$PERIOD1</td>";
						    } else if ( $row[Period] == '2') {
						       $period = "<td align=center>$PERIOD2</td>";
						    } else if ( $row[Period] == '3') {
						       $period = "<td align=center>$PERIOD3</td>";
						    } else if ( $row[Period] == '4') {
							   $period = "<td align=center>$PERIOD4</td>";
    						} */
						echo "	<tr>";
					 if (isset($_SESSION[membertype])  ) {
						echo "		<td align=center>" . $row[ClassID] ."</td>";
                                         }
						echo "		<td align=center>" . $row[ClassCode] ."</td>";
						echo "		<td align=center>" . $row[GradeOrSubject] ."</td><td align=center>". $row[ClassNumber] . "</td><td>$period</td><td nowrap align=center>&nbsp;". $row[Term] ."</td><td nowrap align=center>&nbsp;". $row[Year] ."</td>";
					 if (isset($_SESSION[membertype])  ) {
                                                echo "<td align=center>&nbsp;". $row[Classroom] ."</td>" ;
                                         }
     if ($SHOWTEACHER == 'Yes' || $seclvl == 10 || $seclvl == 15                ) {
					 if (isset($_SESSION[membertype])  ) {
						echo "      <td align=left nowrap>&nbsp;" . $row[FirstName] ." ".$row[LastName]."</td>";
						echo "      <td align=left>&nbsp;" . $row[ChineseName]."</td>";
                                         }
     }
					 if (isset($_SESSION[membertype])  ) {

					   if ( $seclvl == 10 || $seclvl == 15                 ) {
						echo "      <td align=left>&nbsp;" . $row[HomePhone]."</td>";
						echo "      <td align=left>&nbsp;" . $row[CellPhone]."</td>";
						echo "      <td align=left>&nbsp;" . $row[Email]."</td>";
					   } else {
     if ($SHOWTEACHER == 'Yes') {
						echo "      <td align=left>&nbsp;" . $row[Email]."</td>";
     }
                                           }
   echo "  <td><a href=\"../classes/ClassDetail.php?id=".$row[ClassID]."\" target=_blank>Description</a>";
					 }

					 if (isset($_SESSION[membertype])  ) {
					 if ( $seclvl <=25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55) {
						echo "      <a href=\"../MemberAccount/MyStudents.php?teacherid=".$row[TeacherMemberID]."&classid=".$row[ClassID]."&classroom=".$row[Classroom]."&year=".$row[Year]."&term=".$row[Term]."\">Students</a></td>";
					} else {
						echo "      <a href=\"../MemberAccount/MyStudents.php?teacherid=".$row[TeacherMemberID]."&classid=".$row[ClassID]."&classroom=".$row[Classroom]."&year=".$row[Year]."&term=".$row[Term]."\">Students</a></td>";
					}
						echo "<td>".$row[ClassFee]."</td>";
					} else {
						echo "";
					}
						echo "	</tr>";
					  }
						?>
						</table>
					</td>

				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>

		</td>
	</tr>
	<tr>
		<td>
		<?php include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>
<?php mysqli_close($conn); ?>
