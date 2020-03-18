<div class="card mb-4 border-warning">
    <div class="card-header bg-warning"><i class="fas fa-user mr-1"></i>Paneled Groups</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="PaneledGroupsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Group Thesis Title</th>
                        <th>Section</th>
                        <th>Professor</th>
                        
                    </tr>
                </thead>
                <tfoot>
                        <th>Group Thesis Title</th>
                        <th>Section</th>
                        <th>Professor</th>
                </tfoot>
                <tbody>
                    <?php
                        $panelChairG = DBHandler::GetGroupsOfFaculty($_SESSION['Account']->id, 2);
                        $panelistG = DBHandler::GetGroupsOfFaculty($_SESSION['Account']->id, 3);

                        if($panelChairG === NULL && $panelistG === NULL){
                            echo "<tr><td colspan = '4'>No groups assigned.</td></tr>";
                        }
                        else
                        {
                            if($panelChairG !== NULL){
                                foreach ($panelChairG as $pc) {
                                    $prof = DBHandler::GetGroupFaculty($pc->id, 4);
                                    echo "<tr>";
                                    ?>
                                        <td><?=$pc->title?></td>
                                        <td><?=$pc->section?></td>
                                        <td><?=$prof[0]->lastname.", ".$prof[0]->firstname?></td>
                                    <?php
                                    echo "</tr>";
                                }
                            }
                            if($panelistG !== NULL){
                                foreach ($panelistG as $pnl) {
                                    $prof = DBHandler::GetGroupFaculty($pnl->id, 4);
                                    echo "<tr>";
                                    ?>
                                        <td><?=$pnl->title?></td>
                                        <td><?=$pnl->section?></td>
                                        <td><?=$prof[0]->lastname.", ".$prof[0]->firstname?></td>
                                    <?php
                                    echo "</tr>";
                                }
                            }
                        }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>