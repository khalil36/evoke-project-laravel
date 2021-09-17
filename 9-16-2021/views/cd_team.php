<?php 
if( $team->have_posts() ){
    ?>
    <div class="cd_team">
        <?php
        while( $team->have_posts() ){
            $team->the_post();
            $role = get_field('role', get_the_ID());
            ?>
            <div class="cd_member">
                <div class="member-thumbnail">
                    <?php 
                        if(has_post_thumbnail($post)){
                            the_post_thumbnail();
                        }
                    ?>
                </div>
                <div class="member-title"><?php the_title();?></div>
                <div class="member-role"><?php echo $role;?></div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}