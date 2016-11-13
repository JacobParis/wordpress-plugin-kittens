#trial-project for nine10

This is a trial project commissioned from nine10

#Installation Instructions

Clone into `wp-content/plugins` folder

#Navigating the codebase

The base of this plugin is from this repository
https://github.com/DevinVinson/WordPress-Plugin-Boilerplate

I used it because it provides the separation of concerns necessary to keep
a large project organised, and as I am new to Wordpress any attempt I made on my
own to do this would likely be suboptimal. It also exposes the necessary functions
that make internationalization easier.

The admin specific functionality is found  in `admin/class-trial-project-admin.php`.
This comprises the backend record management and the code to index new posts by
letter.

The public facing functionality is found in `public/class-trial-project-public.php`.
This comprises the rendering of the record view that occurs when the shortcode is
parsed. I chose to render through `echo "<html>"` statements rather than writing
HTML and echoing variables simply because the HTML was very light, and this allowed
me to comment more easily. If this display was going to require much more markup,
I would have chosen a `foreach():` `endforeach;` syntax.

Also in the public folder is the LESS and compiled CSS used in the record view. It uses Bootstrap
for responsive functionality but only imports the necessary selectors that I used to
style the archive. This keeps the HTML semantic, since I don't use row or column classes,
and avoids requiring Bootstrap as a plugin dependency, which would break any site
that is designed to function without Bootstrap.

To compile CSS from source, install Node.js and LESSCSS; then run the command

`lessc public/css/trial-project-public.less > public/css/trial-project-public.css`;

The `css/bootstrap` folder and `css/trial-project-public.less` files can be
safely deleted, as they are only source files for the CSS compilation.

The other point of interest is the `includes/class-trial-project.php` file that
ties the admin and public files together. The function `define_admin_hooks()`
binds the functions defined in `admin/class-trial-project-admin.php` to the action
and filter hooks WordPress runs. The function `define_public_hooks()` does the
same for the public hooks. I also define the shortcode in this block.
