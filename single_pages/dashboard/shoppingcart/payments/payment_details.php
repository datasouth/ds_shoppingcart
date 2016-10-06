<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $form = Loader::helper('form'); ?>
<?php  Loader::packageElement("payments/required_form", $view->c->pkgHandle, array('method' => $method, 'form' => $form, 'values' => $values)); ?>

<?php if(($response)):
			$successMessage = t("Successfully updated changes");
?>
	<script type="text/javascript">$(document).ready(function () {
            ConcreteAlert.notify({'message': '', 'title': '<?php  echo $successMessage ?>'});
        });
	</script>
<?php  endif; ?>
