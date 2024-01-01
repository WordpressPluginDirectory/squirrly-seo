<?php
defined('ABSPATH') || die('Cheatin\' uh?');
if(!isset($view)) return;

/**
 * Find New Keywords Details view
 *
 * Called from Research View
 */
?>
<?php
if (!empty($view->kr)) {
    //For teh saved country
    if (isset($_COOKIE['sq_country'])) {
        $view->country = sanitize_text_field($_COOKIE['sq_country']);
    }

    foreach ($view->kr as $nr => $row) {
        if (!isset($row->keyword)) continue;

        //Check if the keyword is already in briefcase and if it's the main keyword that was researched
        $in_briefcase = (isset($row->in_briefcase) ? $row->in_briefcase : false);
        $initial = (isset($row->initial) ? $row->initial : false);

        ?>
        <tr class="<?php echo($in_briefcase ? 'bg-briefcase' : '') ?> <?php echo($initial ? 'bg-selected' : '') ?>">
            <td style="width: 35%;"><?php echo esc_html($row->keyword) ?></td>
            <td style="width: 10%;"><?php echo(isset($view->country) ? esc_html($view->country) : 'com') ?></td>
            <td style="width: 23%; color: <?php echo esc_attr($row->stats->sc->color) ?>"><?php echo(isset($row->stats->sc->text) ? '<span data-value="' . esc_attr($row->stats->sc->value) . '">' . esc_html($view->getReasearchStatsText('sc', $row->stats->sc->value)) . '</span>' : '') ?></td>
            <td style="width: 16%"><?php echo(isset($row->stats->sv) ? '<span data-value="' . (int)$row->stats->sv->absolute . '">' . (is_numeric($row->stats->sv->absolute) ? number_format($row->stats->sv->absolute) . '</span>' : esc_html($row->stats->sv->absolute)) : '') ?></td>
            <td style="width: 17%;"><?php echo(isset($row->stats->tw) ? '<span data-value="' . esc_attr($row->stats->tw->value) . '">' . esc_html($view->getReasearchStatsText('tw', $row->stats->tw->value)) . '</span>' : '') ?></td>

            <td class="px-0" style="width: 24px;">
                <div class="sq_sm_menu">
                    <div class="sm_icon_button sm_icon_options">
                        <i class="fa-solid fa-ellipsis-v"></i>
                    </div>
                    <div class="sq_sm_dropdown">
                        <ul class="p-2 m-0 text-left">
                            <?php
                            $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('/post-new.php?keyword=' .  SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword, 'url'));
                            if ($view->post_id) {
                                $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('post.php?post=' . (int)$view->post_id . '&action=edit&keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword, 'url'));
                            }
                            ?>
                            <li class="sq_research_selectit m-0 p-1 py-2 noloading">
                                <a href="<?php echo esc_url($edit_link)  ?>" target="_blank" class="sq-nav-link">
                                    <i class="sq_icons_small fa-solid fa-message"></i>
                                    <?php echo esc_html__("Optimize for this", 'squirrly-seo') ?>
                                </a>
                            </li>
                            <?php if ($in_briefcase) { ?>
                                <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                    <i class="sq_icons_small  fa-solid fa-briefcase"></i>
                                    <?php echo esc_html__("Already in briefcase", 'squirrly-seo'); ?>
                                </li>
                            <?php } else { ?>
                                <li class="sq_research_add_briefcase m-0 p-1 py-2" data-keyword="<?php echo esc_attr($row->keyword) ?>">
                                    <i class="sq_icons_small fa-solid fa-briefcase"></i>
                                    <?php echo esc_html__("Add to briefcase", 'squirrly-seo'); ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
    <?php }
} ?>
