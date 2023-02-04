<?php

session_start();

require_once("db.php");

$limit = 4;

if(isset($_GET["page"])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

$start_from = ($page-1) * $limit;

$sql = "SELECT * FROM oglasi_za_posao LIMIT $start_from, $limit";
$result = $conn->query($sql);
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$sql1 = "SELECT * FROM poslodavac WHERE id_company='$row[id_company]'";
              $result1 = $conn->query($sql1);
              if($result1->num_rows > 0) {
                while($row1 = $result1->fetch_assoc()) 
                {
             ?>

            <div class="attachment-block clearfix">
              <img class="attachment-img"  src="uploads/logo/<?php echo $row1['logo']; ?>" alt="Attachment Image">
              <div class="attachment-pushed">
                <h4 class="attachment-text">Poslodavac : <?php echo $row1["name"]  ?></h4> 
                <h4 class="attachment-heading"><a href="pogledaj-poslove.php?id=<?php echo $row['id_jobpost']; ?>"><?php echo $row['jobtitle']; ?></a> <span class="attachment-heading pull-right"><?php echo $row['maximumsalary']; ?> RSD/ Mesecno</span></h4>
                <div class="attachment-text">
                    <div><strong><?php echo $row1['imefirme']; ?> | <?php echo $row1['grad']; ?> | Radno Iskustvo <?php echo $row['experience']; ?>   
                    <?php if ($row['experience'] == 1 || $row['experience'] == 5) {
                      echo "Godina";
                    } else if ($row['experience'] > 1) {
                      echo "Godine";
                    } ?></strong></div>
                </div>
              </div>
            </div>

		<?php
			}
		}
	}
}

$conn->close();