<div class="card mb-4 border-info">
    <div class="card-header bg-info"><i class="fas fa-user mr-1"></i>Accounts</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="AccountsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Role</th>
                </tfoot>
                <tbody>
                    <?php
                        $accounts = DBHandler::GetAccounts($_SESSION["Account"]->id);
                        if($accounts === NULL){
                            echo "<tr><td colspan = '4'>No accounts yet.</td></tr>";
                        }
                        else
                        {
                            foreach ($accounts as $a) {
                                echo "<tr>";
                                ?>
                                    <td><?=$a->firstname?></td>
                                    <td><?=$a->lastname?></td>
                                    <td><?=$a->username?></td>
                                    <td><?=$a->rolename?></td>
                                <?php
                                echo "</tr>";
                            }
                        }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>