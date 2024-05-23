<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auto-load.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $connection = new Connection();
    $pdo = $connection->connect();

    $book = new Registration($pdo);
    $books = $book->getSingleBook($_POST['id']);


    $category = new Category();
    $pdo = $category->connect();
    $data = $category->getCategories($pdo);

    $author = new Author();
    $pdo = $author->connect();
    $authors = $author->getAuthors($pdo);
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

    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <h1>Edit a book</h1>
                <div class="col">

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Book Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Year Published</th>
                                <th scope="col">Number of Pages</th>
                                <th scope="col">Image URL</th>
                                <th scope="col">Category</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($books['id'])) : ?>
                                <form action="update-book.php" method="POST">
                                    <input type="hidden" name="action" value="edit">

                                    <tr>
                                        <td><input required class="form-control" type="hidden" name="id" value="<?= $books['id'] ?>"><?= $books['id'] ?></td>
                                        <td><input required class="form-control" type="text" name="bookTitle" value="<?= $books['title'] ?>"></td>

                                        <td><select id="selectNewAuthor" class="form-control" name="selectNewAuthor" required>
                                                <?php foreach ($authors as $author) { ?>
                                                    <option <?= $author['first_name'] == $books['first_name'] &&  $author['last_name'] == $books['last_name'] ? 'selected' : '' ?> value="<?= $author['id'] ?>"><?= $author['first_name'] . ' ' . $author['last_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td><input required class="form-control" type="number" name="yearPublished" value="<?= $books['year_published'] ?>"></td>
                                        <td><input required class="form-control" type="number" name="numberOfPages" value="<?= $books['number_of_pages'] ?>"></td>
                                        <td><input required class="form-control" type="text" name="bookImageUrl" value="<?= $books['img_url'] ?>"></td>
                                        <td><select id="selectNewCategory" class="form-control" name="selectNewCategory" required>
                                                <?php foreach ($data as $row) { ?>
                                                    <option <?= $row['category'] == $books['category'] ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['category'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="d-flex justify-content-between">
                                            <button type="submit" class="btn btn-warning">Edit</button>
                                </form>
                                </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>