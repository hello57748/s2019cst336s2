<!DOCTYPE html>
<html>
    <head>
        <title> </title>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>number</th>
                    <th>odd/even</th>   
                </tr>
            </thead>
            <tbody>
<?php
    $sum = 0;
    for ($i=0; $i<9; $i++) {
        $num = rand(0, 1000);
        $oddEven = ($num % 2) ? "odd" : "even";
        $sum = $sum + $num;
        echo "<tr><td>$num</td><td>$oddEven</td></tr>";
    }
    $avg = $sum / 9;
?>
            </tbody>
        </table>
<?php
    echo "<div><label>SUM:</label><span>$sum</span></div>";
    echo "<div><label>AVG:</label><span>$avg</span></div>";
?>
    </body>
</html>