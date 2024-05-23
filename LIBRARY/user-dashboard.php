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
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <?php if (isset($_SESSION['username'])) { ?>
                <a class="navbar-brand" href="#">Welcome <?= $_SESSION['username'] ?></a>
            <?php } ?>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hi there!
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>


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
        <!-- jQuery library -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="ha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

        <!-- Latest Compiled Bootstrap 4.6 JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


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







</html>