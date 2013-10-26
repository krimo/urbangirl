<?php   
    if($_POST['ugadbg_hidden'] == 'Y') {  
        //Form data sent  
        $ugadbg_url = $_POST['ugadbg_url'];  
        update_option('ugadbg_url', $ugadbg_url);
    ?>  
    <div class="updated"><p><strong><?php _e('Image bien enregistrée !' ); ?></strong></p></div>  
    <?php  
    } else {  
        $ugadbg_url = get_option('ugadbg_url'); 
    }  
?> 

<div class="wrap">  
    <?php echo "<h2>" . __( 'Image de Promo UrbanGirl', 'ugadbg_trdom' ) . "</h2>"; ?>  
      
    <form name="ugadbg_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
        <input type="hidden" name="ugadbg_hidden" value="Y"> 
        <p><?php _e("Url de l'image de fond : " ); ?><input type="url" name="ugadbg_url" value="<?php echo $ugadbg_url; ?>" size="20"></p>
        <p class="submit">  
        <input type="submit" name="Submit" value="<?php _e('Mettre à jour', 'ugadbg_trdom' ) ?>" />  
        </p>  
    </form>  
</div>