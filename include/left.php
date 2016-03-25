<html>
 <div class="leftpanel">
        <div class="leftmenu">        
            <ul class="nav nav-tabs nav-stacked">
                <?php
                    if($_SESSION['user'] == "admin") {
                ?>
            	        <li class="nav-header">Navigation</li>
                        <li><a href="dashboard.php"><span class="iconfa-laptop"></span> Dashboard</a></li>
                        <li><a href="change-password.php"><span class="iconfa-pencil"></span> Change Password</a></li>
                        <li><a href="all_users.php?detail"><span class="iconfa-user"></span>Manage Users</a></li>
                        <li><a href="manageGroups.php"><span class="iconfa-pencil"></span> Manage Groups</a></li>
                        <li><a href="manageProducts.php"><span class="iconfa-pencil"></span> Manage Products</a></li>  
				        <li><a href="managePages.php"><span class="iconfa-pencil"></span>Manage Pages</a></li>
				        <li><a href="manageprofile.php"><span class="iconfa-pencil"></span>Manage Application Profile</a></li>
				        <li><a href="manageprice.php"><span class="iconfa-pencil"></span>Manage Price</a></li>
				        <li><a href="logout.php"><span class="iconfa-off"></span>Logout</a></li>
                <?php
                    }
                    if($_SESSION['user'] == "manuser") {
                ?>
                        <li class="nav-header">Navigation</li>
                        <li><a href="dashboard.php"><span class="iconfa-laptop"></span> Dashboard</a></li>
                        <li><a href="all_users.php?detail"><span class="iconfa-user"></span>Manage Users</a></li>
                        <li><a href="logout.php"><span class="iconfa-off"></span>Logout</a></li>
                <?php 
                    }
                ?>
               


			   <!-- <li><a href="logout.php"><span class="icon-exit"></span>Logout</a></li>  -->
            </ul>
        </div><!--leftmenu-->
        
    </div><!-- leftpanel -->
    </html>