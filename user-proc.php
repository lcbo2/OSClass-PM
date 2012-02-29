<?php

if(Params::getParam('option') == 'delMessages'){
   switch(Params::getParam('box')) {
      case 'inbox':
         $pmDelIds = Params::getParam('pms');
         if (!is_array($pmDelIds)) {
            ModelPM::newInstance()->updateMessagesRecipDelete($pmDelIds);
         } else {
            foreach($pmDelIds as $pmDelId){
               ModelPM::newInstance()->updateMessagesRecipDelete($pmDelId);
            }
         }
      // HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php'; ?>"</script>
    	<?php
      break;
      case 'outbox':
         $pmDelIds = Params::getParam('pms');
         if (!is_array($pmDelIds)) {
            ModelPM::newInstance()->updateMessagesSenderDelete($pmDelIds);
         } else {
            foreach($pmDelIds as $pmDelId){
               ModelPM::newInstance()->updateMessagesSenderDelete($pmDelId);
            }
         }
      // HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-outbox.php'; ?>"</script>
    	<?php
      break;
   }     
}
?>