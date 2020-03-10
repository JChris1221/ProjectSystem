<?php
require_once ("CreateRelativeLink.php");
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Home</div>
                <a class="nav-link" href=<?= RelativeLink("index.php")?>
                    ><div class="sb-nav-link-icon"><i class="fas fa-home"></i></i></div>
                    Dashboard</a
                >
                <div class="sb-sidenav-menu-heading">View</div>
                <?php 
                    if($_SESSION['Account']->roleid == 1){
                ?>
                        <a class="nav-link" href=<?=RelativeLink("AccountManagement/ModifyAccounts.php")?>>
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Accounts
                        </a>
                <?php } #ENDIF ?>

                <a class="nav-link disabled" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Schedules
                </a>
                <a class="nav-link" href=<?=RelativeLink("GroupManagement/ManageGroups.php")?>>
                    <div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>
                    Groups
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?= $_SESSION["Account"]->rolename ?>
        </div>
    </nav>
</div>