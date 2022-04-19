<html>
    <body>
        <form method=post action=quiz.php>
            <div class="q1">
                <p>Q1: The pace of this course</p>
                <input type="radio" value="A" name="1">
                <label for="A">A: is too slow</label><br>
                <input type="radio" value="B" name="1">
                <label for="B">B: is just right</label><br>
                <input type="radio" value="C" name="1">
                <label for="C">C: is too fast</label><br>
                <input type="radio" value="D" name="1">
                <label for="D">D: I don't know</label><br>
            </div>
    
            <div class="q2">
                <p>Q2: The feedback from homework assignment grading</p>
                <input type="radio" value="A" name="2">
                <label for="A">A: too few</label><br>
                <input type="radio" value="B" name="2">
                <label for="B">B: sufficient</label><br>
                <input type="radio" value="C" name="2">
                <label for="C">C: I don't know</label><br>
            </div>
    
            <div class="q3">
                <p>Q3: Any thing you like about the teaching of this course?</p>
                <input type="text" name="3">
            </div>
    
            <div>
                <input type="submit" value ="Submit" name="submit">
            </div>
        </form>
    </body>
</html>
<?php
    if (isset($_POST["submit"])) {
        $q1 = $_POST['1'];
        $q2 = $_POST['2'];
        $q3 = $_POST['3'];
        echo "<p> Your answers are:<br>1: $q1<br>2: $q2<br>3: $q3 </p>";
    }
?>