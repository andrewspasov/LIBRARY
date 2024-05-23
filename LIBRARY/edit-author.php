<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auto-load.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author = new Author();
    $pdo = $author->connect();
    $authors = $author->getAuthors($pdo);
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="error text-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>Display Authors</h1>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Bio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($authors as $author) { ?>
                            <form action="update-author.php" method="POST">
                                <input type="hidden" name="action" value="edit">
                                <tr>
                                    <td><input required class="form-control" type="hidden" name="id" value="<?= $author['id'] ?>"><?= $author['id'] ?></td>
                                    <td><input required class="form-control" type="text" name="authorFirstName" value="<?= $author['first_name'] ?>"></td>
                                    <td><input required class="form-control" type="text" name="authorLastName" value="<?= $author['last_name'] ?>"></td>
                                    <td><textarea required class="form-control" type="text" name="authorBio" value="<?= $author['bio'] ?>"><?= $author['bio'] ?></textarea></td>
                                    <td class="d-flex justify-content-start">
                                        <button type="submit" class="btn btn-warning m-1">Edit</button>
                                    </td>
                                </tr>
                            </form>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>