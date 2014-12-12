<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/28
 * Time: 15:31
 */
echo $header;
?>
<script type="text/javascript">
    var token = "<?php echo $token?>";
    var tenantid = "<?php echo $tenantid ?>";
</script>
<?php
echo $navbar;
echo $content;
