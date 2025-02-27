<?php
class crud
{
    var $host = "localhost";
    var $username = "root";
    var $password = "";
    var $database = "goodshoes";

    function __construct()
    {
        $koneksi = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$koneksi) {
            echo "Koneksi db gagal.";
        }
    }

    // function
    function connect()
    {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        return $conn;
    }

    function insertUser($name, $email, $type, $password)
    {
        $conn = $this->connect();
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $arrResult = array(
            "result" => false,   // Boolean
            "message" => "Create User Failed.",   // Boolean
        );

        try {
            $stmt = $conn->prepare("INSERT INTO users (name, email, type, password) VALUES (?, ?, ?, ?)");
            if ($stmt === false) {
                $arrResult["message"] = "Error preparing statement: " . $conn->error;
            }
            $stmt->bind_param("ssss", $name, $email, $type, $password_hashed);
            $result = $stmt->execute();
            if ($result === false) {
                $arrResult["message"] = "Error preparing statement: " . $stmt->error;
            }

            // Check for affected rows (optional but good practice)
            if ($stmt->affected_rows > 0) {
                $arrResult["result"] = true;
                $arrResult["message"] = "User registered successfully!";
            } else {
                // Handle cases where no rows were inserted (e.g., duplicate entry)
                $arrResult["message"] = "Error: No user was registered.  Possible duplicate entry or other issue.";
            }

            $stmt->close(); // Close the statement

        } catch (Exception $e) {
            error_log($e->getMessage());
            $arrResult["message"] = "An error occurred during registration. Please try again later. " . $e->getMessage();
        } finally {
            // Close the connection (if it's not already closed elsewhere)
            if (isset($conn)) {
                $conn->close();
            }
        }

        return json_encode($arrResult);
    }

    function insertProduct($type, $merk, $nama, $kode_produk, $price, $image)
    {
        $conn = $this->connect();

        $arrResult = array(
            "result" => false,   // Boolean
            "message" => "Create Product Failed.",   // Boolean
        );

        try {
            $stmt = $conn->prepare("INSERT INTO products (type, merk, nama, kode_produk, price, image) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                $arrResult["message"] = "Error preparing statement: " . $conn->error;
            }
            $stmt->bind_param("ssssss", $type, $merk, $nama, $kode_produk, $price, $image);
            $result = $stmt->execute();
            if ($result === false) {
                $arrResult["message"] = "Error preparing statement: " . $stmt->error;
            }

            // Check for affected rows (optional but good practice)
            if ($stmt->affected_rows > 0) {
                $arrResult["result"] = true;
                $arrResult["message"] = "Product registered successfully!";
            } else {
                // Handle cases where no rows were inserted (e.g., duplicate entry)
                $arrResult["message"] = "Error: No product was registered.  Possible duplicate entry or other issue.";
            }

            $stmt->close(); // Close the statement

        } catch (Exception $e) {
            error_log($e->getMessage());
            $arrResult["message"] = "An error occurred during registration. Please try again later. " . $e->getMessage();
        } finally {
            // Close the connection (if it's not already closed elsewhere)
            if (isset($conn)) {
                $conn->close();
            }
        }

        return json_encode($arrResult);
    }

    function updateProduct($id, $type, $merk, $nama, $kode_produk, $price, $image)
    {
        $conn = $this->connect();

        $arrResult = array(
            "result" => false,   // Boolean
            "message" => "Create Product Failed.",   // Boolean
        );

        try {
            //query
            if (!empty($image)) {
                $stmt = $conn->prepare("UPDATE products SET type = ? , merk = ? , nama = ? , kode_produk = ?, price = ?, image = ? WHERE id = ?");
                if ($stmt === false) {
                    $arrResult["message"] = "Error preparing statement: " . $conn->error;
                }
                $stmt->bind_param("ssssisi", $type, $merk, $nama, $kode_produk, $price, $image, $id);
            } else {
                $stmt = $conn->prepare("UPDATE products SET type = ? , merk = ? , nama = ? , kode_produk = ?, price = ? WHERE id = ?");
                if ($stmt === false) {
                    $arrResult["message"] = "Error preparing statement: " . $conn->error;
                }
                $stmt->bind_param("ssssii", $type, $merk, $nama, $kode_produk, $price, $id);
            }


            $result = $stmt->execute();
            if ($result === false) {
                $arrResult["message"] = "Error preparing statement: " . $stmt->error;
            }

            // Check for affected rows (optional but good practice)
            if ($stmt->affected_rows > 0) {
                $arrResult["result"] = true;
                $arrResult["message"] = "Product updated successfully!";
            } else {
                // Handle cases where no rows were inserted (e.g., duplicate entry)
                $arrResult["message"] = "Error: No product was updated.";
            }

            $stmt->close(); // Close the statement

        } catch (Exception $e) {
            error_log($e->getMessage());
            $arrResult["message"] = "An error occurred during updating. Please try again later. " . $e->getMessage();
        } finally {
            // Close the connection (if it's not already closed elsewhere)
            if (isset($conn)) {
                $conn->close();
            }
        }

        return json_encode($arrResult);
    }

    function inserMessage($first_name, $last_name, $email, $phone, $subject, $message)
    {
        $conn = $this->connect();

        $arrResult = array(
            "result" => false,   // Boolean
            "message" => "Send Message Failed.",   // Boolean
        );

        try {
            $stmt = $conn->prepare("INSERT INTO message (first_name, last_name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                $arrResult["message"] = "Error preparing statement: " . $conn->error;
            }
            $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $subject, $message);
            $result = $stmt->execute();
            if ($result === false) {
                $arrResult["message"] = "Error preparing statement: " . $stmt->error;
            }

            // Check for affected rows (optional but good practice)
            if ($stmt->affected_rows > 0) {
                $arrResult["result"] = true;
                $arrResult["message"] = "Message sent successfully! Thank you.";
            } else {
                // Handle cases where no rows were inserted (e.g., duplicate entry)
                $arrResult["message"] = "Error: Message not sent.";
            }

            $stmt->close(); // Close the statement

        } catch (Exception $e) {
            error_log($e->getMessage());
            $arrResult["message"] = "An error occurred during saving the message. Please try again later. " . $e->getMessage();
        } finally {
            // Close the connection (if it's not already closed elsewhere)
            if (isset($conn)) {
                $conn->close();
            }
        }

        return json_encode($arrResult);
    }

    function getMessage()
    {
        $data = [];

        $conn = $this->connect();
        $sql = "SELECT first_name, last_name, email, phone, subject, message, timestamp FROM message";
        $result = $conn->query($sql);

        while ($row = $result->fetch_object()) {
            $data[] = $row; // Add each object to the array
        }

        $conn->close();

        return json_encode($data);
    }

    function updateUser($username, $email, $type, $password, $id)
    {
        $conn = $this->connect();
        $password_hashed = password_hash($password);
        $stmt = $conn->prepare("UPDATE username = ?, email = ?, type = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssss", $username, $email, $type, $password_hashed, $id);
        $stmt->execute();

        $isSuccess = false;
        if ($stmt->affected_rows == 1) {
            $isSuccess = true;
        }
        $stmt->close();
        $conn->close();

        return $isSuccess;
    }

    function showUsers()
    {
        $conn = $this->connect();
        $sql = "SELECT username, type FROM users";
        $result = $conn->query($sql);

        $conn->close();

        return $result;
    }


    function checkLogin($email, $password)
    {
        $conn = $this->connect();
        $sql = "SELECT password FROM users WHERE email = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $message = "Login failed.";
        $userFound = false;
        $loginResult = false;

        if ($result->num_rows == 1) { // Check for row result
            $userFound = true;
        } else {
            $message = "User email not found.";
        }

        if ($userFound) {
            $row = $result->fetch_assoc();
            $password_db = $row['password'];

            if (password_verify($password, $password_db)) {
                $loginResult = true;
                $message = "Login Success.";
            } else {
                $message = "Login failed. Please check your password.";
            }
        }


        $stmt->close();
        $conn->close();

        //
        $arrResult = array(
            "result" => $loginResult,   // Boolean
            "message" => $message,   // Boolean
        );

        //return true/false result
        return json_encode($arrResult);
    }

    function getName($email)
    {
        $conn = $this->connect();
        $sql = "SELECT name FROM users WHERE email = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $name = "User Unknown";
        $userFound = false;

        if ($result->num_rows == 1) { // Check for row result
            $userFound = true;
        }

        if ($userFound) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
        }


        $stmt->close();
        $conn->close();

        //return true/false result
        return $name;
    }

    function getUserType($email)
    {
        $conn = $this->connect();
        $sql = "SELECT type FROM users WHERE email = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $type = "user";
        $userFound = false;

        if ($result->num_rows == 1) { // Check for row result
            $userFound = true;
        }

        if ($userFound) {
            $row = $result->fetch_assoc();
            $type = $row['type'];
        }

        $stmt->close();
        $conn->close();

        //return true/false result
        return $type;
    }

    function getProductBrands()
    {
        $data = [];

        $conn = $this->connect();
        $sql = "SELECT DISTINCT merk FROM products";
        $result = $conn->query($sql);

        while ($row = $result->fetch_object()) {
            $data[] = $row; // Add each object to the array
        }

        $conn->close();

        return json_encode($data);
    }


    function getProductType()
    {
        $data = [];

        $conn = $this->connect();
        $sql = "SELECT DISTINCT type FROM products";
        $result = $conn->query($sql);

        while ($row = $result->fetch_object()) {
            $data[] = $row; // Add each object to the array
        }

        $conn->close();

        return json_encode($data);
    }

    function getProducts()
    {
        $data = [];

        $conn = $this->connect();
        $sql = "SELECT id, type, merk, nama, kode_produk, price, image FROM products";
        $result = $conn->query($sql);

        while ($row = $result->fetch_object()) {
            $data[] = $row; // Add each object to the array
        }

        $conn->close();

        return json_encode($data);
    }

    function getProductDetail($id)
    {
        $data = [];

        $conn = $this->connect();

        $sql = "SELECT type, merk, nama, kode_produk, price, image FROM products WHERE id = ? ;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_object()) {
            $data[] = $row; // Add each object to the array
        }

        $conn->close();

        return json_encode($data);
    }

    function deleteProduct($id)
    {
        $data = [];

        $conn = $this->connect();

        $sql = "DELETE FROM products_variants WHERE id_product = ? ;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();


        $sql = "DELETE FROM products WHERE id = ? ;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $arrResult = array(
            "result" => true,   // Boolean
            "message" => "Delete Product Success.",   // Boolean
        );
        $conn->close();

        return json_encode($arrResult);
    }

    function getProductVariant($id)
    {
        $data = [];

        $conn = $this->connect();

        $sql = "SELECT pv.size, pv.warna, pv.stock FROM products_variants pv WHERE id_product = ? ORDER BY pv.size ASC;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_object()) {
            $data[] = $row; // Add each object to the array
        }

        $conn->close();

        return json_encode($data);
    }

    function getProductsLatest4()
    {
        $data = [];

        $conn = $this->connect();
        $sql = "SELECT id, type, merk, nama, kode_produk, price, image FROM products ORDER BY id DESC LIMIT 4";
        $result = $conn->query($sql);

        while ($row = $result->fetch_object()) {
            $data[] = $row; // Add each object to the array
        }

        $conn->close();

        return json_encode($data);
    }

    function getGallery()
    {
        $data = [];

        $conn = $this->connect();
        $sql = "SELECT id, image FROM gallery";
        $result = $conn->query($sql);

        while ($row = $result->fetch_object()) {
            $data[] = $row; // Add each object to the array
        }

        $conn->close();

        return json_encode($data);
    }
}