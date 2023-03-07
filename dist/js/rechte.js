function userHasRole($role) {
    $db = mysqli_connect('localhost', 'root', '', 'ui');
    $username = $_SESSION['loggedin'];
    $query = "SELECT rolle FROM accounts WHERE username = '$username'";

    $result = mysqli_query($db, $query);
  
    if (mysqli_num_rows($result) > 0) {
      $user = mysqli_fetch_assoc($result);
      $userRole = $user['role'];
  
      if ($userRole == $role) {
        return true;
      }
    }
  
    return false;
  }