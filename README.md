## davidsword-ca

Custom theme for https://davidsword.ca/

![screenshot](screenshot.png)

### Develop

`grunt less` compiles and minifies all `/assets/src/css/*.less` into `/assets/css/dist/style.css`. Use `grunt watch` during dev to fire this on any edit of a `*.less` file.

### Pseudo Post Formats

This theme does not use `post_formats` in the tradional sense. I found the added step of changing post formats easy-to-forget while creating content, and that my post formats were less about that flag and more about what type of content is in the post. There two conditions in which a `post` can have that will rendered in a slightly different post format. When a post has:

- **No Title** it assumes a "Status" pseudo post format. This makes it so the `<h1>` does not render, and the `wp_title` and `the_title` are filtered with "Status <id>"
- **No Content and a Featured Image** assumes a "Image" pseudo Post Format, these posts also do not have a title display on the site (as to not take away from the image, but it still does appear in `wp_title()`), and no content will display.

This is done to reduce steps while generating content, to minimize `if` statments throughout the template files, and to streamline the logic of the `partials/` folder.

The following helper functions are avaliable:
* `dsca_get_pseduo_post_format()`
* `dsca_is_pseduo_post_format_image()`
* `dsca_is_pseduo_post_format_status()`

See [`/inc/pseduo-post-format.php`](inc/pseduo-post-format.php) for more info.