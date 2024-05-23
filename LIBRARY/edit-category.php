<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auto-load.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = new Category();
    $pdo = $category->connect();
    $data = $category->getCategories($pdo);
}

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
        <div class="row">
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
                            <form action="update-category.php" method="POST" id="editCategoryForm">
                                <input type="hidden" name="action" value="edit">
                                <tr>
                                    <td><input class="form-control" type="hidden" name="id" value="<?= $row['id'] ?>"><?= $row['id'] ?></td>
                                    <td><input class="form-control" type="text" name="category" value="<?= $row['category'] ?>"></td>
                                    <td class="d-flex justify-content-start">
                                        <button type="submit" class="btn btn-warning m-1" id="editCategoryButton">Edit</button>
                                    </td>
                                </tr>
                            </form>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const editButton = document.getElementById('editCategoryButton');

        editButton.addEventListener('click', function(event) {
            event.preventDefault();

            const form = document.getElementById('editCategoryForm');

            if (form) {
                showConfirmation(form);
            } else {
                console.error('Form element not found.');
            }
        });

        function showConfirmation(form) {
            Swal.fire({
                title: "Double-check",
                text: "Are you sure you want to edit this category?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: 'Yes, edit it!',
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

</body>

</html>