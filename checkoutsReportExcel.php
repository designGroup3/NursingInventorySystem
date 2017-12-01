<?php

include 'dbh.php';

if(isset($_POST["export"]))
{
    $sql = "SELECT checkouts.Item, subtypes.Type, checkouts.Subtype, `Quantity Borrowed`, inventory.`Number in Stock`, Person, Reason, `Checkout Date`, `Update Person`, `Due Date`, `Return Date` FROM checkouts JOIN subtypes ON subtypes.Subtype = checkouts.Subtype JOIN inventory ON checkouts.Item = inventory.Item;";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        $output = '<h2><b>Check-out History</b></h2>
                   <table class="table" bordered="1">
                       <tr>
                           <th>Item</th>
                           <th>Type</th>
                           <th>Subtype</th>
                           <th>Quantity Borrowed</th>
                           <th>Number in Stock</th>
                           <th>Borrower</th>
                           <th>Reason</th>
                           <th>Checkout Date</th>
                           <th>Update Person</th>
                           <th>Due Date</th>
                           <th>Return Date</th>
                       </tr>';
        while($row = mysqli_fetch_array($result))
        {
            $output .= '<tr>
                            <td>'.$row["Item"].'</td>
                            <td>'.$row["Type"].'</td>
                            <td>'.$row["Subtype"].'</td>
                            <td>'.$row["Quantity Borrowed"].'</td>
                            <td>'.$row["Number in Stock"].'</td>
                            <td>'.$row["Person"].'</td>
                            <td>'.$row["Reason"].'</td>
                            <td>'.$row["Checkout Date"].'</td>
                            <td>'.$row["Update Person"].'</td>
                            <td>'.$row["Due Date"].'</td>
                            <td>'.$row["Return Date"].'</td>
                        </tr>';
        }
        $output .= '</table>';

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=checkout_export.xls');
        echo $output;
    }
}
?>