<?php

/*********************************
 *
 * FUNCTIONS RELATED TO SUBJECTS
 *********************************/

// Find all subjects
function find_all_subjects($options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM subjects ";
    if ($visible) {
        $sql .= "WHERE visible = true ";
    }
    $sql .= "ORDER BY position ASC";
    $result = mysqli_query($db, $sql);
    confirm_result($result);
    return $result;
}

// Find a subject by ID
function find_subject_by_id($id, $options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM subjects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";
    if ($visible) {
        $sql .= "AND visible = true ";
    }
    $result = mysqli_query($db, $sql);
    confirm_result($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject; // Return assoc array
}

// Insert subject
function insert_subject($subject)
{
    global $db;

    $errors = validate_subject($subject);
    if (!empty($errors)) {
        return $errors;
    }

    shift_subject_positions(0, $subject['position']);

    $sql = "INSERT INTO subjects ";
    $sql .= "(menu_name, position, visible) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $subject['menu_name']) . "',";
    $sql .= "'" . db_escape($db, $subject['position']) . "',";
    $sql .= "'" . db_escape($db, $subject['visible']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For insert statements result is True or False
    if ($result) {
        return true;
    } else {
        // Insert Failed
        echo mysqli_errno($db);
        db_dissconnect($db);
        exit();
    }
}

// Update subject
function update_subject($subject)
{
    global $db;

    $errors = validate_subject($subject);
    if (!empty($errors)) {
        return $errors;
    }
    $old_subject = find_subject_by_id($subject['id']);
    $old_position = $old_subject['position'];
    shift_subject_positions($old_position, $subject['position'], $subject['id']);

    $qry = "UPDATE subjects SET ";
    $qry .= "menu_name='" . db_escape($db, $subject['menu_name']) . "', ";
    $qry .= "position='" . db_escape($db, $subject['position']) . "', ";
    $qry .= "visible='" . db_escape($db, $subject['visible']) . "' ";
    $qry .= "WHERE id='" . db_escape($db, $subject['id']) . "' ";
    $qry .= "LIMIT 1";

    $result = mysqli_query($db, $qry);

    // For UPDATE statement , $result is true or false
    if ($result) {
        return true;
    } else {
        // Update Failed
        echo mysqli_error($db);
        db_dissconnect($db);
        exit();
    }
}

// Delete Subject
function delete_subject($id)
{
    global $db;
    $old_subject = find_subject_by_id($id);
    $old_position = $old_subject['position'];
    shift_subject_positions($old_position, 0, $id);

    $sql = "DELETE FROM subjects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Validate subject
function validate_subject($subject)
{
    $errors = [];

    // menu_name
    if (is_blank($subject['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    } elseif (!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    // position
    // Make sure we are working with an integer
    $postion_int = (int)$subject['position'];
    if ($postion_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }
    if ($postion_int > 999) {
        $errors[] = "Position must be less than 999.";
    }

    // visible
    // Make sure we are working with a string
    $visible_str = (string)$subject['visible'];
    if (!has_inclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be true or false.";
    }

    return $errors;
}

// shift subject positions
function shift_subject_positions($start_pos, $end_pos, $current_id = 0)
{

    global $db;

    if($start_pos == $end_pos) { return; }

    $sql = "UPDATE subjects ";
    if($start_pos == 0) {
        // new item, +1 to items greater than $end_pos
        $sql .= "SET position = position + 1 ";
        $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
    } elseif($end_pos == 0) {
        // delete item, -1 from items greater than $start_pos
        $sql .= "SET position = position - 1 ";
        $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
    } elseif($start_pos < $end_pos) {
        // move later, -1 from items between (including $end_pos)
        $sql .= "SET position = position - 1 ";
        $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
        $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
    } elseif($start_pos > $end_pos) {
        // move earlier, +1 to items between (including $end_pos)
        $sql .= "SET position = position + 1 ";
        $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
        $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
    }
    // Exclude the current_id in the SQL WHERE clause
    $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

/*********************************
 *
 * FUNCTIONS RELATED TO PAGES
 *********************************/

// Find all pages
function find_all_pages()
{
    global $db;
    $sql = "SELECT * FROM pages ";
    $sql .= "ORDER BY subject_id ASC, position ASC";
    $result = mysqli_query($db, $sql);
    confirm_result($result);
    return $result;
}

// Find a page by ID
function find_page_by_id($id, $options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";
    if ($visible) {
        $sql .= "AND visible = true ";
    }
    $result = mysqli_query($db, $sql);
    confirm_result($result);
    $page = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $page; // Return assoc array
}

// Validate page
function validate_page($page)
{
    $errors = [];

    // subject_id
    if (is_blank($page['subject_id'])) {
        $errors[] = "Subject cannot be blank.";
    }

    // menu_name
    if (is_blank($page['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    } elseif (!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }
    $current_id = $page['id'] ?? '0';
    if (!has_unique_page_menu_name($page['menu_name'], $current_id)) {
        $errors[] = "Menu name must be unique";
    }

    // position
    // Make sure we are working with an integer
    $postion_int = (int)$page['position'];
    if ($postion_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }
    if ($postion_int > 999) {
        $errors[] = "Position must be less than 999.";
    }

    // visible
    // Make sure we are working with a string
    $visible_str = (string)$page['visible'];
    if (!has_inclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be true or false.";
    }

    // content
    if (is_blank($page['content'])) {
        $errors[] = "Content cannot be blank.";
    }

    return $errors;
}

// Insert a page
function insert_page($page)
{
    global $db;
    $errors = validate_page($page);
    if (!empty($errors)) {
        return $errors;
    }

    shift_page_positions(0, $page['position'], $page['subject_id']);

    $sql = "INSERT INTO pages ";
    $sql .= "(subject_id, menu_name, position, visible, content) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $page['subject_id']) . "',";
    $sql .= "'" . db_escape($db, $page['menu_name']) . "',";
    $sql .= "'" . db_escape($db, $page['position']) . "',";
    $sql .= "'" . db_escape($db, $page['visible']) . "',";
    $sql .= "'" . db_escape($db, $page['content']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Update a page
function update_page($page)
{
    global $db;

    $errors = validate_page($page);
    if (!empty($errors)) {
        return $errors;
    }

    $old_page = find_page_by_id($page['id']);
    $old_position = $old_page['position'];
    shift_page_positions($old_position, $page['position'], $page['subject_id'], $page['id']);

    $sql = "UPDATE pages SET ";
    $sql .= "subject_id='" . db_escape($db, $page['subject_id']) . "', ";
    $sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "', ";
    $sql .= "position='" . db_escape($db, $page['position']) . "', ";
    $sql .= "visible='" . db_escape($db, $page['visible']) . "', ";
    $sql .= "content='" . db_escape($db, $page['content']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }

}

// Delete a page
function delete_page($id)
{
    global $db;

    $old_page = find_page_by_id($id);
    $old_position = $old_page['position'];
    $old_subject_position = $old_page['subject_id'];
    shift_page_positions($old_position, 0, $old_subject_position,  $id);

    $sql = "DELETE FROM pages ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Find a page by subject ID
function find_pages_by_subject_id($subject_id, $options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
    if ($visible) {
        $sql .= "AND visible = true ";
    }
    $sql .= "ORDER BY position ASC";
    $result = mysqli_query($db, $sql);
    confirm_result($result);
    return $result; // Return assoc array
}

// Count page by subject ID
function count_pages_by_subject_id($subject_id, $options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT COUNT(*) FROM pages ";
    $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
    if ($visible) {
        $sql .= "AND visible = true ";
    }
    $result = mysqli_query($db, $sql);
    confirm_result($result);
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $count = $row[0];
    return $count; // Return assoc array
}

// shift subject positions
function shift_page_positions($start_pos, $end_pos, $subject_id, $current_id = 0)
{

    global $db;

    if($start_pos == $end_pos) { return; }

    $sql = "UPDATE pages ";
    if($start_pos == 0) {
        // new item, +1 to items greater than $end_pos
        $sql .= "SET position = position + 1 ";
        $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
    } elseif($end_pos == 0) {
        // delete item, -1 from items greater than $start_pos
        $sql .= "SET position = position - 1 ";
        $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
    } elseif($start_pos < $end_pos) {
        // move later, -1 from items between (including $end_pos)
        $sql .= "SET position = position - 1 ";
        $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
        $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
    } elseif($start_pos > $end_pos) {
        // move earlier, +1 to items between (including $end_pos)
        $sql .= "SET position = position + 1 ";
        $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
        $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
    }
    // Exclude the current_id in the SQL WHERE clause
    $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
    $sql .= "AND subject_id = '" . db_escape($db, $subject_id) . "' ";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

/*********************************
 *
 * FUNCTIONS RELATED TO ADMINS
 *********************************/

// Find all subjects
function find_all_admins()
{
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "ORDER BY last_name ASC, first_name ASC";
    $result = mysqli_query($db, $sql);
    confirm_result($result);
    return $result;
}

// Validate admin
function validate_admin($admin, $options)
{
    $errors = [];

    $password_required = $options['password_required'] ?? true;

    // first_name
    if (is_blank($admin['first_name'])) {
        $errors[] = "First name cannot be blank.";
    } elseif (!has_length($admin['first_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "First name must be between 2 and 255 characters.";
    }

    // last_name
    if (is_blank($admin['last_name'])) {
        $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($admin['last_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Last name must be between 2 and 255 characters.";
    }

    // email
    if (is_blank($admin['email'])) {
        $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($admin['email'])) {
        $errors[] = "Invalid email address.";
    } elseif (has_length_greater_than($admin['email'], 255)) {
        $errors[] = "Email must be less than 255 characters.";
    }

    // username
    if (is_blank($admin['username'])) {
        $errors[] = "Username cannot be blank.";
    } elseif (!has_length($admin['username'], ['min' => 8, 'max' => 255])) {
        $errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!has_unique_admin_username($admin['username'], $admin['id'] ?? 0)) {
        $errors[] = "Username must be unique.";

    }

    if ($password_required) {
        // password
        if (is_blank($admin['password'])) {
            $errors[] = "Password cannot be blank.";
        } elseif (!has_length($admin['password'], array('min' => 12))) {
            $errors[] = "password must be more than 12 characters.";
        } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
            $errors[] = "Password must contain at least 1 uppercase letter";
        } elseif (!preg_match('/[a-z]/', $admin['password'])) {
            $errors[] = "Password must contain at least 1 lowercase letter";
        } elseif (!preg_match('/[0-9]/', $admin['password'])) {
            $errors[] = "Password must contain at least 1 number";
        } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
            $errors[] = "Password must contain at least 1 symbol";
        }

        // confirm_password
        if (is_blank($admin['confirm_password'])) {
            $errors[] = "Confirm password cannot be blank.";
        } elseif ($admin['password'] !== $admin['confirm_password']) {
            $errors[] = "Password and confirm password must match.";
        }
    }

    return $errors;
}

// Insert admin
function insert_admin($admin)
{
    global $db;

    $errors = validate_admin($admin);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['email']) . "',";
    $sql .= "'" . db_escape($db, $admin['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For insert statements result is True or False
    if ($result) {
        return true;
    } else {
        // Insert Failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

// Update admin

function update_admin($admin)
{
    global $db;

    $password_sent = !is_blank($admin['password']);

    $errors = validate_admin($admin, ['password_required' => $password_sent]);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE admins SET ";
    $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "', ";

    if ($password_sent) {
        $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "',";
    }
    $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Find an admin by ID
function find_admin_by_id($id)
{
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // Return assoc array
}

// Delete Admin
function delete_admin($id)
{
    global $db;

    $sql = "DELETE FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Find an admin by ID
function find_admin_by_username($username)
{
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // Return assoc array
}

?>