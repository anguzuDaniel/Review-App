<?php


function isLoggedIn()
{
    return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
}

function requireLogin()
{
    if (!isLoggedIn()) {
        die('unathorized user');
    }
}

function login()
{
    // helps to prevent session fixation attack | stops hackers from stealing session data
    session_regenerate_id(true);

    $_SESSION['is_logged_in'] = true;
}

function logout()
{
    $_SESSION = array();

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}


function redirect($path)
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        $protocol = 'https';
    } else {
        $protocol = 'http';
    }
    header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . $path);
    exit;
}

/**
 * getAllBooks
 *
 * @param  mixed $conn
 * @param  mixed $column
 * @return array
 */
function getAllBooks($conn, $column = '*')
{
    $sql = "SELECT $column FROM book";

    $stmt = $conn->prepare($sql);

    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function getBookById($conn, $id, $column = '*')
{
    $sql = "SELECT $column FROM book WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
}

function deleteBookById($conn, $id)
{
    $sql = "DELETE FROM book WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $id);

    $stmt->execute();
}

function updateBook($conn, $id, $name, $author, $image, $file, $description, $category)
{
    $sql = "UPDATE book SET 
            name = :name, 
            author = :author,  
            image = :image, 
            file = :file, 
            description = :description, 
            category = :category 
            WHERE id = :id ";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':file', $file);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':category', $category);

    $stmt->execute(array(
        ':id' => $id,
        ':name' => $name,
        ':author' => $author,
        ':image' => $image,
        ':file' => $file,
        ':description' => $description,
        ':category' => $category
    ));
}

/**
 * getBooksLimit
 *
 * @param  mixed $conn
 * @param  mixed $limit
 * @param  mixed $columns
 * @return void
 */
function getBooksLimit($conn, $limit, $columns = "*")
{
    $sql = "SELECT $columns FROM book ORDER BY id DESC LIMIT $limit ";

    $stmt = $conn->prepare($sql);

    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

/**
 * getAllCategories
 *
 * @param  mixed $conn
 * @param  mixed $columns
 * @return array
 */
function getAllCategories($conn, $columns = "*")
{
    $sql = "SELECT $columns FROM category ORDER BY name DESC ";

    $stmt = $conn->prepare($sql);

    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

/**
 * addBook
 *
 * @param  mixed $conn
 * @param  mixed $name
 * @param  mixed $author
 * @param  mixed $image
 * @param  mixed $file
 * @param  mixed $description
 * @param  mixed $category
 * @return array
 */
function addBook($conn, $name, $author, $image, $file, $description, $category)
{
    $sql = "INSERT INTO `book` (`id`, `name`, `author`, `image`, `file`, `description`, `category`) 
    VALUES (NULL, :name, :author, :image,  :file, :description, :category)  ";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':file', $file);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':category', $category);

    return  $stmt->execute();
}

function createUser($conn, $email, $name, $password)
{
    $sql = "INSERT INTO user(email, name, password) 
            VALUES (:name, :email, :password)  ";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':name', $name);

    $p = password_hash($password, PASSWORD_BCRYPT);

    $stmt->bindParam(':password', $p);

    $stmt->execute(array(':name' => $name, ':email' => $email, ':password' => $password));
}

function getAllUsers($conn, $column = "*")
{
    $sql = "SELECT $column FROM `user`";

    $stmt = $conn->prepare($sql);

    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function authenticateUser($conn, $email, $password)
{
    $sql = 'SELECT * FROM user WHERE email = :email ';

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':email', $email, PDO::PARAM_STR);

    $stmt->execute();

    if ($user = $stmt->fetch()) {
        return password_verify($password, $user['password']);
    }
}

function checkUserEmail($conn, $email)
{
    $sql = 'SELECT * 
                FROM user
                WHERE email = :email ';

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':email', $email, PDO::PARAM_STR);

    $stmt->execute();

    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function getUser($conn, $id, $column = "*")
{
    $sql = "SELECT $column FROM user WHERE id = $id ";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

/**
 * formValidation
 * 
 * @param  mixed $name
 * @param  mixed $author
 * @param  mixed $image
 * @param  mixed $files
 * @param  mixed $description
 * @param  mixed $category
 * @return void
 */
function formValidation($name, $author, $image, $pdf_file, $description, $category)
{

    $errors = [];

    if ($name == "") {
        $errors[] = "Book name cannot be left empty";
    }

    if ($author == "") {
        $errors[] = "Author name cannot be left empty";
    }

    if ($pdf_file == "") {
        $errors[] = "Please provide a pdf file";
    }

    if ($image == "") {
        $errors[] = "Please provide an Book cover";
    }

    if ($description == "") {
        $errors[] = "Book description cannot be left empty";
    }

    if ($category == "") {
        $errors[] = "Category cannot br left empty";
    }

    return $errors;
}

function validationUserForm($user_email, $username, $user_password, $confirm_password)
{

    $errors = [];

    if ($user_email == "") {
        $errors[] = "Book name cannot be left empty";
    }

    if ($username == "") {
        $errors[] = "Author name cannot be left empty";
    }

    if ($user_password == "") {
        $errors[] = "Please provide a pdf file";
    }

    if ($confirm_password == "") {
        $errors[] = "Please provide an Book cover";
    }

    return $errors;
}

function validationUserLoginForm($email, $password)
{

    $errors = [];

    if ($email == "") {
        $errors[] = "Book name cannot be left empty";
    }

    if ($password == "") {
        $errors[] = "Please provide a pdf file";
    }

    return $errors;
}
