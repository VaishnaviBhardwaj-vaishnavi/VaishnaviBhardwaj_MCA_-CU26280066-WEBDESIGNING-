<!DOCTYPE html>
<html>
<head>
    <title>Online Bookstore</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">BookStore</a>

        <div>
            <a href="index.php" class="text-white me-3">Home</a>
            <a href="books.php" class="text-white me-3">Books</a>
            <a href="cart.php" class="text-white me-3">Cart</a>
            <a href="login.php" class="text-white">Login</a>
        </div>
    </div>
</nav>

<div class="banner">
    <h1>Welcome to Online Bookstore</h1>
    <p>Discover your next favourite book!</p>
    <a href="books.php" class="btn btn-warning">Shop Now</a>
</div>

<div class="container mt-5">

    <h2 class="text-center">Featured Books</h2>

    <form action="books.php" method="GET" class="my-4">
        <input type="text" name="search"
               class="form-control"
               placeholder="Search books by title or author">

        <button class="btn btn-primary mt-2">
            Search
        </button>
    </form>

    <div class="row text-center">

        <div class="col-md-4">
            <div class="category">
                <h4>Fiction</h4>
                <a href="books.php?category=Fiction">Explore</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="category">
                <h4>Technology</h4>
                <a href="books.php?category=Technology">Explore</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="category">
                <h4>Education</h4>
                <a href="books.php?category=Education">Explore</a>
            </div>
        </div>

    </div>

    <div class="promotion mt-5">
        <h2>Special Offer!</h2>
        <p>Get 20% discount on selected books.</p>
    </div>

</div>

<footer class="bg-dark text-white text-center p-3 mt-5">
    Copyright © 2026 Online Bookstore
</footer>

</body>
</html>