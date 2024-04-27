<?php

$select = mysqli_query($conn, "SELECT * FROM Users WHERE id='$user_id'");
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
    $username = $fetch['username'];
    if (isset($_SESSION['status'])) { ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> <span class='text-light font-weight-bold'><?php echo $fetch['username'] ?></span><span class="text-light ml-2"><?php echo $_SESSION['status']; ?></span> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
<?php
        unset($_SESSION['status']);
    }
}
?>