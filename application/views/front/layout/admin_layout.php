<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=El+Messiri&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/style2.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/plugins/toastr/toastr.min.css" />
<?php
     if (!empty($css)){  
        foreach ($css as $value){ ?>  
        <link rel="stylesheet" href="<?= base_url(); ?>assets/front/css/<?php echo $value ?>">
      <?php  }
       }
    ?>
</head>
<body>
    
    <?php $this->load->view($page);?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  
<script src="<?php echo base_url(); ?>assets/front/js/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/front/js/plugins/toastr/toastr.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/front/js/comman_function.js" type="text/javascript"></script>
            <?php
                if (!empty($js)){ 
                 foreach ($js as $value){ ?>
                <script src="<?= base_url()?>assets/front/js/<?php echo $value; ?>" type="text/javascript"></script>

            <?php } } ?>
            <script>
                jQuery(document).ready(function() {
                    <?php
                    if (!empty($init)) {
                        foreach ($init as $value) {
                            echo $value . ';';
                        }
                    }
            ?>
            });
</script>
</body>

</html>
