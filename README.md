# WOP lab Default plugin

Default WordPress plugin with ready classes and methods which can be useful for developing your own plugin.

You can use many functions and helpers which make your work easier.

## Content

- [Setup](#setup)
- [Database](#database)
- [Metabox](#metabox)
- [Shortcode](#shortcode)
- [Cron](#cron)
- [Ajax](#ajax)
- [Admin settings](#settings)
- [Table](#table)
- [API](#api)
- [Functions](#functions)

## Setup

Class **WOP_Setup()**

### Insert page template

- *page_template()* - Include page templates.

### Create custom post types and taxonomies

- *custom_post_types()* - Use helper methods *create_post_type()* and *create_taxonomy()* for creating new post types and taxonomies.

## Database

Class **WOP_Database()**

### Tables

- *table_log_install()* - example of creating a new table.
- *drop_table()* - helper method for delete table.

### Pages

- *add_pages()* - Insert new pages using list of pages in the method *pages_list()*. Call this method on the plugin activation hook.
- *remove_pages()* - Remove pages using same list of pages in the method *pages_list()*. Call this method in the deactivation or uninstall hook.

### Options

- *remove_options()* - Remove options. Add options names to the variable *$options*.

### Post types and taxonomies

- *remove_post_types()* - Remove posts of post types. Add necessary post types to the argument 'post_type'. Call this method in the deactivation or uninstall hook.
- *remove_taxonomies()* - Remove posts of post types. Add necessary post types to the argument 'taxonomy'. Call this method in the deactivation or uninstall hook.

## Metabox

Class **WOP_Metabox()**

Register metabox in the method *register_meta_boxes()*. Then create a method as a callback function. Do process of saving data from the metabox in the method *save_post_call()*, class **WOP_Admin()**.

## Shortcode

Class **WOP_Shortcode()**

- Register shortcodes and make a callback method into the class.
- Use including the template into the buffer.

## Cron

Class **WOP_Cron()**

- *init()* - Register cron event.
- *wop_event_schedule_call()* - Add new cron schedules.
- *cron_call()* - Callback function for registered cron.
- *cron_deactivation()* - Deactivate cron event. Call this method in the deactivation or uninstall hook.

## Ajax

- *init()* - register ajax. Add action names to the variable *$names*.
- Add method for ajax action callback with the same name as action.

## Admin settings

### Page settings

- *add_menu_pages()* - Add pages and subpages for the admin menu.
- *register_settings()* - Register settings for the admin settings page.

### Page with WP table

Class **WOP_Logs()**

The WordPress table with pagination, sorting, checking and actions.

- Add new page in the *add_menu_pages()* method.
- Require class WP_List_Table() in the callback function.
- Include templates.'
- Create new class for table - WOP_Logs(), extended from WP_List_Table().
- Declare class and necessary methods for new class in the page for settings.

#### WP table

- *get_columns()* - Add columns for the table.
- *prepare_items()* - Prepare data for the table.
- *table_data()* - Get fields for a table from the database. Column names must be same as you filled in the method *get_columns()*.
- *column_default()* - Output of each table cell. Column names must be same as you filled in the methods *get_columns()*and *table_data()* .
- *get_sortable_columns()* - Fill columns for sorting.
- *get_bulk_actions()* - Add actions to the table.
- *column_cb()* - Output html for column cb with checkboxes.
- *no_items()* - Output html if there are no items.
- *add_custom_actions()* - Add custom actions. Detect them and do what you need.
- *status_message()* - Custom method for showing messages.
- *sort_data()* - Logic for sorting the table by columns.
- *display_tablenav()* - Display a table control panel.
- *redirect()* - Custom method for redirect.

## API

Class **WOP_API()**

- *call()* - Make call to the API. Add arguments for request as data - POST body, path or href and method.

## Functions

Class **WOP_Functions()**

- *write_log()* - Write log to the log file *wop_logs.log*.
- *get_response()* - Get response and write to the log file *response_logs.log*.
- *insert_log()* - Insert log to the log table in the database.
- *create_post_type()* - Create new post type.
- *create_taxonomy()* - Create new taxonomy.
- *send_mail()* - Send email.

## Helpers

Classes **WOP_Helper()**

- *get_path()* - Get path to the file (only for folder /parts/).
- *is_mobile()* - Check if the user is on the mobile.WP_List_Table
- *get_ip()* - Get user's IP address.
- *check_server_ip()* - Get user's IP address and compare them with white list addresses.
- *get_location()* - Get user's location.
- *_get_posts()* - Get posts using prepared data for arguments.
- *_get_terms()* - Get taxonomy terms using prepared data for arguments.
- *cut_str()* - Cut string and output.
- *get_thumbnail_url()* - Get post thumbnail URL or show default image.

### Notes

- Use names for class name exact as for filename. It needs for autoloader.