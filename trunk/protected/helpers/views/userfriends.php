<div class="list_box">
    <div class="users_list">
        <div class="list_title">
            <?php $current_user_id = $this->user_id; ?>
            <font class="rfblock">Друзья <?php echo ('('. count($friends_count) .')');?></font> <a href="/id<?php echo $current_user_id; ?>/myfriends" class="showAll blue">Весь список</a>
        </div>
        <div class="list_list">
            <?php
            foreach ($friends as $item) {
                if (empty($item->invited->profile->avatar) && !is_file(Yii::app()->request->baseUrl . '/upload/UserProfile/80x80/' . $item->invited->profile->avatar)) {
                                $item->invited->profile->avatar = 'testAvatar.png';
                            }
                echo '<div class="list_avatar"><a href="/id' . $item->invited->profile->user_id . '"><img src="'. Yii::app()->request->baseUrl .'/upload/UserProfile/80x80/'. $item->invited->profile->avatar .'" alt="" title="'. $item->invited->profile->first_name .' '. $item->invited->profile->second_name .'" /></a></div>';
            }
            ?>
        </div>
    </div>
</div>
