<?php

namespace Osec\App\View\Admin;

use Osec\App\I18n;
use Osec\App\Model\Date\DT;
use Osec\App\Model\Date\Timezones;
use Osec\App\Model\Date\UIDateFormats;
use Osec\App\Model\PostTypeEvent\Event;
use Osec\App\Model\PostTypeEvent\EventNotFoundException;
use Osec\App\Model\PostTypeEvent\EventParent;
use Osec\App\View\RepeatRuleToText;
use Osec\App\WpmlHelper;
use Osec\Bootstrap\OsecBaseClass;
use Osec\Theme\ThemeLoader;
use WP_Post;

/**
 * Event create/update form backend view layer.
 *
 * Manage creation of boxes (containers) for our control elements
 * and instantiating, as well as updating them.
 *
 * @since        2.0
 * @author       Time.ly Network, Inc.
 * @package PostTypeEvent
 * @replaces Ai1ec_View_Add_New_Event
 */
class AdminPageAddEvent extends OsecBaseClass
{

    /**
     * Create hook to display event meta box when creating or editing an event.
     *
     * @wp_hook add_meta_boxes
     *
     * @return void
     */
    public function event_meta_box_container()
    {
        add_meta_box(
            OSEC_POST_TYPE,
            I18n::__('Event Details'),
            $this->meta_box_view(...),
            OSEC_POST_TYPE,
            'normal',
            'high'
        );
    }

