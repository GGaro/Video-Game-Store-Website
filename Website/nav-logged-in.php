<a class="navbar-brand" href="profile.php"><img src="images/main/profile.svg" title="Profile" width="100" height="100"
                class="d-inline-block align-text-top"></a>
<a class="navbar-brand" href="" onclick="return confirmLogout();"><img src="images/main/logout.svg" title="Logout"
                width="100" height="100" class="d-inline-block align-text-top"></a>

<?php
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
if ($userid !== null) {
        if ($userid == 'admin') { // add this check for admin
                echo '<a class="navbar-brand" href="admin.php"><img src="images/main/admin.svg" title="Admin" width="100" height="100" class="d-inline-block align-text-top"></a>';
        }
        echo '<script>
        function confirmLogout() {
                if (confirm("Are you sure you want to log out? (All data will be lost)")) {
                        fetch("logout.php")
                                .then(response => {
                                        if (response.ok) {
                                                window.location.href = "index.php";
                                        } else {
                                                alert("Failed to log out");
                                        }
                                })
                                .catch(error => {
                                        alert("Failed to log out");
                                });
                        return false;
                } else {
                        return false;
                }
        }
        </script>';
}
?>