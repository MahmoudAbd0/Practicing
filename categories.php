<?php
include "./db_connection.php";
include "./layout/header.php";
include "./layout/footer.php";


?>
<h1>Categories</h1>
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>image</th>
        </tr>
    </thead>
    <tbody>
        <?php $sql = 'select * from categories';
        $result = $db->query($sql);
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td>
                    <?php echo $row['id']; ?>
                </td>
                <td>
                    <?php echo $row['name']; ?>
                </td>

                <td>
                    <a href="<?php echo $row['image']; ?>">view image</a>
                </td>

                <td>
                    <?php if (!empty($row['image']) && file_exists($row['image'])) {
                        echo "<img src='" . $row['image'] . "' alt='image' style='width:50px'>";
                    } ?>
                </td>
            </tr>
        <?php   } ?>



    </tbody>

</table>