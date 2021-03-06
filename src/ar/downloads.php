<div id="downloads">
  <?php
  if(count($this->ds) === 0){
    echo ser("No Downloads", "Why don't you download some stuff ?");
  }else{
    foreach($this->ds as $dName){
      $dInfo = $this->data->getArray($dName);
      $percentage = $dInfo['percentage'];
      $status = $dInfo['status'];
    ?>
      <div class='card' data-id="<?php echo $dName;?>" <?php
      if($status === "completed" && $dInfo['paused'] == "0"){
        echo "data-active='1'";
      }
      if($dInfo["resumable"] === "0"){
        echo " data-notresumable";
      }
      ?>>
        <div class='card-content'>
          <span class="card-title truncate" title="<?php echo $dInfo['url'];?>"><?php echo $dInfo['url'];?></span>
          <p>
            <div class="progress">
              <div class="determinate" style="width: <?php echo $percentage;?>%"></div>
            </div>
            <blockquote><?php echo $dInfo['downloadDir'] . DIRECTORY_SEPARATOR . $dInfo['fileName'];?></blockquote>
            <div class="download-info">
              <?php
              if($dInfo["resumable"] === "0"){
              ?>
                <div class="chip red">Not A Resumable Download</div>
              <?php
              }
              if($dInfo['status'] === "error"){
              ?>
                <div>Download <b>Failed</b> - <?php echo $dInfo['error'];?></div>
              <?php
              }else if($percentage == "0"){
              ?>
                <span>Download started - Establishing connection with server</span>
              <?php
              }else if($status === "completed"){
              ?>
                <span>Download Finished</span>
              <?php
              }else{
                $percentage = round($percentage, 2);
              ?>
                <span class="chip"><?php echo $this->convertToReadableSize($dInfo['downloaded']) . " / " . $this->convertToReadableSize($dInfo['size']);?></span>
                <span class="chip"><?php echo $percentage;?>%</span>
                <div class="chip"><?php echo $this->convertToReadableSize($dInfo['speed']);?>/S</div>
                <div class="chip"><?php echo $this->secToTime($dInfo['eta']);?> remaining</div>
              <?php
              }
              ?>
            </div>
          </p>
          <div class="controls">
            <?php
            if($dInfo['paused'] == "1" || $status === "completed" || $dInfo['error'] != "0"){
            ?>
              <a id="resumeDownload" style="display: inline-block;" title="Resume Download"></a>
              <a id="reDownload" title="Re Download"></a>
              <a id="pauseDownload" style="display: none;" title="Pause Download"></a>
            <?php
            }else{
            ?>
              <a id="resumeDownload" title="Resume Download"></a>
              <a id="pauseDownload" title="Pause Download"></a>
            <?php
            }
            ?>
            <a id="removeDownload" title="Remove Download Entry. Does not delete the file"></a>
          </div>
        </div>
      </div>
    <?php
    }
  }
  ?>
</div>
