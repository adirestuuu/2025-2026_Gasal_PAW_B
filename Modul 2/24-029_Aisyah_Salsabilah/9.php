<form name="form1" method="get">
    input berapa nilai? <input type="number" name="jumlah">
    <input type ="submit" value="kirim">
</form>

<form name method="get">
    <?php
    if(isset($_GET['jumlah'])){
        $a = $_GET['jumlah'];
        for($i=1; $i<=$a; $i++){
            echo "nilai $i : <input type='number' name='nilai$i'><br>";
        }

        echo "<input type='hidden' name='jumlah' value='$a'>";
        echo "<input type='submit' value='kirim'>";
    }
    if(isset($_GET['nilai1'])){
        $a = isset($_GET['jumlah']) ? (int)$_GET['jumlah'] : 0;
        $total = 0;
        for($i=1; $i<=$a; $i++){
            $nilai = $_GET["nilai$i"];
            $total += $nilai;
        }
        if($a > 0){
            $rata = $total / $a;
            echo "Rata-rata nilai: $rata<br>";
  
            if($rata >= 85 && $rata <= 100){
                $grade = 'A';
            } elseif($rata >= 70 && $rata < 85){
                $grade = 'B';
            } elseif($rata >= 56 && $rata < 70){
                $grade = 'C';
            } elseif($rata >= 40 && $rata < 56){
                $grade = 'D';
            } else {
                $grade = 'E';
            }
            echo "Grade: $grade";
        } else {
            echo "Jumlah nilai tidak valid.";
        }
    }
    ?>