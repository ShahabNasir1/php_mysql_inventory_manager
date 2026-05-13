<?php
// check name length and empty
function validateText($value, $min = 3)
{
    $value = trim($value);
    if (empty($value)) return "Field is required.";
    if (strlen($value) < $min) return "Must be at least $min characters.";
    return true;
}

// check duplication 
function isDuplicate($conn, $table, $column, $value)
{
    if ($pageName == "editCategory" || $pageName == "editBrand") {
        $id = intval($_GET['id']);
        $query = "SELECT $column FROM $table WHERE $column = '$value' AND id != $id";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            return false; // No duplicate, safe to update
        } else {
            return true;  // Duplicate exists, cannot update
        }
    } 
    
    else {

        // duplicate check for new add
        $query = "SELECT $column FROM $table WHERE $column = '$value'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            return true;  // Duplicate exists
        } else {
            return false; // No duplicate
        }
    }
}

function insertRecord($conn, $table, $data)
{
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Record Added Successfully!</div>";
    }
}

function updateRecord($conn, $table, $data, $id)
{
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";
    $sql = "UPDATE $table SET $columns = $values WHERE id = $id";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Record Updated Successfully!</div>";
        echo "<script>window.location.href='category/listCategories.php';</script>";
        exit;
    }
}

function deleteRecord($conn, $table, $id)
{
    $sql = "DELETE FROM $table WHERE id = $id";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Record Deleted Successfully!</div>";
        echo "<script>window.location.href='category/listCategories.php';</script>";
        exit;
    }
}


function processImageUpload($file, $targetDir = "uploads/")
{
    if (!isset($file)) {
        if (empty($file["name"])) return ["error" => "Please select an image."];

        $fileName   = basename($file["name"]);
        $extension  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $uniqueName = time() . "_" . $fileName;
        $targetPath = $targetDir . $uniqueName;
        $thumbPath  = $targetDir . "thumb_" . $uniqueName;

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $allowed)) return ["error" => "Invalid file type."];

        if (move_uploaded_file($file["tmp_name"], $targetPath)) {
            // Thumbnail Logic
            $src = null;
            if ($extension == 'jpg' || $extension == 'jpeg') $src = imagecreatefromjpeg($targetPath);
            elseif ($extension == 'png') $src = imagecreatefrompng($targetPath);
            elseif ($extension == 'gif') $src = imagecreatefromgif($targetPath);

            if ($src) {
                $thumb = imagecreatetruecolor(50, 50);
                if ($extension == 'png' || $extension == 'gif') {
                    imagealphablending($thumb, false);
                    imagesavealpha($thumb, true);
                }
                list($w, $h) = getimagesize($targetPath);
                imagecopyresampled($thumb, $src, 0, 0, 0, 0, 50, 50, $w, $h);

                if ($extension == 'jpg' || $extension == 'jpeg') imagejpeg($thumb, $thumbPath, 80);
                elseif ($extension == 'png') imagepng($thumb, $thumbPath);
                elseif ($extension == 'gif') imagegif($thumb, $thumbPath);

                imagedestroy($src);
                imagedestroy($thumb);
            }
            return ["success" => true, "path" => $targetPath];
        }
        return ["error" => "Upload failed."];
    }
}

// Centralized alert function
function displayAlert($messages, $type = "warning")
{
    $messages = (array)$messages;
    foreach ($messages as $msg) {
        $icon = ($type == "success") ? "fa-check-circle" : "fa-exclamation-triangle";
        echo "<div class='alert alert-$type'><i class='fa $icon'></i> $msg</div>";
    }
}
