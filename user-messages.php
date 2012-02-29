<?php if(osc_is_web_user_logged_in() ) {
   $pm_id = Params::getParam('message');  
   switch(Params::getParam('box')) {
      case 'inbox': 
         $pm = ModelPM::newInstance()->getRecipientMessage(osc_logged_user_id(), 1, 0, $pm_id );
      break;
      case 'outbox':
         $pm = ModelPM::newInstance()->getSenderMessage(osc_logged_user_id(), 1, $pm_id );
      break;
   }
   
   if($pm['recipNew'] == 1) {
      ModelPM::newInstance()->updateMessageAsRead($pm['pm_id']);
   }
?>
<div class="content user_account">
    <h1>
        <strong><?php echo __('Message: ', 'osc_pm') . osc_highlight($pm['pm_subject'], 50); ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
    <div id="main">
      <?php if(Params::getParam('box') == 'inbox') { ?>
         <a href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php'; ?>">Back to inbox</a>
      <?php } elseif(Params::getParam('box') == 'outbox') { ?>
         <a href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-outbox.php'; ?>">Back to outbox</a>
      <?php } ?> 
      <br />
      <br />
      <div class="pm_main">
         <div class="pm_author">
            <?php if($pm['sender_id'] != 0){
                     $user = User::newInstance()->findByPrimaryKey($pm['sender_id']); 
                  } else { $user['s_name'] = pmAdmin();} ?>
            <span class="sender"><?php _e('Sender:','osc_pm'); ?></span>
            <br />
            <span class="sender_name"><?php echo $user['s_name']; ?></span>
         </div>
         <div class="pm_message">
            <div class="pm_tools">
               <div class="pm_sub">
                  <span class="subject_pm"><?php echo $pm['pm_subject']; ?></span>
                  <br />
                  <?php if($pm['recip_id'] != 0){
                           $user = User::newInstance()->findByPrimaryKey($pm['recip_id']); 
                        } else { $user['s_name'] = pmAdmin();} ?>
                  <?php echo __('Sent to: ','osc_pm') . $user['s_name'] . ' ' . __('on: ','osc_pm') . osc_format_date($pm['message_date']) . ', ' . osc_format_time($pm['message_date']); ?>
               </div> 
               <ul class="reset pm_tool">
                  <li class="reply"><a href="" ><?php _e('Reply','osc_pm'); ?></a></li>
                  <li class="quote"><a href="" ><?php _e('Quote','osc_pm'); ?></a></li>
                  <li class="del"><a onclick="if (!confirm('<?php _e('Are you sure you want to delete this personal messages?','osc_pm'); ?>')) return false;" href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-proc.php&pms=' . $pm['pm_id'] . '&option=delMessages&box=inbox'; ?>" ><?php _e('Delete','osc_pm'); ?></a></li>
               </ul>              
            </div>
            <div class="pm_mess">
               <?php echo nl2br($pm['pm_message']); ?>
            </div>
         </div>
      </div>
    </div>
</div>
<?php } ?>