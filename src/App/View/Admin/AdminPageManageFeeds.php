<?php

namespace Osec\App\View\Admin;

use Osec\App\Controller\FeedsController;
use Osec\App\I18n;
use Osec\Theme\ThemeLoader;

/**
 * The Calendar Feeds page.
 *
 * @since      2.0
 * @author     Time.ly Network Inc.
 * @package AdminView
 * @replaces Ai1ec_View_Calendar_Feeds
 */
class AdminPageManageFeeds extends AdminPageAbstract
{

    /**
     * Adds page to the menu.
     *
     * @wp_hook admin_menu
     *
     * @return void
     */
    public function add_page() : void
    {
        // =======================
        // = Calendar Feeds Page =
        // =======================
        $calendar_feeds = add_submenu_page(
            OSEC_ADMIN_BASE_URL,
            I18n::__('Calendar Feeds'),
            I18n::__('Calendar Feeds'),
            'manage_osec_feeds',
            self::ADMIN_PAGE_PREFIX . 'feeds',
            $this->display_page(...)
        );
        $this->app->settings
            ->set('feeds_page', $calendar_feeds);
    }

    /**
     * Adds metabox to the page.
     *
     * @wp_hook admin_init
     *
     * @return void
     */
    public function add_meta_box() : void
    {
        // Add the 'ICS Import Settings' meta box.
        add_meta_box(
            'ai1ec-feeds',
            I18n::_x('Feed Subscriptions', 'meta box'),
            $this->display_meta_box(...),
            $this->app->settings->get('feeds_page'),
            'left',
            'default'
        );
    }

    /**
     * Display this plugin's feeds page in the admin.
     *
     * @return void
     */
    public function display_page() : void
    {
        $args = [
            'title'             => __('OSEC: Calendar Feeds', OSEC_TXT_DOM),
            'settings_page'     => $this->app->settings->get('feeds_page'),
            'calendar_settings' => false,
        ];
        ThemeLoader::factory($this->app)
                   ->get_file('calendar_feeds.php', $args, true)
                   ->render();
    }

    /**
     * Renders the contents of the Calendar Feeds meta box.
     *
     * @return void
     */
    public function display_meta_box($object, $box)
    {
        /**
         * Alter FeedsController.
         *
         * @since 1.0
         *
         * @param  FeedsController  $feed
         *
         */
        $feed = apply_filters('osec_calendar_feeds', FeedsController::factory($this->app));
        $args = [
            'tab_headers' => $feed->get_tab_header(),
            'tab_content' => $feed->get_tab_content(),
        ];
        ThemeLoader::factory($this->app)
                   ->get_file('box_feeds.php', $args, true)
                   ->render();
    }


    public function handle_post() : void
    {
        if (isset($_POST[ 'cron_freq' ])) {
            $this->app->settings->set('ics_cron_freq', $_REQUEST[ 'cron_freq' ]);
        }
    }

}