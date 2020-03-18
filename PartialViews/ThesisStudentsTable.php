<div class="card mb-4 border-secondary">
    <div class="card-header bg-secondary"><i class="fas fa-user mr-1"></i>Thesis Students</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="ThesisStudentsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Group Thesis Title</th>
                        <th>Section</th>
                        <th>Adviser</th>
                    </tr>
                </thead>
                <tfoot>
                        <th>Group Thesis Title</th>
                        <th>Section</th>
                        <th>Adviser</th>
                </tfoot>
                <tbody>
                    <?php
                        $studentGroups = DBHandler::GetGroupsOfFaculty($_SESSION['Account']->id, 4);

                        if($studentGroups === NULL){
                            echo "<tr><td colspan = '4'>No groups assigned.</td></tr>";
                        }
                        else
                        {
                            foreach ($studentGroups as $sg) {
                                $adv = DBHandler::GetGroupFaculty($sg->id, 1);
                                echo "<tr>";
                                ?>
                                    <td><?=$sg->title?></td>
                                    <td><?=$sg->section?></td>
                                    <td><?=$adv[0]->lastname.", ".$adv[0]->firstname?></td>
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