<div class="card mb-4 border-warning">
    <div class="card-header bg-warning"><i class="fas fa-user-friends mr-1"></i>Groups</div>
    <div class="card-body"> <div class="table-responsive">
        <table class="table table-bordered" id="GroupsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Thesis Title</th>
                        <th>Adviser</th>
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
                                $adviser = DBHandler::GetGroupFaculty($g->id, 1);
                                echo "<tr>";
                                ?>
                                    <td><?=$g->title?></td>
                                    <td><?=$adviser[0]->lastname.", ".$adviser[0]->firstname?></td>
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