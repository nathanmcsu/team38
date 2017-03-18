<html>

<?php
$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = dbhost.ugrad.cs.ubc.ca)(PORT = 1522)))(CONNECT_DATA=(SID=ug)))";
if ($c=OCILogon("ora_j2z9a", "a39864146", $db)) {
    echo "Successfully connected to Oracle.\n <br/>";

} else {
    $err = OCIError();
    echo "Oracle Connect Error " . $err['message'];
}
##$parameter = $_SERVER['QUERY_STRING'];
echo "Return the advisor name and id who is assigned to all students <br />";
$divisionQuery = "select a. aid, a.name from advisor_work a
                  where not exists(
                  select * from students
                  where not exists(
                  select * from student_assign
                  where student_assign.aid=a.aid and student_assign.sid=students.sid))";
$stid = oci_parse($c,$divisionQuery);
$r = oci_execute($stid);
print '<table border="1">';
while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
    print '<tr>';
    foreach ($row as $item) {
        print '<td>'.($item !== null ? htmlentities($item, ENT_QUOTES) : '&nbsp').'</td>';
    }
    print '</tr>';
}
print '</table>';

OCILogoff($c);
?>
</html>
