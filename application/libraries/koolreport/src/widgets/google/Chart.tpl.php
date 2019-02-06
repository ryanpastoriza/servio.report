<?php
/**
 * This file is template file of Google Chart 
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

use \koolreport\core\Utility;



// CLEAN COLUMNS
        $lastSeen = []; 

        foreach ($data as $key => $value) {
            if($key > 0){
                if(isset($lastSeen[$value[0]])){
                    // $data[$lastSeen[$value[0]]]

                    foreach ($value as $key2 => $value2) {
                        if ($key2 > 0) {
                            foreach ($value2 as $key3  => $value3) {
                               $data[$lastSeen[$value[0]]][$key2][$key3] += $value3;
                            }
                        }
                    }
                               unset($data[$key]);


                }
                else{
                    $lastSeen[$value[0]] = $key;
                }
            }
        }

        $ndata = [];

        foreach ($data as $key => $value) {
            $ndata[] = $value;
        }
        $data = $ndata;

// CLEAN COLUMNS


?>
<div id="<?php echo $this->name; ?>" style="<?php if ($this->width) echo "width:".$this->width.";"; ?><?php if ($this->height) echo "height:".$this->height.";"; ?>"></div>
<script type="text/javascript">
    KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
        KoolReport.google.chartLoader.load("<?php echo $this->stability; ?>","<?php echo $this->package; ?>","<?php echo $this->mapsApiKey; ?>");
        <?php echo $this->name; ?> = new KoolReport.google.chart("<?php echo $chartType; ?>","<?php echo $this->name; ?>",<?php echo json_encode($cKeys);?>,<?php echo json_encode($data);?>,<?php echo json_encode($options);?>);
        <?php
        if($this->pointerOnHover)
        {
            echo "$this->name.pointerOnHover=true;";    
        }
        ?>
        <?php
        foreach($this->clientEvents as $event=>$function)
        {
        ?>
            <?php echo $this->name; ?>.registerEvent("<?php echo $event; ?>",<?php echo $function; ?>);
        <?php
        }
        ?>
        <?php $this->clientSideReady(); ?>
    });
</script>