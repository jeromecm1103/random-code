<?php
/**
    Code for fun only.
    Scenario : 
        set of prisoner, with assigned number based of their index.
        they need to find their number from random set of numbers
        within a limited number of attempt

    tried solution :
        let say prisoner 0 has a random number of 15
            the current prisoner will have to pick index 15 to get a new number
            if the number is equal to prisoners index - success
            else the prisoner need to pick another number(base of index equal to last picked number)
 */

?>

<style>
    th, td{border:1px solid;}
</style>
<?php 
    $number_of_batch = 100;
    $batch_result = [];
    $number_of_prisoner = 100;
    $attempt = 50;
?>

<?php for($x = 0; $x < $number_of_batch; $x++): ?>
    <h3>Batch : <?= $x+1 ?> </h3>
    <?php 
        $number_of_prisoner = 100;
        $attempt = 50;
        $precint = [];
        for($i = 0; $i  < $number_of_prisoner; $i++):
            $randnumber  = rand(0, $number_of_prisoner);
            do{
                $randnumber  = rand(0, $number_of_prisoner-1); // 0-99 = 100 number
            }while(in_array($randnumber, $precint));

            $precint[] = $randnumber;
        endfor;
    ?>
        <table>
            <tbody>
                <?php foreach($precint as $key=>$value): ?>
                    <?php if( ($key)%10 == 0): ?>
                        <tr>
                    <?php endif; ?>
                        <td >
                            <span style="color:red;">No. : <?= $key ?></span>
                            <br>
                            <span><?= $value ?></span>
                        </td>
                    <?php if(($key+1)%10 == 0): ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>


    <!-- Part where prisoner pick a number -->
    <?php 
        $statusprisoner = [];

        for($i = 0; $i< $number_of_prisoner; $i++):
            $status = 0; // 0 failed, 1 success
            $current_attempt = 1;
            $current_number = $precint[$i];

            while($status == 0){
            
                if($current_number == $i){
                    $status = 1;
                }else{
                    $current_number = $precint[$current_number];
                    $current_attempt++;
                }
            }
            if($current_attempt <= $attempt){
                $statusprisoner['Scaped'][] = [
                    'PrisonerNo' => $i,
                    'Attempt'    => $current_attempt
                ];
            }else{ 
                $statusprisoner['Captured'][] = [
                    'PrisonerNo' => $i,
                    'Attempt'    => $current_attempt
                ];
            }
        endfor;
    ?>
    <table hidden>
        <tbody>
            
                <?php if(!empty($statusprisoner['Scaped'])):?>
                    <tr>
                        <th>
                            <span>Scaped Prisoner <?= count($statusprisoner['Scaped']) ?>:</span>
                            <br>
                            <!-- <span>Attempt :</span> -->
                        </th>
                        <?php foreach($statusprisoner['Scaped'] as $value): ?>
            
                            <td>
                                <span><?= $value['PrisonerNo']; ?></span>
                                <br>
                                <!-- <span><?= $value['Attempt']; ?></span> -->
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td>No prisoner scaped!</td>
                    </tr>
                <?php endif; ?>
        </tbody>
    </table>

    <table hidden>
        <tbody>
            
                <?php if(!empty($statusprisoner['Captured'])):?>
                    <tr>
                        <th>
                            <span>Captured Prisoner <?= count($statusprisoner['Captured']) ?> :</span>
                            <br>
                            <!-- <span>Attempt :</span> -->
                        </th>
                        <?php foreach($statusprisoner['Captured'] as $value): ?>
            
                            <td>
                                <span><?= $value['PrisonerNo']; ?></span>
                                <br>
                                <!-- <span><?= $value['Attempt']; ?></span> -->
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td>No prisoner captured!</td>
                    </tr>
                <?php endif; ?>
        </tbody>
    </table>

 <?php $batch_result[] = [
                    'Batch' => $x+1,
                    'Scaped' => !empty($statusprisoner['Scaped']) ? count($statusprisoner['Scaped']) : 0,
                    'Captured' => !empty($statusprisoner['Captured']) ? count($statusprisoner['Captured']) : 0,                    
                        ];
 ?>
<?php endfor; ?>

<table>
    <tbody>
        <tr>
            <th>
                Batch
                <br>
                Scaped/Captured
            </th>
            <?php foreach($batch_result as $result): ?>
                <td>
                    <span><?= $result['Batch'] ?></span>
                    <br>
                    <span><?= $result['Scaped'] ?>/<?= $result['Captured'] ?></span>
                </td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>


<?php 
$chance_of_success = 0;
$chance_of_failure = 0;
    foreach($batch_result as $result):
        if($result['Captured'] == 0){
            $chance_of_success++;
        }else{
            $chance_of_failure++;
        }
    endforeach;
?>
<h3>Chance of Success : <?= ($chance_of_success/$number_of_batch) * 100 ?>%</h3>
<h3>Chance of Failure : <?= ($chance_of_failure/$number_of_batch) * 100 ?>%</h3>

<?php
    function display($data){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
?>