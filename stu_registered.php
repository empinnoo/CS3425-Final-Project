<html>
    <body>
        <?php include 'stu_sidebar.html'; ?>
        <style>
            body {
                margin-top: 5%;
                margin-left: 20%;
            }
        </style>
        <h1>Courses</h1>
        <div class="currentCourses">
            <form method = "post" >
                <table>
                    <tbody>
                        <?php
                            foreach ($TAGS as $TAGS) {
                                echo'<tr>';
                                echo'<td>'.$TAGS['tagName'].'<td>';
                                echo '<td><input type="submit" value="x" class="edit-btn" name = "deleteInterest" /><td>';
                                echo'<tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
        <h1>Survey Status</h1>
    </body>
</html>