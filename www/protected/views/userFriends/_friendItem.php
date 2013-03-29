<div class="list_box_other">
    <div class="users_list">
        <div class="users_list_inner">
            <?php
                $current_loged_user = Yii::app()->user->id;
                $current_page_id = $_GET['id'];
                $friend_id = $item->invited->profile->user_id;

                $mutual_friends = UserMutualFriends::model()->getMutualFriends($current_loged_user, $friend_id);
                $count_mutual_friends = count($mutual_friends);

                $are_friends = UserFriends::model()->areFriends($current_loged_user, $friend_id);

                echo '<div class="list_avatar_other"><a href="/id' . $item->invited->profile->user_id . '"><img width="150" src="'. Yii::app()->request->baseUrl . $item->invited->profile->getAvatar('small') .'" alt="" title="'. $item->invited->profile->first_name .' '. $item->invited->profile->second_name .'" /></a></div>';
                echo '<div class="f_name"><a class="grey" href="/id' . $item->invited->profile->user_id . '">' . $item->invited->profile->first_name . ' ' . $item->invited->profile->second_name . '</a></div>';
                if($count_mutual_friends!=null){
                    echo '<div class="mutual_friends_link"><a class="blue_little" href="/id' . $current_loged_user . '/mutual/fid' . $item->invited->profile->user_id . '">Общих друзей: '. $count_mutual_friends .'</a></div>';
                } else {
                    echo '<a class="blue_little">У вас нету общих друзей.</a>';                    
                }

                echo '<div class="uf_links_block">';
                echo '<div class="uf_links"><a class="grey_little" href="#">Написать сообщение</a></div>';
                echo '<div class="uf_links"><a class="grey_little" href="/id' . $item->invited->profile->user_id . '/myfriends">Показать друзей</a></div>';
                
                if($are_friends == 'friends'){
                    echo '<div class="uf_links"><a class="grey_little" href="#">Убрать из друзей</a></div>';
                } elseif ($are_friends == 'myrequest') {
                    # code...
                } elseif ($are_friends == 'request') {
                    # code...
                } elseif ($are_friends == 'false') {
                    echo '<div class="uf_links"><a class="grey_little" href="#">Добавить в друзья</a></div>';
                }
                echo '</div>';

            ?>
        </div>
    </div>
</div>