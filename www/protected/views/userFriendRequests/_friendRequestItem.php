<div class="list_box_other">
    <div class="users_list">
        <div class="users_list_inner">
            <?php
            /*foreach ($friends as $item) {*/
                echo '<div class="list_avatar_other"><a href="/id' . $item->invited->profile->user_id . '"><img width="150" src="'. Yii::app()->request->baseUrl . $item->invited->profile->getAvatar('small') .'" alt="" title="'. $item->invited->profile->first_name .' '. $item->invited->profile->second_name .'" /></a></div>';
                echo '<div class="f_name"><a class="grey" href="/id' . $item->invited->profile->user_id . '">' . $item->invited->profile->first_name . ' ' . $item->invited->profile->second_name . '</a></div>';
            /*}*/
            ?>
        </div>
    </div>
</div>

