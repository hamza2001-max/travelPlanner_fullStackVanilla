<?php
require_once './includes/nav.php';
require_once './includes/database.php';
$dest_name = $_GET["dest_name"];
$target_dir = "./staticModels/";
$sql_query_landmark = "SELECT * FROM landmark WHERE dest_name = '$dest_name'";
$sql_query_destination = "SELECT * FROM destination WHERE dest_name = '$dest_name'";
$result_landmark = mysqli_query($connection, $sql_query_landmark);
$result_destination = mysqli_query($connection, $sql_query_destination);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/f34a5d3160.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <div id="destinationDetails">
        <?php
        if ($result_landmark->num_rows > 0 && $result_destination->num_rows > 0) {
            while ($row_destination = mysqli_fetch_assoc($result_destination)) {
                $destination_target_image = $target_dir . $row_destination["dest_image"];
        ?>
                <div class="destinationDetailsContainer">
                    <div class="imageContainer">
                        <img src="<?= $destination_target_image ?>" alt=<?= $row_destination['dest_name'] ?> class="largeImage" />
                        <?php
                        while ($row_landmark = mysqli_fetch_assoc($result_landmark)) {
                            $landmark_target_image = $target_dir . $row_landmark["land_image"];
                        ?>
                            <div>
                                <img src="<?= $landmark_target_image ?>" class="smallImage" onclick="toggleDetail(<?= $row_landmark['land_id'] ?>)" />
                                <div class="landmarkDetails" id="destinationDetail<?= $row_landmark["land_id"] ?>" >
                                    <img src="<?= $landmark_target_image ?>" />
                                    <i class="fa-solid fa-xmark" onclick="toggleDetail(<?= $row_landmark['land_id'] ?>)"></i>
                                    <div>
                                        <div>
                                            <h3>Visit</h3>
                                            <h3><?= $row_landmark['land_name'] ?></h3>
                                        </div>
                                        <p><?= $row_landmark['land_description'] ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                    <div class="rightSection">
                        <div class="viewButton">
                            <button id="overviewBtn">Overview</button> / <button id="descriptionBtn">Description</button>
                        </div>
                        <div class="textContainer overview">
                            <h1 style="margin-bottom: 1.5rem"><?= $row_destination['dest_name'] ?></h1>
                            <h1>$<?= $row_destination['dest_cost'] ?></h1>
                            <ul class="landmarkList">
                                <?php
                                mysqli_data_seek($result_landmark, 0);
                                while ($row_landmark = mysqli_fetch_assoc($result_landmark)) {
                                ?>
                                    <li><?= $row_landmark["land_name"] ?></li>
                                <?php } ?>
                            </ul>
                            <button class="bookButton">Book now</button>
                        </div>
                        <div class="textContainer description" style="display:none;">
                            <p><?= $row_destination['dest_description'] ?></p>
                        </div>
                    </div>
                </div>
        <?php                    }
        } ?>
    </div>
    </div>
</body>
<script src="destinationDetails.js" type="module"></script>
</html>
<?php require_once './includes/footer.php'?>
