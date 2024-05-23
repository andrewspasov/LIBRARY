<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auto-load.php';


if (!isset($_SESSION['username'])) {
    header('Location: homepage.php');
    die();
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="error text-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}

if (isset($_SESSION['success_message'])) {
    echo '<div class="error text-success">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

$connection = new Connection();
$pdo = $connection->instance;


$category = new Category();
$pdo = $category->connect();
$data = $category->getCategories($pdo);

$author = new Author();
$pdo = $author->connect();
$authors = $author->getAuthors($pdo);

$book = new Registration($pdo);
$books = $book->getAllBooks($pdo);

$comment = new Comment();
$pdo = $comment->connect();
$comments = $comment->getAllComments($pdo);


$approvedComment = new ApprovedComment();
$pdo = $comment->connect();
$approvedComments = $approvedComment->getAllApprovedComments($pdo);

$users = new Registration($pdo);
$pdo = $users->connect();
$users = $users->getAllUsers();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>


<body>

    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Managing Library</a>
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
    <div class="container-fluid pt-5">
        <div class="row">
            <div class="col">
                <h1>Add a new category</h1>
                <form action="insert-category.php" method="POST">
                    <label for="newCategory">Insert a new book category here:</label>
                    <input required type="text" class="form-control" id="newCategory" name="newCategory">
                    <button type="submit" class="btn btn-dark mt-2">Insert Category</button>
                </form>
            </div>
            <div class="col">
                <h1>Display categories</h1>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Category</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) { ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['category'] ?></td>
                                <td class="d-flex justify-content-start">
                                    <form method="POST" action="update-category.php">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-danger m-1">Delete</button>
                                    </form>
                                    <form method="POST" action="edit-category.php">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-warning m-1">Edit</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-5">
        <div class="row">
            <div class="col">
                <h1>Adding Authors</h1>
                <form action="insert-author.php" method="POST">
                    <label for="newAuthorName">Insert a new author name here:</label>
                    <input required type="text" class="form-control" id="newAuthorName" name="newAuthorName">
                    <label for="newAuthorSurname">Insert a new author surname here:</label>
                    <input required type="text" class="form-control" id="newAuthorSurname" name="newAuthorSurname">
                    <label for="newAuthorBio">Insert a new author bio here:</label>
                    <textarea required name="newAuthorBio" id="newAuthorBio" class="form-control"></textarea>
                    <button type="submit" class="btn btn-dark mt-2">Insert Author</button>
                </form>
            </div>
            <div class="col">
                <h1>Display authors</h1>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Bio</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($authors as $author) { ?>
                            <tr>
                                <td><?= $author['id'] ?></td>
                                <td><?= $author['first_name'] ?></td>
                                <td><?= $author['last_name'] ?></td>
                                <td><?= $author['bio'] ?></td>
                                <td class="d-flex justify-content-start">
                                    <form method="POST" action="update-author.php">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $author['id'] ?>">
                                        <button type="submit" class="btn btn-danger m-1">Delete</button>
                                    </form>
                                    <form method="POST" action="edit-author.php">
                                        <input type="hidden" name="id" value="<?= $author['id'] ?>">
                                        <button type="submit" class="btn btn-warning m-1">Edit</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <div class="container bg-light p-5">
        <div class="row">
            <div class="col">
                <h1 class="text-center py-5">Add a new book here</h1>
                <form action="insert-book.php" method="POST">
                    <div class="form-group pb-2">
                        <label for="newBookTitle">Book Title:</label>
                        <input type="text" class="form-control" id="newBookTitle" name="newBookTitle" required>
                    </div>
                    <div class="form-group pb-2">
                        <label for="newBookYearPublished">Year of publishing:</label>
                        <input type="number" class="form-control" id="newBookYearPublished" name="newBookYearPublished" required>
                    </div>
                    <div class="form-group pb-2">
                        <label for="newBookNumberOfPages">Number of pages:</label>
                        <input type="number" class="form-control" id="newBookNumberOfPages" name="newBookNumberOfPages" required>
                    </div>
                    <div class="form-group pb-2">
                        <label for="newBookImage">Book Image URL:</label>
                        <input type="text" class="form-control" id="newBookImage" name="newBookImage" required>
                    </div>
                    <div class="form-group pb-2">
                        <label for="selectAuthor">Author:</label>
                        <select id="selectAuthor" class="form-control" name="selectAuthor" required>
                            <option selected disabled value="">Please, select an author!</option>
                            <?php foreach ($authors as $author) { ?>

                                <option value="<?= $author['id'] ?>"><?= $author['first_name'] . " " . $author['last_name'] ?></option>

                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group pb-2">
                        <label for="selectCategory">Category:</label>
                        <select id="selectCategory" class="form-control" name="selectCategory" required>
                            <option selected disabled value="">Please, select a book category!</option>
                            <?php foreach ($data as $row) { ?>

                                <option value="<?= $row['id'] ?>"><?= $row['category'] ?></option>

                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="mt-5 pb-1 pt-1 btn btn-primary btn-lg btn-block" value="Submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <h1 class="text-center pb-5">Display Books</h1>
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
                        <?php foreach ($books as $book) { ?>
                            <tr>
                                <td><?= $book['id'] ?></td>
                                <td><?= $book['title'] ?></td>
                                <td><?= $book['first_name'] . ' ' . $book['last_name'] ?></td>
                                <td><?= $book['year_published'] ?></td>
                                <td><?= $book['number_of_pages'] ?></td>
                                <td><?= $book['img_url'] ?></td>
                                <td><?= $book['category'] ?></td>

                                </td>
                                <td class="d-flex justify-content-between">
                                    <form method="POST" action="update-book.php" id="deleteBookForm">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $book['id'] ?>">
                                        <button type="submit" class="btn btn-danger" id="deleteBookButton">Delete</button>
                                    </form>
                                    <form action="edit-book.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $book['id'] ?>">
                                        <button type="submit" class="btn btn-warning">Edit</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="container py-5">
        <h1 class="py-5">Handling comments</h1>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Book</th>
                            <th scope="col">User</th>
                            <th scope="col">Approved</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <h3 class="py-5">Pending comments</h3>
                    <?php foreach ($comments as $comment) { ?>
                        <tr>
                            <td><?= $comment['id'] ?></td>
                            <td><?= $comment['comment'] ?></td>
                            <td><?= $comment['title'] ?></td>
                            <td><?= $comment['username'] ?></td>
                            <td><?= $comment['is_approved'] == 1 ? 'Approved' : 'Not Approved' ?></td>

                            </td>
                            <td class="d-flex justify-content-between">
                                <form method="POST" action="update-comments.php">
                                    <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Book</th>
                            <th scope="col">User</th>
                            <th scope="col">Approved</th>
                        </tr>
                    </thead>
                    <h3 class="py-5">Approved comments</h3>
                    <?php foreach ($approvedComments as $approvedComment) { ?>
                        <tr>
                            <td><?= $approvedComment['id'] ?></td>
                            <td><?= $approvedComment['comment'] ?></td>
                            <td><?= $approvedComment['title'] ?></td>
                            <td><?= $approvedComment['username'] ?></td>
                            <td><?= $approvedComment['is_approved'] == 1 ? 'Approved' : 'Not Approved' ?></td>

                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>


    <div class="container py-5">
        <div class="row">
            <div class="col">
                <h3>Manage Permissions</h3>
                <h6>List of users:</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Email</th>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['surname'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['role'] ?></td>
                            <td class="d-flex justify-content-between">
                                <form method="POST" action="make-admin.php">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn btn-info">Make Admin</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
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

</body>

<script>
    const deleteButton = document.getElementById('deleteBookButton');

    deleteButton.addEventListener('click', function(event) {
        event.preventDefault();

        const form = document.getElementById('deleteBookForm');

        if (form) {
            showConfirmation(form);
        } else {
            console.error('Form element not found.');
        }
    });

    function showConfirmation(form) {
        Swal.fire({
            title: "Double-check",
            text: "Are you sure you want to delete this book?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            } else {
                console.log('Form submission canceled.');
            }
        });
    }
</script>

</html>