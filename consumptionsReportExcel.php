<?php

include 'dbh.php';

if(isset($_POST["export"]))
{
    $sql = "SELECT consumptions.Item, subtypes.Type, consumptions.Subtype, Quantity, `Number in Stock`, `Minimum Stock`, Person, Reason, `Consume Date`, `Update Person` FROM consumptions JOIN subtypes ON subtypes.Subtype = consumptions.Subtype JOIN consumables ON consumptions.Item = consumables.Item;";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        $output = '<h2><b>Consumed Items</b></h2>
                   <table class="table" bordered="1">
                       <tr>
                           <th>Item</th>
                           <th>Type</th>
                           <th>Subtype</th>
                           <th>Quantity Consumed</th>
                           <th>Number in Stock (Minimum)</th>
                           <th>Borrower</th>
                           <th>Reason</th>
                           <th>Consume Date</th>
                           <th>Update Person</th>
                       </tr>';
        while($row = mysqli_fetch_array($result))
        {
            $output .= '<tr>
                            <td>'.$row["Item"].'</td>
                            <td>'.$row["Type"].'</td>
                            <td>'.$row["Subtype"].'</td>
                            <td>'.$row["Quantity"].'</td>
                            <td>'.$row["Number in Stock"].' ('.$row["Minimum Stock"].')</td>
                            <td>'.$row["Person"].'</td>
                            <td>'.$row["Reason"].'</td>
                            <td>'.$row["Consume Date"].'</td>
                            <td>'.$row["Update Person"].'</td>
                        </tr>';
        }
        $output .= '</table>';

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=consumable_export.xls');
        echo $output;
    }
}
?>