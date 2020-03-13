<div class="card mb-4 border-info">
    <div class="card-header bg-info"><i class="fas fa-user mr-1"></i>Advised Groups</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="AdvisedGroupsTable" width="100%" cellspacing="0">
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
                        $advisedGroups = DBHandler::GetGroupsOfFaculty($_SESSION['Account']->id, 1);
                        if($advisedGroups === NULL){
                            echo "<tr><td colspan = '4'>No accounts yet.</td></tr>";
                        }
                        else
                        {
                            foreach ($advisedGroups as $ag) {
                                $prof = DBHandler::GetGroupFaculty($ag->id, 4);
                                echo "<tr>";
                                ?>
                                    <td><?=$ag->title?></td>
                                    <td><?=$ag->section?></td>
                                    <td><?=$prof[0]->lastname.", ".$prof[0]->firstname?></td>
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