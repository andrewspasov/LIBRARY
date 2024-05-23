<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auto-load.php';

$connection = new Connection();

$category = new Category();
$pdo = $category->connect();
$data = $category->getCategories($pdo);


$book = new Registration($pdo);
$books = $book->getAllBooks($pdo);
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Welcome!</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a href="register-form.php" class="nav-link">Register here</a>
            </div>
            <div class="navbar-nav">
                <a href="login-form.php" class="nav-link">Log in here</a>
            </div>
        </div>
    </nav>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Book Categories Filter</title>
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="" method="" id="categoryFilterForm">
                        <h5 class="py-5">Select categories to have them listed</h5>
                        <div class="d-flex">
                            <?php foreach ($data as $row) { ?>
                                <div class="form-group form-check px-2 mx-2">
                                    <input type="checkbox" class="form-check-input category-checkbox" id="<?= $row['category'] ?>">
                                    <label class="form-check-label" for="<?= $row['category'] ?>"><?= $row['category'] ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container pt-5">
            <div class="row" id="bookContainer">
                <?php foreach ($books as $book) { ?>
                    <a class="card col-3 offset-1 my-3 book-card <?= $book['category'] ?>" href="book-detail.php?id=<?= $book['id'] ?>">
                        <img src="<?= $book['img_url'] ?>" class="card-img-top" alt="img">
                        <div class="card-body">
                            <h5 class="card-title"><?= $book['title'] ?></h5>
                            <p class="card-text">Author: <?= $book['first_name'] . ' ' . $book['last_name'] ?></p>
                            <span class="btn btn-light">Category: <?= $book['category'] ?></span>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.category-checkbox');

                const bookCards = document.querySelectorAll('.book-card');

                checkboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        filterBooks();
                    });
                });

                function filterBooks() {
                    const selectedCategories = Array.from(checkboxes)
                        .filter(checkbox => checkbox.checked)
                        .map(checkbox => checkbox.id);

                    bookCards.forEach(function(card) {
                        const bookCategories = card.classList;

                        if (selectedCategories.length === 0 || selectedCategories.some(category => bookCategories.contains(category))) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }
            });
        </script>

    </body>

    </html>




    <div class="container py-5">
        <div class="row">
            <div class="col">
                <footer class="text-center font-weight-bold" id="quoteFooter">
                    Loading quote...
                </footer>
            </div>
        </div>
    </div>

    <script src="main.js"></script>

</html>