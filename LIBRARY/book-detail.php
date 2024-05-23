<?php
session_start();


require_once __DIR__ . '/auto-load.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $connection = new Connection();
    $pdo = $connection->connect();

    $book = new Registration($pdo);
    $bookId = $_GET['id'];
    $bookDetails = $book->getSingleBook($bookId);
}

$userLoggedIn = isset($_SESSION['username']);

if (isset($_SESSION['error_message'])) {
    echo '<div class="error text-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}

if (isset($_SESSION['success_message'])) {
    echo '<div class="error text-success">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $registration = new Registration($pdo);
    $userComments = $registration->getCommentsByUserIdAndBookId($userId, $bookId);

    $note = new Note($pdo);
    $userNotes = $note->getNotesByBookIdAndUserId($bookId, $userId);
}
$registration = new Registration($pdo);

$comments = $registration->getApprovedCommentsByBookId($bookId);






?>

<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <!-- Latest compiled and minified Bootstrap 4.6 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">


</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <?php if (isset($_SESSION['username'])) { ?>
                <a class="navbar-brand" href="user-dashboard.php">Welcome <?= $_SESSION['username'] ?></a>
            <?php } ?>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php if ($userLoggedIn) { ?>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Hi there!
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        <?php } ?>
                        </li>
                    </ul>
                </div>
        </nav>
    </div>
    <div class="container pt-5">
        <div class="row">
            <div class="col-6">
                <img src="<?= $bookDetails['img_url'] ?>" class="card-img-top" alt="img">
                <div class="card-body">
                    <h5 class="card-title"><?= $bookDetails['title'] ?></h5>
                    <p class="card-text">Author: <?= $bookDetails['first_name'] . ' ' . $bookDetails['last_name'] ?></p>
                    <p class="card-text">Year Published: <?= $bookDetails['year_published'] ?></p>
                    <p class="card-text">Pages: <?= $bookDetails['number_of_pages'] ?></p>
                    <p class="btn btn-light">Category: <?= $bookDetails['category'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php if ($userLoggedIn) { ?>
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <h3>Voice your opinion!</h3>
                    <form action="leave-comment.php" method="POST">
                        <label for="newComment">Write your comment here:</label>
                        <textarea required type="text" class="form-control" id="newComment" name="newComment"></textarea>
                        <input type="hidden" name="bookId" value="<?= $bookId ?>">
                        <button type="submit" class="btn btn-dark mt-2">Comment</button>
                    </form>
                </div>
            </div>
        </div>



    <?php } ?>

    <div class="container py-5">
        <div class="row">
            <div class="col">
                <?php if ($userLoggedIn) { ?>
                    <?php foreach ($userComments as $comment) { ?>
                        <form action="delete-comment.php" method="POST">
                            <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                            <input type="hidden" name="bookId" value="<?= $bookId ?>">
                            <p>Your Comment: <?= $comment['comment'] ?></p>
                            <p>Status: Not yet approved</p>
                            <button type="submit" class="btn btn-danger m-1">Delete Comment</button>
                        </form>

                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col">
                <?php foreach ($comments as $comment) { ?>
                    <p>Comment by <?= $comment['username'] ?> : <?= $comment['comment'] ?></p>
                <?php } ?>
            </div>
        </div>
    </div>


    <?php if ($userLoggedIn) { ?>




        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <h3>Add Private Note</h3>
                    <form id="noteForm">
                        <input type="hidden" name="bookId" id="bookId" value="<?= $bookDetails['id'] ?>">
                        <div class="form-group">
                            <label for="noteContent">Write your private note:</label>
                            <textarea class="form-control" id="noteContent" name="noteContent" rows="3"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="addNote()">Add Note</button>
                    </form>
                </div>
            </div>
            <div id="noteMessage" class="mt-2"></div>
        </div>


        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <?php if ($userLoggedIn || !empty($userNotes)) { ?>
                        <h3>Your Private Notes</h3>
                        <ul id="userNotesList">
                            <?php foreach ($userNotes as $userNote) { ?>
                                <li>
                                    <span><?= $userNote['note'] ?></span>
                                    <button class="btn btn-sm btn-warning mx-2" onclick="editNote(<?= $userNote['id'] ?>)">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteNote(<?= $userNote['id'] ?>)">Delete</button>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>




    <?php } ?>



    <div class="container py-5">
        <div class="row">
            <div class="col">
                <footer class="text-center font-weight-bold" id="quoteFooter">
                    Loading quote...
                </footer>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="ha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  -->

    <!-- Include jQuery library -->
    <script src="main.js"></script>
    <script src="ajax.js"></script>

    <script></script>
</body>

</html>