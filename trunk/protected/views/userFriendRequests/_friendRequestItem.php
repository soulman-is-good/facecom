<div class="list_box_other">
    <div class="users_list">
        <div class="users_list_inner">
            <?php
            /*foreach ($friends as $item) {*/
                if (empty($item->invited->profile->avatar) || !is_file(Yii::app()->request->baseUrl . '/upload/UserProfile/150x150/' . $item->invited->profile->avatar)) {
                                $item->invited->profile->avatar = '150x150_testAvatar.png';
                            }
                echo '<div class="list_avatar_other"><a href="/id' . $item->invited->profile->user_id . '"><img src="'. Yii::app()->request->baseUrl .'/upload/UserProfile/150x150/'. $item->invited->profile->avatar .'" alt="" title="'. $item->invited->profile->first_name .' '. $item->invited->profile->second_name .'" /></a></div>';
                echo '<div class="f_name"><a class="grey" href="/id' . $item->invited->profile->user_id . '">' . $item->invited->profile->first_name . ' ' . $item->invited->profile->second_name . '</a></div>';
            /*}*/
            ?>
        </div>
    </div>
</div>

