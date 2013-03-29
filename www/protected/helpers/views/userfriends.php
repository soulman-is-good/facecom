<div class="list_box">
    <div class="users_list">
        <div class="list_title">
            <?php $current_user_id = $this->user_id; ?>
            <font class="rfblock">Друзья <?php echo ('('. count($friends_count) .')');?></font> <a href="/id<?php echo $current_user_id; ?>/myfriends" class="showAll blue">Весь список</a>
        </div>
        <div class="list_list">
            <?php
            foreach ($friends as $item) {
                echo '<div class="list_avatar"><a href="/id' . $item->invited->profile->user_id . '"><img width="80" src="'. Yii::app()->request->baseUrl . $item->invited->profile->getAvatar('80x80') .'" alt="" title="'. $item->invited->profile->first_name .' '. $item->invited->profile->second_name .'" /></a></div>';
            }
            ?>
        </div>
    </div>
</div>
