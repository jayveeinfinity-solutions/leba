<script type="text/javascript">
	/* Open when someone clicks on the span element */
	function openNav() {
	    document.getElementById("myNav").style.width = "100%";
	}

	/* Close when someone clicks on the "x" symbol inside the overlay */
	function closeNav() {
	    document.getElementById("myNav").style.width = "0%";
	}
</script>
<div id="myNav" class="overlay">

	<!-- Button to close the overlay navigation -->
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

	<!-- Overlay content -->
	<div class="overlay-content">
	<div class="ib_dev">
		<?php
			$findavatar = 'storage/users/avatar/' . IB_User::getUserData('AV') . '">';
			if (file_exists($findavatar) && !empty(IB_User::getUserData('AV'))) {
				echo '<img class="ib_dev_avatar" src="storage/users/avatar/' . IB_User::getUserData('AV') . '">';
			} elseif (!file_exists($findavatar) && empty(IB_User::getUserData('AV'))) {echo '<img class="ib_dev_avatar" src="storage/users/avatar/default.jpg">';
			} else {
				echo '<img class="ib_dev_avatar" src="storage/users/avatar/default.jpg">';
			}
		?>
	</div>
	<form action="" method="POST" enctype="multipart/form-data">
		<h3 class="ib_dev_name">
			<input class="ib_dev_input" type="file" name="image" style="width: 60%;">
			<button style="padding: 10px 20px; float: none;" class="ib_dev_high_btn" name="update_avatar" value="1">Upload Avatar</button>
		</h3>
		<h5 class="ib_dev_sub"><i class="fa fa-exclamation-circle"></i> Avatar maximum file size must be 2 MB and in GIF, JPG, and PNG image format &sdot; Better to upload 256 x 256 dimension</h5>
		</div>
		<?php
		    if (isset($_POST['update_avatar'])) {
		    	$_SESSION['avatar_message'] = array();
        		$keyid = IB_User::checkUser();
			    $avatarEXT = array("gif", "jpeg", "jpg", "png");
			    $temp = explode(".", $_FILES["image"]["name"]);
			    $extension = end($temp);
			    if ((($_FILES["image"]["type"] == "image/gif")
			    	|| ($_FILES["image"]["type"] == "image/jpeg")
			    	|| ($_FILES["image"]["type"] == "image/jpg")
			    	|| ($_FILES["image"]["type"] == "image/pjpeg")
			    	|| ($_FILES["image"]["type"] == "image/x-png")
			    	|| ($_FILES["image"]["type"] == "image/png"))
			    	&& ($_FILES["image"]["size"] < 2097152)) {
			        if ($_FILES["image"]["error"] > 0) {
       					header('location: ' . $_SERVER['PHP_SELF'] . '?am=2');
			        } else {
						$checkAvatar = IB_Database::IB_Query("SELECT u_avatar FROM `" . IB_User::getTable() . "` WHERE u_id = '$keyid'");
						$row = mysqli_fetch_array($checkAvatar, MYSQLI_BOTH);
						$file = 'storage/users/avatar/' . $row['u_avatar'];
						if (file_exists($file) && !is_null($row['u_avatar'])) {
							$file_av = explode('.', $row['u_avatar']);
							$file_new_av = explode('_', $file_av[0]);
							$file_val = end($file_new_av);
							if ($keyid === $file_val) {
								unlink($file);
								$newAvatar = IB_Token::generateToken('NUMERIC', 16) . '_' . $keyid . '.' . end($temp);
			            		move_uploaded_file($_FILES["image"]["tmp_name"], "storage/users/avatar/" . $newAvatar);
			            		IB_Database::IB_Query("UPDATE `" . IB_User::getTable() . "` SET u_avatar = '$newAvatar' WHERE u_id = '$keyid'");
       							header('location: ' . $_SERVER['PHP_SELF'] . '?am=3');
							}
						} else {
							$newAvatar = IB_Token::generateToken('NUMERIC', 16) . '_' . $keyid . '.' . end($temp);
		            		move_uploaded_file($_FILES["image"]["tmp_name"], "storage/users/avatar/" . $newAvatar);
		            		IB_Database::IB_Query("UPDATE `" . IB_User::getTable() . "` SET u_avatar = '$newAvatar' WHERE u_id = '$keyid'");
		       					header('location: ' . $_SERVER['PHP_SELF'] . '?am=3');
						}
			        }
			    } else {
       				header('location: ' . $_SERVER['PHP_SELF'] . '?am=1');
			    }
			}
		?>
	</form>
</div>