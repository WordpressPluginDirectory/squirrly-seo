<?php
defined('ABSPATH') || die('Cheatin\' uh?');
if(!isset($view)) return;

/**
 * Research Details view
 *
 * Called from Research Controller
 */
?>
<td colspan="8">
    <div class="col-12 m-0 p-0">
        <div class="card col-12 my-4 p-0 px-0 border-0 ">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th ><?php echo esc_html__("Keyword", 'squirrly-seo') ?></th>
                    <th title="<?php echo esc_attr__("Competition", 'squirrly-seo') ?>">
                        <i class="fa-solid fa-comments-o"></i>
                        <?php echo esc_html__("Competition", 'squirrly-seo') ?>
                    </th>
                    <th title="<?php echo esc_attr__("SEO Search Volume", 'squirrly-seo') ?>">
                        <i class="fa-solid fa-search"></i>
                        <?php echo esc_html__("SV", 'squirrly-seo') ?>
                    </th>
                    <th title="<?php echo esc_attr__("Recent discussions", 'squirrly-seo') ?>">
                        <i class="fa-solid fa-users"></i>
                        <?php echo esc_html__("Discussion", 'squirrly-seo') ?>
                    </th>

                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($view->kr) && isset($view->kr->keyword)) {
                    $view->kr->keyword = explode(',', $view->kr->keyword);
                    $view->kr->data = json_decode($view->kr->data);
                    if (!empty($view->kr->data))
                    foreach ($view->kr->data as $nr => $row) {
                        //Check if the keyword is already in briefcase
                        $in_briefcase = (isset($row->in_briefcase) ? $row->in_briefcase : false);
                        ?>
                            <tr class="<?php echo($in_briefcase ? 'bg-briefcase' : '') ?> " >
                                <td nowrap="nowrap" style="width: 40%;white-space: nowrap;"><?php echo esc_html($row->keyword) ?></td>
                            <?php if (!empty($row->stats)) { ?>
                                    <td nowrap="nowrap" style="width: 25%;white-space: nowrap;">
                                        <span class="sq_top_keywords_rank" style="color:<?php echo(isset($row->stats->sc->color) ? esc_attr($row->stats->sc->color) : '#fff') ?>"><?php echo(isset($row->stats->sc->text) ? esc_html($view->getReasearchStatsText('sc', $row->stats->sc->value)) : '-') ?></span>
                                    </td>
                                    <td nowrap="nowrap text-right" style="width: 16%;white-space: nowrap;">
                                        <span class="sq_top_keywords_rank"><?php echo(isset($row->stats->sv->absolute) ? (is_numeric($row->stats->sv->absolute) ? number_format($row->stats->sv->absolute) : esc_html($row->stats->sv->absolute)) : '-') ?></span>
                                    </td>
                                    <td nowrap="nowrap" style="width: 17%;white-space: nowrap;">
                                        <span class="sq_top_keywords_rank"><?php echo(isset($row->stats->tw->text) ? esc_html($view->getReasearchStatsText('tw', $row->stats->tw->value)) : '-') ?></span>
                                    </td>
                            <?php } else { ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                            <?php } ?>
                                <td class="px-0 py-2" style="width: 20px">
                                    <div class="sq_sm_menu">
                                        <div class="sm_icon_button sm_icon_options">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </div>
                                        <div class="sq_sm_dropdown">
                                            <ul class="p-2 m-0 text-left">
                                                <li class="sq_research_selectit m-0 p-1 py-2 noloading">
                                                <?php  $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('/post-new.php?keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword, 'url')); ?>
                                                    <a href="<?php echo esc_url($edit_link) ?>" target="_blank" class="sq-nav-link">
                                                        <i class="sq_icons_small fa-solid fa-message"></i>
                                                    <?php echo esc_html__("Optimize for this", 'squirrly-seo') ?>
                                                    </a>
                                                </li>
                                            <?php if ($in_briefcase) { ?>
                                                    <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                                        <i class="sq_icons_small fa-solid fa-briefcase"></i>
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
                            <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</td>
