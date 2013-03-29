<div class="list_box_cv">
    <div class="cv_box">
        <div class="cv_inner_div">
            <?php

                $user_id = $_GET['id'];

                echo '<div class="cv_list_item">';
                echo '<div><a href="/id' . $user_id . '/cv/view/' . $item['cv_id'] . '"  class="blue">' . $item['desire_position'] . '</a></div>';

                echo '<div>Последнее изменение ' . $item['le_date'] . ', ' . $item['le_date_time'] . '</div>';


                echo '<div class="cv_counters_n_links">';
                echo '<div class="new_counts">' . $item['new_counts'] . ' новых просомтров - </div>';

                echo '<div class="all_counts">' . $item['all_counts'] . ' просмотров - </div>';

                echo '<div class="cv_delete_link"><a href="#" class="blue">Удалить</a></div>';
                echo '</div>';

                echo '</div>';
                
                

            ?>
        </div>
    </div>
</div>