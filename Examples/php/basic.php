<!DOCTYPE html>
<html>
    <head>
        <title> </title>
    </head>
    <body>
    <?php
    
        function isOdd($n) {
            if ($n % 2 == 0) return false;
            return true;
        }
    
        echo "<!-- This is a comment written in PHP -->";
        $n = 20943;
        $n = number_format($n,2); 
        echo "<div>$n</div>";
        
        $n = rand(5,15);   
        echo $n  . "<br><br>";
        
        $n = "hElLo WoRlD!";
        echo strtoupper($n)  .  "<br><br>";
        
        
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $n = rand(1, 1000);
            if (isOdd($n)) {
                echo "<div>$n odd</div>";
            }
            else {
                echo "<div>$n even</div>";
            }
            $sum += $n;
        }
        echo "<div>sum: $sum</div>";
        $avg = $sum/9;
        echo "<div>avg: $avg</div>";
        
    ?>
    </body>
</html>