    /**
     * Add Event Details meta box to the Add/Edit Event screen in the dashboard.
     *
     * @return void
     */
    public function meta_box_view()
    {

        $theme_loader = ThemeLoader::factory($this->app);
        $empty_event = new Event($this->app);

        // ==================
        // = Default values =
        // ==================
        // ATTENTION - When adding new fields to the event remember that you must
        // also set up the duplicate-controller.
        // TODO: Fix this duplication.
        $all_day_event = '';
        $instant_event = '';
        $start = new DT('now', 'sys.default');
        $end = (clone $start)->adjust(1, 'hour');
        $timezone_name = null;
        $timezones_list = Timezones::factory($this->app)->get_timezones(true);
        $show_map = false;
        $google_map = '';
        $venue = '';
        $country = '';
        $address = '';
        $city = '';
        $province = '';
        $postal_code = '';
        $contact_name = '';
        $contact_phone = '';
        $contact_email = '';
        $contact_url = '';
        $cost = '';
        $is_free = '';
        $rrule = '';
        $rrule_text = '';
        $repeating_event = false;
        $exrule = '';
        $exrule_text = '';
        $exclude_event = false;
        $exdate = '';
        $show_coordinates = false;
        $longitude = '';
        $latitude = '';
        $coordinates = '';
        $ticket_url = '';

        $instance_id = false;
        if (isset($_REQUEST[ 'instance' ])) {
            $instance_id = absint($_REQUEST[ 'instance' ]);
        }
        if ($instance_id) {
            add_filter(
                'print_scripts_array',
                $this->disable_autosave(...)
            );
        }

        try {
            // on some php version, nested try catch blocks fail and the exception would never be caught.
            // this is why we use this approach.
            $excpt = null;
            $event = null;
            try {
                $event = new Event($this->app, get_the_ID(), $instance_id);

            } catch (EventNotFoundException $excpt) {
                $translatable_id = WpmlHelper::factory($this->app)->get_translatable_id();
                if (false !== $translatable_id) {
                    $event = new Event($this->app, $translatable_id, $instance_id);
                }
            }
            if (null !== $excpt) {
                throw $excpt;
            }

            // Existing event was found. Initialize form values with values from
            // event object.
            $all_day_event = $event->is_allday() ? 'checked' : '';
            $instant_event = $event->is_instant() ? 'checked' : '';

            $start = $event->get('start');
            $end = $event->get('end');
            $timezone_name = $event->get('timezone_name');

            $multi_day = $event->is_multiday();

            $show_map = $event->get('show_map');
            $google_map = $show_map ? 'checked="checked"' : '';

            $show_coordinates = $event->get('show_coordinates');
            $coordinates = $show_coordinates ? 'checked="checked"' : '';
            $longitude = (float) $event->get('longitude', 0);
            $latitude = (float) $event->get('latitude', 0);
            // There is a known bug in WordPress (https://core.trac.wordpress.org/ticket/15158) that saves 0 to the DB instead of null.
            // We handle a special case here to avoid having the fields with a value of 0 when the user never inputted any coordinates
            if ( ! $show_coordinates) {
                $longitude = '';
                $latitude = '';
            }

            $venue = $event->get('venue');
            $country = $event->get('country');
            $address = $event->get('address');
            $city = $event->get('city');
            $province = $event->get('province');
            $postal_code = $event->get('postal_code');
            $contact_name = $event->get('contact_name');
            $contact_phone = $event->get('contact_phone');
            $contact_email = $event->get('contact_email');
            $contact_url = $event->get('contact_url');
            $cost = $event->get('cost');
            $ticket_url = $event->get('ticket_url');
            $rrule = $event->get('recurrence_rules');
            $exrule = $event->get('exception_rules');
            $exdate = $event->get('exception_dates');
            $repeating_event = ! empty($rrule);
            $exclude_event = ! empty($exrule);

            $is_free = '';
            $free = $event->is_free();
            if ( ! empty($free)) {
                $is_free = 'checked="checked" ';
                $cost = '';
            }

            if ($repeating_event) {
                $rrule_text = ucfirst(
                    RepeatRuleToText::factory($this->app)->rrule_to_text($rrule)
                );
            }

            if ($exclude_event) {
                $exrule_text = ucfirst(
                    RepeatRuleToText::factory($this->app)->rrule_to_text($exrule)
                );
            }
        } catch (EventNotFoundException) {
            // Event does not exist.
            // Leave form fields undefined (= zero-length strings)
            $event = null;
        }

        // Time zone; display if set.
        $timezone = '';
        $timezone_string = null;
        $date_timezone = Timezones::factory($this->app);

        if (
            ! empty($timezone_name) &&
            $local_name = $date_timezone->get_name($timezone_name)
        ) {
            $timezone_string = $local_name;
        }
        if (null === $timezone_string) {
            $timezone_string = $date_timezone->get_default_timezone();
        }

        if ($timezone_string) {
            $timezone = UIDateFormats::factory($this->app)
                                     ->get_gmt_offset_expr($timezone_string);
        }

        if (empty($timezone_name)) {
            /**
             * Actual Olsen timezone name is used when value is to be directly
             * exposed to user in some mean. It's possible to use named const.
             * `'sys.default'` only when passing value to date.time library.
             */
            $timezone_name = $date_timezone->get_default_timezone();
        }

        // This will store each of the accordion tabs' markup, and passed as an
        // argument to the final view.
        $boxes = [];
        $parent_event_id = null;
        if ($event) {
            $parent_event_id = EventParent::factory($this->app)
                                          ->event_parent($event->get('post_id'));
        }
        // ===============================
        // = Display event time and date =
        // ===============================
        $args = [
            'all_day_event'   => $all_day_event,
            'instant_event'   => $instant_event,
            'start'           => $start,
            'end'             => $end,
            'repeating_event' => $repeating_event,
            'rrule'           => $rrule,
            'rrule_text'      => $rrule_text,
            'exclude_event'   => $exclude_event,
            'exrule'          => $exrule,
            'exrule_text'     => $exrule_text,
            'timezone'        => $timezone,
            'timezone_string' => $timezone_string,
            'timezone_name'   => $timezone_name,
            'exdate'          => $exdate,
            'parent_event_id' => $parent_event_id,
            'instance_id'     => $instance_id,
            'timezones_list'  => $timezones_list,
        ];

        $boxes[] = $theme_loader
            ->get_file('box_time_and_date.php', $args, true)
            ->get_content();

        // =================================================
        // = Display event location details and Google map =
        // =================================================
        $args = [

            /**
             * Add html before Event venue
             *
             * Content must be a table row aka wrapped in tr-Html-Tags.
             *
             * @since 1.0
             *
             * @param  string  $html  Html sting to display before venue.
             */
            'pre_venue_html'   => apply_filters('osec_post_form_before_venue_html', ''),

            /**
             * Add html after Event venue
             *
             * Content must be a table row aka wrapped in in tr-Html-Tags.
             *
             * @since 1.0
             *
             * @param  string  $html  Html sting to display after venue.
             */
            'post_venue_html'  => apply_filters('osec_post_form_after_venue_html', ''),
            'venue'            => $venue,
            'country'          => $country,
            'address'          => $address,
            'city'             => $city,
            'province'         => $province,
            'postal_code'      => $postal_code,
            'google_map'       => $google_map,
            'show_map'         => $show_map,
            'show_coordinates' => $show_coordinates,
            'longitude'        => $longitude,
            'latitude'         => $latitude,
            'coordinates'      => $coordinates,
        ];
        $boxes[] = $theme_loader
            ->get_file('box_event_location.php', $args, true)
            ->get_content();

        // ======================
        // = Display event cost =
        // ======================
        $args = ['cost' => $cost, 'is_free' => $is_free, 'ticket_url' => $ticket_url, 'event' => $empty_event];
        $boxes[] = $theme_loader
            ->get_file('box_event_cost.php', $args, true)
            ->get_content();


        // =========================================
        // = Display organizer contact information =
        // =========================================
        $args = [
            'contact_name'  => $contact_name,
            'contact_phone' => $contact_phone,
            'contact_email' => $contact_email,
            'contact_url'   => $contact_url,
            'event'         => $empty_event
        ];
        $boxes[] = $theme_loader
            ->get_file('box_event_contact.php', $args, true)
            ->get_content();

        // ==========================
        // = Parent/Child relations =
        // ==========================
        if ($event) {
            $parent = EventParent::factory($this->app)
                                 ->get_parent_event($event->get('post_id'));
            if ($parent) {
                try {
                    $parent = new Event($this->app, $parent);
                } catch (EventNotFoundException) { // ignore
                    $parent = null;
                }
            }
            if ($parent) {
                $children = EventParent::factory($this->app)
                                       ->get_child_event_objects($event->get('post_id'));
                $args = compact('parent', 'children');
                $args[ 'app' ] = $this->app;

                $boxes[] = $theme_loader->get_file(
                    'box_event_children.php',
                    $args,
                    true
                )->get_content();
            }

        }

        /**
         * Alter content boces in Event Edit
         *
         * Like Date-and-time, Location, Tickets...
         * Allows you to add or limit Event information options.
         *
         * @param  array  $boxes  Array of HTML output (bootstrap3 panels).
         * @param  Event  $event  Event instance.
         */
        $boxes = apply_filters('osec_admin_edit_event_input_panels_alter', $boxes, $event);
        // Display the final view of the meta box.
        $args = ['boxes' => $boxes];
        echo $theme_loader
            ->get_file('add_new_event_meta_box.php', $args, true)
            ->get_content();
    }

    /**
     * disable_autosave method
     *
     * Callback to disable autosave script
     *
     * @param  array  $input  List of scripts registered
     *
     * @return array Modified scripts list
     */
    public function disable_autosave(array $input)
    {
        wp_deregister_script('autosave');
        $autosave_key = array_search('autosave', $input);
        if (false === $autosave_key || ! is_scalar($autosave_key)) {
            unset($input[ $autosave_key ]);
        }

        return $input;
    }

    /**
     * Renders Bootstrap inline alert.
     *
     * @param  WP_Post  $post  Post object.
     *
     * @return void Method does not return.
     */
    public function event_inline_alert(WP_Post $post)
    {
        if ( ! isset($post->post_type) || OSEC_POST_TYPE != $post->post_type) {
            return;
        }
        echo ThemeLoader::factory($this->app)
                        ->get_file('box_inline_warning.php', null, true)
                        ->get_content();
    }

}
