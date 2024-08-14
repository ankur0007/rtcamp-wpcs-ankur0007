# RTCamp Assignment Plugin - Metabox

## Description

RTCamp Assignment is a WordPress plugin that provides a metabox called "Contributors" on the post editor screen. This plugin allows users to search for other users by their roles (Administrator, Editor, Author), select them as post contributors, and display them on the frontend below the post content.

## Features

- **Search for Contributors:** Use a search field to find users with specific roles (Administrator, Editor, Author).
- **Select and Save Contributors:** Select users from the search results and save them as contributors in post meta.
- **Manage Contributors:** Add or remove contributors dynamically via AJAX, using custom REST API endpoints.
- **Display Contributors on Frontend:** Automatically display the selected contributors below the post content on the frontend using the `the_content` filter.

## Installation

1. Download the plugin from the [GitHub repository](https://github.com/ankur0007/rtcamp-wpcs-ankur0007).
2. Upload the plugin files to the `/wp-content/plugins/rtcamp-assignment` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. The Contributors metabox will now be available on the post editor screen.

## Usage

### Adding Contributors

1. Open any post in the WordPress editor.
2. Use the "Contributors" metabox to search for users by their roles.
3. Select users from the search results to add them as contributors.
4. Contributors will be saved in the post meta and displayed below the post content on the frontend.

### Removing Contributors

1. Uncheck the users in the "Contributors" metabox to remove them.
2. The contributors will be removed from the post meta and will no longer appear on the frontend.

## Demo

Check out a [Live Demo](https://wpcoollogics.co.in/hello-world/) to see the plugin in action.

## Built With

- **WordPress** - Core platform used for plugin development.
- **REST API** - Custom endpoints for AJAX operations.
- **JavaScript/jQuery** - Used for AJAX requests and DOM manipulation.

## Contributing

If you'd like to contribute to this plugin, please feel free to submit a pull request on [GitHub](https://github.com/ankur0007/rtcamp-wpcs-ankur0007).

## License

This plugin is licensed under the GPL-2.0+ License. See the [LICENSE](http://www.gnu.org/licenses/gpl-2.0.txt) file for details.

## Contact

For any questions or support, reach out to [Ankur Vishwakarma](https://profiles.wordpress.org/the-ank/).
