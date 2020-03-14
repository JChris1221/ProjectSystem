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

                <!-- Admin Only -->
                <?php if($_SESSION['Account']->roleid == 1){ ?>
                    <div class="sb-sidenav-menu-heading">Manage</div>
                  
                    <a class="nav-link" href=<?=RelativeLink("AccountManagement/ManageAccounts.php")?>>
                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                        Accounts
                    </a>

                    <a class="nav-link" href=<?=RelativeLink("GroupManagement/ManageGroups.php")?>>
                        <div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>
                        Groups
                    </a>
                <?php } ?>
                <!-- /Admin Only -->

                <!-- Faculty -->
                <?php if($_SESSION['Account']->roleid == 2){ ?>
                    <div class="sb-sidenav-menu-heading">Groups</div>
                    <a class="nav-link" href=<?=RelativeLink("GroupEvaluation/GroupEvaluation.php")?>>
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                        Evaluate Groups
                        
                    </a>
                    <a class="nav-link" href=<?=RelativeLink("AdviserMonitor/ManageAccounts.php")?>>
                        <div class="sb-nav-link-icon"><i class="fas fa-hands-helping"></i></div>
                        Advised Groups
                        
                    </a>
                     <a class="nav-link" href=<?=RelativeLink("AdviserMonitor/ManageAccounts.php")?>>
                        <div class="sb-nav-link-icon"><i class="fas fa-book-reader"></i></div>
                        Thesis Students
                    </a>
                <?php } ?>
                <!-- /Faculty -->
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?= $_SESSION["Account"]->rolename ?>
        </div>
    </nav>
</div>