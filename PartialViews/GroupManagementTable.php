<div class="card mb-4 border-warning">
    <div class="card-header bg-warning"><i class="fas fa-user-friends mr-1"></i>Groups</div>
    <div class="card-body"> <div class="table-responsive">
        <table class="table table-bordered" id="GroupsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Thesis Title</th>
                        <th>Section</th>
                        <th>Professor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $groups = DBHandler::GetGroups();

                        if($groups === NULL){
                            echo "<tr><td colspan = '4'>No accounts yet.</td></tr>";
                        }
                        else
                        {

                            foreach ($groups as $g) {
                                $prof = DBHandler::GetGroupFaculty($g->id, 4);
                                echo "<tr>";
                                ?>
                                    <td><?=$g->title?></td>
                                    <td><?=$g->section?></td>
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