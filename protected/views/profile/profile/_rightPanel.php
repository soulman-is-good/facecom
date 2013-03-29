<?if($this->bDisplayRightPanel):?>
    <?
        $html = '';
        $html .= $this->widget('WUserRelated',array('user_id'=>$profile->user_id),true);
        $html .= $this->widget('WUserFriendRequests',array('user_id'=>$profile->user_id),true);
        $html .= $this->widget('WUserFriends',array('user_id'=>$profile->user_id),true);
        /*$html .= $this->widget('WUserGuests',array('user_id'=>$profile->user_id),true);*/
        $html .= $this->widget('WAdsBlock',array(),true);
        $html= trim($html);
        if(!empty($html)):
    ?>
<td class="right">
    <?=$html?>

</td>
<?      endif;
endif;?>